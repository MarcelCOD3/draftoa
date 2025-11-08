document.addEventListener("DOMContentLoaded", () => {
  // Carousel
  const slides = document.querySelectorAll(".carousel-item");
  const indicators = document.querySelectorAll(".indicator");
  let current = 0;
  const total = slides.length;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.toggle("active", i === index);
      indicators[i].classList.toggle("active", i === index);
    });
    current = index;
  }

  function nextSlide() {
    let next = (current + 1) % total;
    showSlide(next);
  }

  setInterval(nextSlide, 5000);

  indicators.forEach((indicator, i) => {
    indicator.addEventListener("click", () => showSlide(i));
  });

  // Modal de tracking (seguimiento)
  try {
    const numPlayersSelect = document.getElementById("numPlayers");
    const playerInputsDiv = document.getElementById("playerInputs");
    const trackingModalEl = document.getElementById("trackingModal");

    if (!numPlayersSelect || !playerInputsDiv || !trackingModalEl) {
      console.warn("⚠️ tracking modal elements not found:", {
        numPlayersSelect,
        playerInputsDiv,
        trackingModalEl,
      });
      return;
    }

    numPlayersSelect.addEventListener("change", () => {
      const count = parseInt(numPlayersSelect.value, 10);
      playerInputsDiv.innerHTML = "";

      if (!count || count < 1) return;

      for (let i = 1; i <= count; i++) {
        const wrapper = document.createElement("div");
        wrapper.className = "mb-3";

        const label = document.createElement("label");
        label.className = "form-label";
        label.textContent = `Jugador ${i}`;

        const input = document.createElement("input");
        input.type = "text";
        input.name = "players[]";
        input.className = "form-control";
        input.required = true;
        input.placeholder = `Dino Master ${i}`;

        wrapper.appendChild(label);
        wrapper.appendChild(input);
        playerInputsDiv.appendChild(wrapper);
      }
    });

    const triggerButtons = document.querySelectorAll(
      '[data-bs-toggle="modal"][data-bs-target="#trackingModal"]'
    );

    if (
      triggerButtons.length > 0 &&
      typeof bootstrap !== "undefined" &&
      bootstrap.Modal
    ) {
    } else if (triggerButtons.length > 0) {
      triggerButtons.forEach((btn) => {
        btn.addEventListener("click", (e) => {
          e.preventDefault();
          try {
            if (typeof bootstrap !== "undefined" && bootstrap.Modal) {
              const modal = new bootstrap.Modal(trackingModalEl);
              modal.show();
              return;
            }
            trackingModalEl.classList.add("show");
            trackingModalEl.style.display = "block";
            document.body.classList.add("modal-open");
          } catch (err) {
            console.error("No se pudo abrir modal por fallback:", err);
          }
        });
      });
    }
  } catch (err) {
    console.error("Error initializing tracking modal script:", err);
  }
});
