document.addEventListener("DOMContentLoaded", () => {
  const toggleButtons = document.querySelectorAll(".toggle-password");

  toggleButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const modal = btn.closest(".modal");
      const input = modal.querySelector(
        ".toggle-password-input[type='password'], .toggle-password-input[type='text']"
      );

      if (input.type === "password") {
        input.type = "text";
        btn.querySelector("i").classList.remove("fa-eye");
        btn.querySelector("i").classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        btn.querySelector("i").classList.remove("fa-eye-slash");
        btn.querySelector("i").classList.add("fa-eye");
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const forgotLink = document.getElementById("forgotPasswordLink");
  if (forgotLink) {
    forgotLink.addEventListener("click", function (e) {
      e.preventDefault();
      const loginModal = bootstrap.Modal.getInstance(
        document.getElementById("loginModal")
      );
      loginModal.hide();

      const forgotModal = new bootstrap.Modal(
        document.getElementById("forgotPasswordModal")
      );
      forgotModal.show();
    });
  }
});
