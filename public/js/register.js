document.addEventListener("DOMContentLoaded", function () {
  const registerBtn = document.getElementById("registerBtn");
  const acceptTerms = document.getElementById("acceptTerms");
  const nickname = document.getElementById("nickname");
  const nicknameStatus = document.getElementById("nicknameStatus");

  if (acceptTerms && registerBtn) {
    acceptTerms.addEventListener("change", () => {
      registerBtn.disabled = !acceptTerms.checked;
    });
  }

  // Validación de nickname
  if (nickname && nicknameStatus) {
    nickname.addEventListener("input", () => {
      if (nickname.value.trim() === "") {
        nickname.classList.remove("is-valid", "is-invalid");
        nicknameStatus.innerHTML = "";
        return;
      }

      fetch(
        `../controllers/checknickname.php?nickname=${encodeURIComponent(
          nickname.value
        )}`
      )
        .then((res) => res.json())
        .then((data) => {
          nickname.classList.remove("is-valid", "is-invalid");
          nicknameStatus.innerHTML = "";
          if (data.available) {
            nickname.classList.add("is-valid");
            nicknameStatus.innerHTML =
              '<i class="fas fa-check" style="color:#28a745"></i>';
          } else {
            nickname.classList.add("is-invalid");
            nicknameStatus.innerHTML =
              '<i class="fas fa-times" style="color:#ff6b00"></i>';
          }
        });
    });
  }

  document.querySelectorAll(".toggle-password").forEach((toggle) => {
    toggle.addEventListener("click", () => {
      const targetSelector = toggle.dataset.target;
      if (!targetSelector) return;

      const input = document.querySelector(targetSelector);
      if (!input) return;

      input.type = input.type === "password" ? "text" : "password";

      const icon = toggle.querySelector("i");
      if (icon) {
        icon.classList.toggle("fa-eye");
        icon.classList.toggle("fa-eye-slash");
      }
    });
  });
});
