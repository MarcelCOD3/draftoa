<?php
// Inicia sesion solo si no hay ninguna sesion activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nickname = $_SESSION['nickname'] ?? null;
$page = basename($_GET['page'] ?? 'main');

// Asegurarnos de que $langTexts (traductor) exista
if (!isset($langTexts)) {
    $langTexts = [];
}
?>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="/draftosaurus/public/index.php?page=main"
            title="<?= $langTexts['home'] ?? 'Inicio' ?>">
            Draftosaurus
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" title="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'main' ? 'active' : '' ?>"
                        href="/draftosaurus/public/index.php?page=main" title="<?= $langTexts['home'] ?? 'Inicio' ?>">
                        <i class="fas fa-home me-2"></i><?= $langTexts['home'] ?? 'Inicio' ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'rules' ? 'active' : '' ?>"
                        href="/draftosaurus/public/index.php?page=rules" title="<?= $langTexts['rules'] ?? 'Reglas' ?>">
                        <i class="fas fa-book me-2"></i><?= $langTexts['rules'] ?? 'Reglas' ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'ranking' ? 'active' : '' ?>"
                        href="/draftosaurus/public/index.php?page=ranking"
                        title="<?= $langTexts['ranking'] ?? 'Ranking' ?>">
                        <i class="fas fa-trophy me-2"></i><?= $langTexts['ranking'] ?? 'Ranking' ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'register' ? 'active' : '' ?>"
                        href="/draftosaurus/public/index.php?page=register"
                        title="<?= $langTexts['register'] ?? 'Registro' ?>">
                        <i class="fas fa-user-plus me-2"></i><?= $langTexts['register'] ?? 'Registro' ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'miniGame' ? 'active' : '' ?>"
                        href="/draftosaurus/public/index.php?page=miniGame"
                        title="<?= $langTexts['dino runner'] ?? 'Correcadinos' ?>">
                        <i class="fas fa-running me-2"></i><?= $langTexts['dino runner'] ?? 'Correcadinos' ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'about' ? 'active' : '' ?>"
                        href="/draftosaurus/public/index.php?page=about"
                        title="<?= $langTexts['about'] ?? 'Sobre Nosotros' ?>">
                        <i class="fas fa-info-circle me-2"></i><?= $langTexts['about'] ?? 'Sobre Nosotros' ?>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" title=<?= $langTexts['language'] ?? 'Idioma' ?>>
                        <i class="fas fa-globe me-1"></i><?= $langTexts['language'] ?? 'Idioma' ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                        <li>
                            <a class="dropdown-item" href="/draftosaurus/public/index.php?page=<?= $page ?>&lang=en"
                                title="<?= $langTexts['english'] ?? 'Inglés' ?>">
                                <img src="/draftosaurus/public/img/en-flag.jpg" alt="English" width="20" class="me-2">
                                <?= $langTexts['english'] ?? 'Inglés' ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/draftosaurus/public/index.php?page=<?= $page ?>&lang=es"
                                title="<?= $langTexts['spanish'] ?? 'Español' ?>">
                                <img src="/draftosaurus/public/img/es-flag.png" alt="Español" width="20" class="me-2">
                                <?= $langTexts['spanish'] ?? 'Español' ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="ms-auto d-flex gap-2 align-items-center">
            <?php if (!empty($nickname)): ?>
            <div class="dropdown">
                <a class="btn btn-custom dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    title="<?= $langTexts['myProfile'] ?? 'Mi Perfil' ?>">
                    <i class="fas fa-user-circle me-2"></i><?= htmlspecialchars($nickname) ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item"
                            href="/draftosaurus/public/index.php?page=userProfile&nickname=<?= urlencode($nickname) ?>"
                            title="<?= $langTexts['myProfile'] ?? 'Mi Perfil' ?>">
                            <i class="fas fa-id-badge me-2"></i><?= $langTexts['myProfile'] ?? 'Mi Perfil' ?>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                    <li>
                        <a class="dropdown-item" href="/draftosaurus/public/index.php?page=adminPanel"
                            title="<?= $langTexts['adminPanel'] ?? 'Panel Admin' ?>">
                            <i class="fas fa-tools me-2"></i><?= $langTexts['adminPanel'] ?? 'Panel Admin' ?>
                        </a>
                    </li>
                    <?php endif; ?>
                    <form method="post" style="margin:0;">
                        <button type="submit" name="logout" class="dropdown-item"
                            title="<?= $langTexts['logout'] ?? 'Cerrar sesión' ?>">
                            <i class="fas fa-sign-out-alt me-2"></i><?= $langTexts['logout'] ?? 'Cerrar sesión' ?>
                        </button>
                    </form>
                </ul>
            </div>
            <?php else: ?>
            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#loginModal"
                title="<?= $langTexts['login'] ?? 'Iniciar sesión' ?>">
                <i class="fas fa-door-open me-2"></i><?= $langTexts['login'] ?? 'Iniciar sesión' ?>
            </button>

            <?php endif; ?>
        </div>
    </div>
