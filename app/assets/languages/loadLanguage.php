<?php
// Inicia sesión si no hay ninguna activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Manejo de idioma
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'en' ? 'en' : 'es';
}
$lang = $_SESSION['lang'] ?? 'es';

// Ruta del archivo de idioma
$langFile = __DIR__ . '/../languages/' . $lang . '.php';

// Incluye los textos del idioma seleccionado, si no existe, fallback a español
if (file_exists($langFile)) {
    include $langFile;
} else {
    include __DIR__ . '/../languages/es.php';
}

// $langTexts contendrá los textos que usarán las vistas