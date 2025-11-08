<?php
require_once __DIR__ . '/../../models/DinosaurModel.php';

$dinosaurModel = new DinosaurModel();
$dinosaurs = $dinosaurModel->getAllDinosaurs();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dino Runner - Draftosaurus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/draftosaurus/public/css/styles.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/navbar.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/footer.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/views/minigame.css">

</head>

<body>
    <div id="app" class="d-flex flex-column min-vh-100">

        <?php require_once __DIR__ . '/../layouts/navbar.php'; ?>

        <main class="container text-center flex-grow-1 py-4">
            <h1 class="minigame-title">Elige tu Runner</h1>
            <p class="minigame-subtitle">Pasa el mouse sobre un dinosaurio para ver sus estadísticas</p>
            <button class="btn btn-sm btn-outline-light mt-3" id="change-music-btn" style="font-family: 'Press Start 2P', cursive; font-size: 0.7rem;">Música: Original</button>
            
            <div id="dino-selector-gallery">
                <?php foreach ($dinosaurs as $dino): ?>
                <div class="dino-card" data-id="<?php echo htmlspecialchars($dino['dino_id']); ?>">
                    <div class="dino-sprite-preview">
                        <img src="/draftosaurus/public/img/sprites/<?php echo htmlspecialchars($dino['sprite_frame1']); ?>"
                            alt="<?php echo htmlspecialchars($dino['species']); ?>">
                    </div>
                    <div id="dino-tooltip">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <button class="btn btn-success btn-lg mt-3" id="start-game-btn" disabled>Empezar Juego</button>

            <div id="game-container" class="mt-4">
                <img id="mute-btn" src="/draftosaurus/public/img/icon-volume-on.png" alt="Mute Button">
                <canvas id="game-canvas" width="800" height="250"></canvas>
            </div>
        </main>

        <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const dinosaurs_data = <?php echo json_encode($dinosaurs); ?>;
    </script>
   <script src="/draftosaurus/public/js/dino_runner_game.js?v=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/draftosaurus/public/js/dino_runner_game.js'); ?>" defer></script>
</body>

</html>