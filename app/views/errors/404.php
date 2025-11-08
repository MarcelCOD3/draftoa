<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar textos según idioma
require_once $_SERVER['DOCUMENT_ROOT'] . '/draftosaurus/app/assets/languages/loadLanguage.php';?>

<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'es' ?>">

<head>
    <meta charset="UTF-8">
    <title>404 - <?= $langTexts['404_title'] ?? 'Página no encontrada' ?></title>
    <link rel="stylesheet" href="/draftosaurus/public/css/views/404.css">
</head>

<body>
    <div class="error-container">
        <h1>404</h1>
        <h2><?= $langTexts['404_heading'] ?? 'Oops! Página no encontrada' ?></h2>
        <a href="/draftosaurus/public/index.php?page=main" class="btn-home">
            <?= $langTexts['404_button'] ?? 'Volver al inicio' ?>
        </a>
    </div>
</body>

</html>