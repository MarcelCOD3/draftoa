<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$lang = $_SESSION['lang'] ?? 'es';
unset($_SESSION['loginError'], $_SESSION['showLoginModal']);
?>

<!doctype html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Draftosaurus - <?= $langTexts['rulesHeader'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/styles.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/navbar.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/views/rules.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/footer.css">
</head>

<body>
    <div id="app" class="d-flex flex-column min-vh-100">
        <?php require_once __DIR__ . '/../layouts/navbar.php'; ?>

        <main class="container flex-grow-1 ">
            <h1 class="title text-center"><?= $langTexts['rulesHeader'] ?></h1>

            <div class="accordion accordion-flush index my-4" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            <?= $langTexts['rulesIndex'] ?>
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul>
                                <li><a href="#index"><?= $langTexts['rule1'] ?></a></li>
                                <li><a href="#setup"><?= $langTexts['rule2'] ?></a></li>
                                <li><a href="#gameplay"><?= $langTexts['rule3'] ?></a></li>
                                <li><a href="#dinosaurpens"><?= $langTexts['rule4'] ?></a></li>
                                <li><a href="#summer"><?= $langTexts['rule5'] ?></a></li>
                                <li><a href="#dice"><?= $langTexts['rule6'] ?></a></li>
                                <li><a href="#winter"><?= $langTexts['rule7'] ?></a></li>
                                <li><a href="#extra"><?= $langTexts['rule8'] ?></a></li>
                                <li><a href="#video"><?= $langTexts['rule9'] ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rules-galery text-center mb-5">
                <?php if ($lang === 'en'): ?>
                <img src="/draftosaurus/public/img/rules1.png" class="rules mb-3" id="index" alt="Game Rules Page 1">
                <img src="/draftosaurus/public/img/rules2.png" class="rules mb-3" id="setup" alt="Game Rules Page 2">
                <img src="/draftosaurus/public/img/rules3.png" class="rules mb-3" id="gameplay" alt="Game Rules Page 3">
                <img src="/draftosaurus/public/img/rules4.png" class="rules mb-3" id="dinosaurpens"
                    alt="Game Rules Page 4">
                <img src="/draftosaurus/public/img/rules5.png" class="rules mb-3" id="summer" alt="Game Rules Page 5">
                <img src="/draftosaurus/public/img/rules6.png" class="rules mb-3" id="dice" alt="Game Rules Page 6">
                <img src="/draftosaurus/public/img/rules7.png" class="rules mb-3" id="winter" alt="Game Rules Page 7">
                <img src="/draftosaurus/public/img/rules8.png" class="rules mb-3" id="extra" alt="Game Rules Page 8">
                <?php else: ?>
                <img src="/draftosaurus/public/img/reglas1.png" class="rules mb-3" id="index" alt="Reglamento Pagina 1">
                <img src="/draftosaurus/public/img/reglas2.png" class="rules mb-3" id="setup" alt="Reglamento Pagina 2">
                <img src="/draftosaurus/public/img/reglas3.png" class="rules mb-3" id="gameplay"
                    alt="Reglamento Pagina 3">
                <img src="/draftosaurus/public/img/reglas4.png" class="rules mb-3" id="dinosaurpens"
                    alt="Reglamento Pagina 4">
                <img src="/draftosaurus/public/img/reglas5.png" class="rules mb-3" id="summer"
                    alt="Reglamento Pagina 5">
                <img src="/draftosaurus/public/img/reglas6.png" class="rules mb-3" id="dice" alt="Reglamento Pagina 6">
                <img src="/draftosaurus/public/img/reglas7.png" class="rules mb-3" id="winter"
                    alt="Reglamento Pagina 7">
                <img src="/draftosaurus/public/img/reglas8.png" class="rules mb-3" id="extra" alt="Reglamento Pagina 8">
                <?php endif; ?>
            </div>

            <div class="container mb-5" id="video">
                <div class="ratio ratio-16x9">
                    <?php if ($lang === 'en'): ?>
                    <iframe src="https://www.youtube.com/embed/a5pegumye6E" title="Draftosaurus - Tutorial (English)"
                        allowfullscreen></iframe>
                    <?php else: ?>
                    <iframe src="https://www.youtube.com/embed/-ZyFqRNkiAU" title="Draftosaurus - Tutorial (Español)"
                        allowfullscreen></iframe>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/../layouts/footer.php'; ?>

        <button id="scrollTopBtn" title="Volver arriba">
            <i class="bi bi-arrow-up-circle-fill"></i>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    const scrollBtn = document.getElementById("scrollTopBtn");
    window.onscroll = function() {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            scrollBtn.style.display = "block";
        } else {
            scrollBtn.style.display = "none";
        }
    };
    scrollBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
    </script>
</body>

</html>