</nav>

<?php if (!empty($_SESSION['showLoginModal'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    loginModal.show();
});
</script>
<?php unset($_SESSION['showLoginModal']); ?>
<?php endif; ?>

<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-dark">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-door-open me-2"></i><?= $langTexts['login'] ?? 'Iniciar Sesión' ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"
                    title="<?= $langTexts['close'] ?? 'Cerrar' ?>"></button>
            </div>
            <div class="modal-body">
                <div id="login-alert">
                    <?php if (!empty($_SESSION['loginError'])): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($_SESSION['loginError']) ?>
                    </div>
                    <?php unset($_SESSION['loginError']); ?>
                    <?php endif; ?>
                </div>
                <form method="POST">
                    <input type="hidden" name="login" value="1">
                    <input type="hidden" name="current_query"
                        value="<?= htmlspecialchars($_SERVER['QUERY_STRING'] ?? 'page=main') ?>">

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control toggle-password-input" name="email"
                                placeholder="<?= $langTexts['email'] ?? 'Correo electrónico' ?>" required
                                title="<?= $langTexts['email'] ?? 'Correo electrónico' ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control toggle-password-input" name="password"
                                placeholder="<?= $langTexts['password'] ?? 'Contraseña' ?>" required
                                title="<?= $langTexts['password'] ?? 'Contraseña' ?>">
                            <span class="input-group-text toggle-password" data-target=".toggle-password-input"
                                title="<?= $langTexts['show-hide'] ?? 'Contraseña' ?>">
                                <i class=" fas fa-eye"></i>
                            </span>
                        </div>
                        <p class="text-center mt-2">
                            <a href="#"
                                id="forgotPasswordLink"><?= $langTexts['forgotPassword'] ?? 'Olvidé mi contraseña' ?></a>
                        </p>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            title="<?= $langTexts['close'] ?? 'Cerrar' ?>">
                            <?= $langTexts['close'] ?? 'Cerrar' ?>
                        </button>
                        <button type="submit" class="btn btn-custom" title="<?= $langTexts['enter'] ?? 'Entrar' ?>">
                            <i class="fas fa-door-open me-2"></i><?= $langTexts['enter'] ?? 'Entrar' ?>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-dark">
            <div class="modal-header">
                <h5 class="modal-title"><?= $langTexts['resetPassword'] ?? 'Recuperar contraseña' ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($_SESSION['forgotMessage'])): ?>
                <div class="alert <?= $_SESSION['forgotClass'] ?? 'alert-info' ?> text-center">
                    <?= $_SESSION['forgotMessage'] ?>
                </div>
                <?php unset($_SESSION['forgotMessage'], $_SESSION['forgotClass']); ?>
                <?php endif; ?>

                <form method="POST" action="/draftosaurus/public/index.php?page=forgotPassword">
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control" name="email"
                                placeholder="<?= $langTexts['email'] ?? 'Correo electrónico' ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal"><?= $langTexts['close'] ?? 'Cerrar' ?></button>
                        <button type="submit"
                            class="btn btn-custom"><?= $langTexts['sendLink'] ?? 'Enviar enlace' ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="/draftosaurus/public/js/navbar.js"></script>