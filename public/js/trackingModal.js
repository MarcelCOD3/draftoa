document.addEventListener("DOMContentLoaded", function () {
  const numPlayersSelect = document.getElementById("numPlayers");
  const playerInputsDiv = document.getElementById("playerInputs");
  const trackingForm = document.getElementById("trackingForm");
  const submitButton = trackingForm.querySelector('button[type="submit"]');

  // Desactivar botón hasta que haya inputs
  submitButton.disabled = true;

  numPlayersSelect.addEventListener("change", function () {
    const count = parseInt(this.value);
    playerInputsDiv.innerHTML = ""; // limpiar anteriores

    if (!isNaN(count)) {
      for (let i = 1; i <= count; i++) {
        const div = document.createElement("div");
        div.classList.add("mb-3");
        div.innerHTML = `
          <label for="player${i}" class="form-label">Nombre del jugador ${i}</label>
          <input type="text" class="form-control" id="player${i}" name="players[]" 
                 maxlength="12" required placeholder="Ej: DinoMaster${i}">
        `;
        playerInputsDiv.appendChild(div);
      }
      submitButton.disabled = false; // habilitar botón cuando se crean los inputs
    } else {
      submitButton.disabled = true;
    }
  });

  trackingForm.addEventListener("submit", function (e) {
    const inputs = trackingForm.querySelectorAll('input[name="players[]"]');
    for (const input of inputs) {
      if (input.value.trim() === "") {
        e.preventDefault();
        alert("⚠️ Todos los nombres deben estar completos.");
        return;
      }
    }
  });
});
