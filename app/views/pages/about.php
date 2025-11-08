<?php
if (session_status() === PHP_SESSION_NONE) session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros | Draftosaurus</title>

    <!-- Bootstrap & Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="/draftosaurus/public/css/styles.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/navbar.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/footer.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/views/about.css">
</head>

<body class="bg-black text-orange">

    <!-- Navbar -->
    <div id="navbar">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/draftosaurus/app/views/layouts/navbar.php'; ?>
    </div>

    <!-- Contenido principal -->
    <main class="about-container container py-5">

        <?= $statusMessage ?>

        <section class="intro mb-5">
            <h1 class="text-center mb-3">Sobre <span class="text-warning">Draftosaurus</span></h1>
            <p class="text-center fs-5">
                Bienvenido a <strong>Draftosaurus</strong>, un proyecto creado con pasión por los dinosaurios,
                la estrategia y el desarrollo web. Aquí cada partida es una nueva aventura en la era jurásica.
            </p>
        </section>

        <section class="team mb-5">
            <h2 class="text-center mb-4">Nuestro Equipo</h2>
            <div class="team-members d-flex flex-wrap justify-content-center gap-4">
                <div class="member-card text-center p-3 bg-dark rounded shadow-sm">
                    <img src="/draftosaurus/public/img/avatar-admin.png" alt="Avatar del creador" class="mb-2"
                        width="150">
                    <h3 class="text-warning">Marcos Sierra</h3>
                    <p>Desarrollador principal y amante de los desafíos lógicos. Creador del sistema y diseñador de la
                        experiencia de juego.</p>
                </div>
                <div class="member-card text-center p-3 bg-dark rounded shadow-sm">
                    <img src="/draftosaurus/public/img/dino-verde.png" alt="Logo Draftosaurus" class="mb-2" width="150">
                    <h3 class="text-warning">Drafto</h3>
                    <p>La mascota oficial del proyecto. Representa el espíritu competitivo, divertido y jurásico del
                        juego.</p>
                </div>
            </div>
        </section>

        <section class="mapa mb-5 text-center">
            <h2 class="mb-3">Ubicación</h2>
            <p>Colonia 2234, Montevideo, Uruguay</p>
            <p>Sitio web Sinergia: <a href="https://sinergia.uy/on-demand" target="_blank"
                    class="text-warning">sinergia.uy/on-demand</a></p>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3272.364191154827!2d-56.17022972519513!3d-34.897308973061044!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x959f80528cbf0935%3A0x2c6b4ddccc6d24bb!2sSinergia%20Design!5e0!3m2!1ses!2suy!4v1759782788456!5m2!1ses!2suy"
                width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </section>

        <section class="contact mb-5">
            <h2 class="text-center mb-3">Contacto</h2>
            <p class="text-center">¿Tienes ideas, sugerencias o quieres colaborar? Escríbenos.</p>
            <?php
if (!empty($_SESSION['contactMessage'])) {
    echo "<div class='alert {$_SESSION['contactMessage']['class']} text-center'>
            {$_SESSION['contactMessage']['text']}
          </div>";
    unset($_SESSION['contactMessage']);
}
?>


            <form class="contact-form mx-auto" style="max-width:500px;"
                action="/draftosaurus/public/index.php?page=about" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Tu nombre..." required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="tunombre@email.com"
                        required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Mensaje:</label>
                    <textarea id="message" name="message" class="form-control" rows="5"
                        placeholder="Escribe tu mensaje..." required></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-warning text-black">Enviar Mensaje</button>
                </div>
            </form>
        </section>


        <!-- Botón de ayuda -->
        <div class="text-center mb-4">
            <button type="button" class="btn btn-warning text-black" data-bs-toggle="modal"
                data-bs-target="#chatbotModal">
                Ayuda
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="chatbotModal" tabindex="-1" aria-labelledby="chatbotModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <!-- modal-lg = tamaño grande -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chatbotModalLabel">Chat con Hugo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body p-0">
                        <!-- Contenido del chatbot -->
                        <iframe src="/draftosaurus/app/views/pages/chatbot.php"
                            style="width:100%; height:500px; border:none;"></iframe>
                    </div>
                </div>
            </div>
        </div>





    </main>

    <div id="footer">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/draftosaurus/app/views/layouts/footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>