document.addEventListener("DOMContentLoaded", () => {
  let currentPlayer = 0;
  const playerScores = players.map(() => Array(7).fill(0));
  const playerSpecies = players.map(() => Array(7).fill(null));
  const visited = players.map(() => false);

  const avatarsContainer = document.getElementById("avatarsContainer");
  const currentPlayerTitle = document.getElementById("currentPlayerTitle");
  const nextBtn = document.getElementById("nextBtn");
  const finishBtn = document.getElementById("finishBtn");
  const winnerModalEl = document.getElementById("winnerModal");

  const avatarImages = [
    "2d-blue.PNG",
    "2d-green.PNG",
    "2d-orange.PNG",
    "2d-pink.png",
    "2d-red.PNG",
    "2d-yellow.PNG",
  ];
  const avatarColors = {
    "2d-blue.PNG": "#007bff",
    "2d-green.PNG": "#28a745",
    "2d-orange.PNG": "#fd7e14",
    "2d-pink.png": "#e83e8c",
    "2d-red.PNG": "#dc3545",
    "2d-yellow.PNG": "#ffc107",
  };

  const shuffledImages = [...avatarImages]
    .sort(() => Math.random() - 0.5)
    .slice(0, players.length);

  // Crear avatares
  players.forEach((name, i) => {
    const imgFile = shuffledImages[i];
    const div = document.createElement("div");
    div.classList.add("avatar");
    div.dataset.index = i;
    div.dataset.imgFile = imgFile;
    div.innerHTML = `
      <img src="/draftosaurus/public/img/${imgFile}" class="avatar-img"/>
      <div class="avatar-name">${name}</div>
      <div class="tick-mark" style="display:none;">✔</div>
    `;
    avatarsContainer.appendChild(div);
    div.addEventListener("click", () => {
      currentPlayer = i;
      updateAvatars();
      loadScores();
    });
  });

  const updateAvatars = () => {
    document.querySelectorAll(".avatar").forEach((el, i) => {
      const img = el.querySelector(".avatar-img");
      const tick = el.querySelector(".tick-mark");
      const color = avatarColors[el.dataset.imgFile] || "#888";
      img.style.borderColor = i === currentPlayer ? "#fff" : color;
      img.style.boxShadow = i === currentPlayer ? "0 0 8px #fff" : "none";
      tick.style.display = visited[i] ? "block" : "none";
    });
  };

  const loadScores = () => {
    currentPlayerTitle.textContent = `Dino-Puntaje de ${players[currentPlayer]}`;
    for (let z = 1; z <= 7; z++) {
      const input = document.getElementById(`zone${z}Input`);
      input.value = playerScores[currentPlayer][z - 1] || 0;
      const radios = document.getElementsByName(`zone${z}Species`);
      if (radios) {
        radios.forEach(
          (r) => (r.checked = playerSpecies[currentPlayer][z - 1] === r.value)
        );
      }
    }
  };

  const maxValues = [6, 1, 12, 12, 6, 1, 12];

  const saveScores = () => {
    const radiosZone4 = document.getElementsByName("zone4Species");
    const selectedZone4 = [...radiosZone4].find((r) => r.checked);
    if (!selectedZone4) {
      alert("No seleccionó su Dino-Rey. Puntaje de esta zona será 0.");
      return false;
    }

    for (let z = 1; z <= 7; z++) {
      const input = document.getElementById(`zone${z}Input`);
      let val = parseInt(input.value);
      if (isNaN(val) || val < 0 || val > maxValues[z - 1])
        val = Math.min(Math.max(val || 0, 0), maxValues[z - 1]);
      playerScores[currentPlayer][z - 1] = val;

      const radios = document.getElementsByName(`zone${z}Species`);
      if (radios) {
        const sel = [...radios].find((r) => r.checked);
        playerSpecies[currentPlayer][z - 1] = sel
          ? sel.value === "none"
            ? null
            : sel.value
          : null;
        if (z === 4 && !sel) playerScores[currentPlayer][3] = 0;
      }
    }
    visited[currentPlayer] = true;
    updateAvatars();
    return true;
  };

  const calculateZonePoints = (zoneIndex, value) => {
    switch (zoneIndex) {
      case 0:
        return [0, 2, 4, 8, 12, 18, 24][value] || 0;
      case 1:
        return value === 1 ? 7 : 0;
      case 2:
        return value * 5;
      case 3:
        return 0;
      case 4:
        return [0, 1, 3, 6, 10, 15, 21][value] || 0;
      case 5:
        return value * 7;
      case 6:
        return value;
      default:
        return value;
    }
  };

  const calculateTotal = (scores) =>
    scores.reduce((total, val, i) => total + calculateZonePoints(i, val), 0);

  const checkButtons = () => {
    if (visited.every((v) => v)) {
      nextBtn.style.display = "none";
      finishBtn.style.display = "inline-block";
    }
  };

  nextBtn.addEventListener("click", () => {
    if (!saveScores()) return;
    const nextIndex = visited.findIndex((v, i) => !v && i !== currentPlayer);
    if (nextIndex !== -1) currentPlayer = nextIndex;
    loadScores();
    updateAvatars();
    checkButtons();
  });

  finishBtn.addEventListener("click", () => {
    if (!saveScores()) return;

    const totals = players.map((p, i) => {
      return {
        name: p,
        baseTotal: calculateTotal(playerScores[i]),
        scores: [...playerScores[i]],
        dinoReyValue: playerScores[i][3],
        dinoReySpecies: playerSpecies[i][3],
        extraDinoRey: false,
      };
    });

    const maxPerSpecies = {};
    totals.forEach((t) => {
      if (!t.dinoReySpecies) return;
      if (
        !maxPerSpecies[t.dinoReySpecies] ||
        t.dinoReyValue > maxPerSpecies[t.dinoReySpecies]
      ) {
        maxPerSpecies[t.dinoReySpecies] = t.dinoReyValue;
      }
    });

    totals.forEach((t) => {
      const species = t.dinoReySpecies;
      const val = t.dinoReyValue;
      if (species && val === maxPerSpecies[species] && val > 0) {
        t.baseTotal += 7;
        t.extraDinoRey = true;
      }
    });

    const sortedTotals = totals.sort((a, b) => b.baseTotal - a.baseTotal);

    document.getElementById(
      "winnerTitle"
    ).innerHTML = `🏆 GANADOR: ${sortedTotals[0].name}`;

    document.getElementById("winnerList").innerHTML = sortedTotals
      .map((t, i) => {
        return `
        <div class="winner-player">
          <span>${t.name}: ${t.baseTotal} puntos</span>
          <button class="btn btn-sm btn-outline-info ms-2" data-bs-toggle="collapse" data-bs-target="#playerDetail${i}">
            i
          </button>
          <div class="collapse mt-2" id="playerDetail${i}">
            ${t.scores
              .map((s, z) => {
                switch (z) {
                  case 0:
                    return `<p>Zona 1: ${s} dinos iguales = ${calculateZonePoints(
                      z,
                      s
                    )} pts</p>`;
                  case 1:
                    return `<p>Zona 2: ${s} trío frondoso = ${calculateZonePoints(
                      z,
                      s
                    )} pts</p>`;
                  case 2:
                    return `<p>Zona 3: ${s} parejas de dinos = ${calculateZonePoints(
                      z,
                      s
                    )} pts</p>`;
                  case 3:
                    if (!t.dinoReySpecies)
                      return `<p>Zona 4: No seleccionó Dino-Rey, puntaje 0</p>`;
                    return `<p>Zona 4: Especie ${t.dinoReySpecies}, cantidad ${
                      t.dinoReyValue
                    } ${t.extraDinoRey ? "→ más que todos +7 pts" : ""}</p>`;
                  case 4:
                    return `<p>Zona 5: ${s} dinos diferentes = ${calculateZonePoints(
                      z,
                      s
                    )} pts</p>`;
                  case 5:
                    return `<p>Zona 6: ${s} dinos solitarios = ${calculateZonePoints(
                      z,
                      s
                    )} pts</p>`;
                  case 6:
                    return `<p>Zona 7: ${s} dinos en río = ${calculateZonePoints(
                      z,
                      s
                    )} pts</p>`;
                  default:
                    return "";
                }
              })
              .join("")}
          </div>
        </div>
      `;
      })
      .join("");

    new bootstrap.Modal(winnerModalEl).show();
  });

  document.getElementById("newGameBtn").addEventListener("click", () => {
    playerScores.forEach((arr, i) => (playerScores[i] = Array(7).fill(0)));
    playerSpecies.forEach((arr, i) => (playerSpecies[i] = Array(7).fill(null)));
    visited.fill(false);
    currentPlayer = 0;
    nextBtn.style.display = "inline-block";
    finishBtn.style.display = "none";
    loadScores();
    updateAvatars();
    bootstrap.Modal.getInstance(winnerModalEl)?.hide();
  });

  document.getElementById("closeWinnerBtn").addEventListener("click", () => {
    window.location.href = "/draftosaurus/public/index.php?page=main";
  });

  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  [...tooltipTriggerList].forEach((el) => new bootstrap.Tooltip(el));

  loadScores();
  updateAvatars();
});
