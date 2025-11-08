<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$lang = $_SESSION['lang'] ?? 'es';
$loginError = $_SESSION['loginError'] ?? '';
$showLoginModal = $_SESSION['showLoginModal'] ?? false;
unset($_SESSION['loginError'], $_SESSION['showLoginModal']);

require_once __DIR__ . '/../../controllers/RankingController.php';
require_once __DIR__ . '/../../controllers/UserController.php';

$rankingController = new RankingController();
$userController = new UserController();
$jugadores = $rankingController->getPlayers();
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draftosaurus - <?= $langTexts['rankingTitle'] ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="/draftosaurus/public/css/styles.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/navbar.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/footer.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/views/ranking.css">
</head>

<body>
    <div id="app" class="d-flex flex-column min-vh-100">

        <?php include __DIR__ . '/../layouts/navbar.php'; ?>

        <main class="home-container flex-grow-1">
            <h1 class="title text-center"><?= $langTexts['rankingHeader'] ?></h1>

            <div class="table-responsive mt-4">
                <table class="table table-hover ranking-table text-center w-100">
                    <thead>
                        <tr>
                            <th><?= $langTexts['rankingPosition'] ?></th>
                            <th><?= $langTexts['rankingUser'] ?></th>
                            <th><?= $langTexts['rankingGames'] ?></th>
                            <th><?= $langTexts['rankingWins'] ?></th>
                            <th><?= $langTexts['rankingPoints'] ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jugadores as $jugador): ?>
                        <tr>
                            <th>
                                <?php
                                if ($jugador['pos'] == 1) echo '<i class="bi bi-trophy-fill text-warning"></i> 1';
                                elseif ($jugador['pos'] == 2) echo '<i class="bi bi-trophy-fill text-secondary"></i> 2';
                                elseif ($jugador['pos'] == 3) echo '<i class="bi bi-trophy-fill" style="color: peru;"></i> 3';
                                else echo $jugador['pos'];
                                ?>
                            </th>
                            <td>
                                <a class="ranking-link"
                                    href="/draftosaurus/public/index.php?page=userProfile&nickname=<?= urlencode($jugador['nickname']) ?>">
                                    <?= htmlspecialchars($jugador['nickname']) ?>
                                </a>
                            </td>
                            <td><?= $jugador['partidas'] ?? 0 ?></td>
                            <td><?= $jugador['victorias'] ?? 0 ?></td>
                            <td><?= $jugador['puntaje'] ?? 0 ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>

        <?php include __DIR__ . '/../layouts/footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>