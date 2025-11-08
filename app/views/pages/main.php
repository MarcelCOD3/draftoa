<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$lang = $_SESSION['lang'] ?? 'es';

$loginError = $_SESSION['loginError'] ?? '';
$showLoginModal = $_SESSION['showLoginModal'] ?? false;
unset($_SESSION['loginError'], $_SESSION['showLoginModal']);

$isLoggedIn = !empty($_SESSION['nickname']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langTexts['siteTitle'] ?? 'Draftosaurus - Juego de Mesa Digital' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="/draftosaurus/public/css/styles.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/navbar.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/views/main.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/footer.css">
</head>

<body>
    <div id="app" class="d-flex flex-column min-vh-100">
        <?php require_once __DIR__ . '/../layouts/navbar.php'; ?>

        <main class="hero-section flex-grow-1">
            <section class="hero">
                <div class="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/draftosaurus/public/img/carousel4.jpg"
                                alt="<?= $langTexts['altCarousel1'] ?? 'Piezas de dinosaurios coloridas' ?>">
                            <div class="carousel-overlay"></div>
                            <div class="carousel-content">
                                <h1 class="hero-title">
                                    <?= $langTexts['heroTitle1'] ?? 'UN JUEGO PARA TODA LA FAMILIA' ?>
                                </h1>
                                <p class="hero-subtitle">
                                    <?= $langTexts['heroSubtitle1'] ?? 'Diviértete con nuestros dinosaurios y devora a tus amigos.' ?>
                                </p>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img src="/draftosaurus/public/img/carousel1.jpg"
                                alt="<?= $langTexts['altCarousel2'] ?? 'Cartas y fichas del juego' ?>">
                            <div class="carousel-overlay"></div>
                            <div class="carousel-content">
                                <h1 class="hero-title"><?= $langTexts['heroTitle2'] ?? 'ESTRATEGIA Y DIVERSIÓN' ?></h1>
                                <p class="hero-subtitle">
                                    <?= $langTexts['heroSubtitle2'] ?? 'Colecciona dinosaurios y construye el mejor parque jurásico.' ?>
                                </p>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img src="/draftosaurus/public/img/carousel2.jpg"
                                alt="<?= $langTexts['altCarousel3'] ?? 'Niños jugando juntos' ?>">
                            <div class="carousel-overlay"></div>
                            <div class="carousel-content">
                                <h1 class="hero-title"><?= $langTexts['heroTitle3'] ?? 'MOMENTOS INOLVIDABLES' ?></h1>
                                <p class="hero-subtitle">
                                    <?= $langTexts['heroSubtitle3'] ?? 'Crea recuerdos épicos con tu familia y amigos.' ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-indicators">
                        <span class="indicator active" onclick="goToSlide(0)"
                            title="<?= $langTexts['goSlide1'] ?? 'Ir al slide 1' ?>"></span>
                        <span class="indicator" onclick="goToSlide(1)"
                            title="<?= $langTexts['goSlide2'] ?? 'Ir al slide 2' ?>"></span>
                        <span class="indicator" onclick="goToSlide(2)"
                            title="<?= $langTexts['goSlide3'] ?? 'Ir al slide 3' ?>"></span>
                    </div>
                </div>

                <div class="hero-buttons text-center mt-4">
                    <button type="button" class="btn btn-custom me-2" data-bs-toggle="modal"
                        data-bs-target="#trackingModal" title="<?= $langTexts['tracking'] ?? 'Seguimiento' ?>">
                        <i class="fas fa-map-marker-alt me-2"></i><?= $langTexts['tracking'] ?? 'Seguimiento' ?>
                    </button>

                    <?php if ($isLoggedIn): ?>
                    <a href="/draftosaurus/public/index.php?page=game" class="btn btn-custom"
                        title="<?= $langTexts['startGame'] ?? 'Comenzar Partida' ?>">
                        <i class="fas fa-play me-2"></i><?= $langTexts['startGame'] ?? 'Comenzar Partida' ?>
                    </a>
                    <?php endif; ?>
                </div>
            </section>

            <section class="features">
                <div class="container">
                    <div class="feature-card">
                        <div class="feature-icon">🦕</div>
                        <h3><?= $langTexts['featureEasyTitle'] ?? 'Fácil de aprender' ?></h3>
                        <p><?= $langTexts['featureEasyText'] ?? 'Reglas simples que todos pueden entender en minutos' ?>
                        </p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🎲</div>
                        <h3><?= $langTexts['featureFastTitle'] ?? 'Rápido y dinámico' ?></h3>
                        <p><?= $langTexts['featureFastText'] ?? 'Partidas de 15 minutos llenas de decisiones emocionantes' ?>
                        </p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">👨‍👩‍👧‍👦</div>
                        <h3><?= $langTexts['featureFamilyTitle'] ?? 'Para toda la familia' ?></h3>
                        <p><?= $langTexts['featureFamilyText'] ?? 'De 8 a 99 años, diversión garantizada para todos' ?>
                        </p>
                    </div>
                </div>
            </section>
        </main>

        <?php require_once __DIR__ . '/../layouts/footer.php'; ?>
    </div>

    <div class="modal fade" id="trackingModal" tabindex="-1" aria-labelledby="trackingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-dark">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-map-marker-alt me-2"></i><?= $langTexts['tracking'] ?? 'Seguimiento' ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="<?= $langTexts['close'] ?? 'Cerrar' ?>"
                        title="<?= $langTexts['close'] ?? 'Cerrar' ?>"></button>
                </div>

                <div class="modal-body">
                    <form id="trackingForm" action="/draftosaurus/public/index.php?page=tracking" method="POST">
                        <div class="mb-3">
                            <label for="numPlayers"
                                class="form-label"><?= $langTexts['numPlayers'] ?? 'Cantidad de jugadores' ?></label>
                            <select class="form-select" id="numPlayers" name="numPlayers" required
                                title="<?= $langTexts['numPlayers'] ?? 'Cantidad de jugadores' ?>">

                                <option value=""><?= $langTexts['select'] ?? 'Seleccione...' ?></option>
                                <option value="2">2 <?= $langTexts['players'] ?? 'jugadores' ?></option>
                                <option value="3">3 <?= $langTexts['players'] ?? 'jugadores' ?></option>
                                <option value="4">4 <?= $langTexts['players'] ?? 'jugadores' ?></option>
                                <option value="5">5 <?= $langTexts['players'] ?? 'jugadores' ?></option>
                            </select>
                        </div>

                        <div id="playerInputs"></div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                title="<?= $langTexts['close'] ?? 'Cerrar' ?>"
                                data-bs-dismiss="modal"><?= $langTexts['close'] ?? 'Cerrar' ?></button>
                            <button type="submit" class="btn btn-custom"
                                title="<?= $langTexts['continue'] ?? 'Continuar' ?>">

                                <i class="fas fa-play me-2"></i><?= $langTexts['continue'] ?? 'Continuar' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/draftosaurus/public/js/main.js"></script>

</body>

</html>