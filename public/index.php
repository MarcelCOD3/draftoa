<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';




require_once __DIR__ . '/../app/controllers/RecoveryPassController.php';
$recoveryController = new RecoveryPassController();

require_once __DIR__ . '/../app/controllers/MessageController.php';
$messageController = new MessageController();


// Manejo de idioma
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'en' ? 'en' : 'es';
}

// Carga de idioma
require_once __DIR__ . '/../app/assets/languages/loadLanguage.php';

// Carga controlador de usuario
require_once __DIR__ . '/../app/controllers/UserController.php';
$userController = new UserController();

// Determina la página
$page = $_GET['page'] ?? 'index';
$page = basename($page);

// -----------------
// Manejo de recuperación de contraseña (forgotPassword)
// -----------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && $page === 'forgotPassword') {
    $email = trim($_POST['email']);
    $sent = $recoveryController->sendResetEmail($email);

    if ($sent) {
        $_SESSION['forgotMessage'] = "Se envió un enlace de recuperación a tu correo.";
        $_SESSION['forgotClass'] = "alert-success";
    } else {
        $_SESSION['forgotMessage'] = "No se encontró ningún usuario con ese correo.";
        $_SESSION['forgotClass'] = "alert-danger";
    }

    $_SESSION['showForgotModal'] = true;
    header("Location: /draftosaurus/public/index.php?page=main");
    exit();
}

// -----------------
// Manejo de restablecimiento de contraseña (resetPassword)
// -----------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'], $_POST['new_password'], $_POST['confirm_password']) && $page === 'resetPassword') {
    $token = $_POST['token'];
    $user = $recoveryController->verifyToken($token);

    if (!$user) {
        $_SESSION['resetMessage'] = "Token inválido o expirado.";
        $_SESSION['resetClass'] = "alert-danger";
    } else {
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($newPassword !== $confirmPassword) {
            $_SESSION['resetMessage'] = "Las contraseñas no coinciden.";
            $_SESSION['resetClass'] = "alert-danger";
        } elseif (strlen($newPassword) < 6) {
            $_SESSION['resetMessage'] = "La contraseña debe tener al menos 6 caracteres.";
            $_SESSION['resetClass'] = "alert-danger";
        } else {
            // ✅ Pasamos el token como tercer parámetro
            $recoveryController->updatePassword($user['user_id'], $newPassword, $token);
            $_SESSION['resetMessage'] = "Contraseña actualizada correctamente. Ya puedes iniciar sesión.";
            $_SESSION['resetClass'] = "alert-success";
        }
    }

    // Redirige al mismo resetPassword con token para mostrar mensaje
    header("Location: /draftosaurus/public/index.php?page=resetPassword&token=" . urlencode($token));
    exit();
}

// -----------------
// Manejo de login
// -----------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $redirectQuery = $_POST['current_query'] ?? 'page=' . $page;

    $result = $userController->login($email, $password);

    if ($result['success']) {
        header("Location: /draftosaurus/public/index.php?" . $redirectQuery);
        exit();
    } else {
        if (!empty($result['banned_until'])) {
            $bannedUntil = date('d/m/Y H:i', strtotime($result['banned_until']));
            $_SESSION['loginError'] = "Esta cuenta está baneada hasta el $bannedUntil.";
        } else {
            $_SESSION['loginError'] = "Correo o contraseña incorrectos";
        }
        $_SESSION['showLoginModal'] = true;
        header("Location: /draftosaurus/public/index.php?" . $redirectQuery);
        exit();
    }
}

// -----------------
// Manejo de logout
// -----------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    $userController->logout();
    exit();
}

// -----------------
// Manejo de formulario de contacto
// -----------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && isset($_POST['name'], $_POST['email'], $_POST['message']) 
    && $page === 'about') {

    $messageController->sendMessage($_POST['name'], $_POST['email'], $_POST['message']);
    header("Location: /draftosaurus/public/index.php?page=about#contact");
    exit();
}

$viewsPath = __DIR__ . '/../app/views/pages/';
$errorsPath = __DIR__ . '/../app/views/errors/';
$pageFile = $viewsPath . $page;  // sin extensión

// Si existe .php lo cargamos
if (file_exists($pageFile . '.php')) {
    include $pageFile . '.php';
// Si existe .html lo cargamos
} elseif (file_exists($pageFile . '.html')) {
    include $pageFile . '.html';
} else {
    http_response_code(404);
    include $errorsPath . '404.php';
}

?>