<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ No necesitamos requerir RecoveryPassController aquí, ya lo hace index.php
$token = $_GET['token'] ?? null;
$resetMessage = $_SESSION['resetMessage'] ?? '';
$resetClass = $_SESSION['resetClass'] ?? '';
unset($_SESSION['resetMessage'], $_SESSION['resetClass']);

// Solo mostramos el formulario si hay token
$showForm = !empty($token);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña - Draftosaurus</title>
    <link rel="stylesheet" href="/draftosaurus/public/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card bg-dark text-light p-4 shadow-lg" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-3">Restablecer Contraseña</h3>

            <?php if ($resetMessage): ?>
            <div class="alert <?= $resetClass ?>"><?= htmlspecialchars($resetMessage) ?></div>
            <?php endif; ?>

            <?php if ($showForm): ?>
            <form method="POST" action="/draftosaurus/public/index.php?page=resetPassword">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

                <div class="mb-3">
                    <label for="new_password" class="form-label">Nueva contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control toggle-password-input" id="new_password"
                            name="new_password" placeholder="Nueva contraseña" required>
                        <span class="input-group-text toggle-password" data-target="#new_password"><i
                                class="fas fa-eye"></i></span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmar contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control toggle-password-input" id="confirm_password"
                            name="confirm_password" placeholder="Confirmar contraseña" required>
                        <span class="input-group-text toggle-password" data-target="#confirm_password"><i
                                class="fas fa-eye"></i></span>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/draftosaurus/public/index.php?page=main" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-custom">Actualizar contraseña</button>
                </div>
            </form>
            <?php else: ?>
            <div class="text-center mt-3">
                <a href="/draftosaurus/public/index.php?page=login" class="btn btn-custom">Iniciar sesión</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const toggleButtons = document.querySelectorAll(".toggle-password");
        toggleButtons.forEach(btn => {
            btn.addEventListener("click", () => {
                const targetInput = document.querySelector(btn.dataset.target);
                if (targetInput.type === "password") {
                    targetInput.type = "text";
                    btn.querySelector("i").classList.replace("fa-eye", "fa-eye-slash");
                } else {
                    targetInput.type = "password";
                    btn.querySelector("i").classList.replace("fa-eye-slash", "fa-eye");
                }
            });
        });
    });
    </script>

</body>

</html>