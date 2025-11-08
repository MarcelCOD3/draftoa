<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$players = $_POST['players'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking - Draftosaurus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="/draftosaurus/public/css/styles.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/navbar.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/footer.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/views/tracking.css">
</head>

<body>
    <div id="app" class="d-flex flex-column min-vh-100">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/draftosaurus/app/views/layouts/navbar.php'; ?>

        <main class="container flex-grow-1 my-5">
            <h2 class="text-center mb-4" id="currentPlayerTitle">Dino-Puntaje</h2>

            <!-- Avatares -->
            <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap" id="avatarsContainer"></div>

            <!-- Zonas fijas -->
            <div id="zonesContainer" class="mt-4">
                <div class="zone" id="zone1">
                    <label for="zone1Input" class="form-label">El Dino-Bosque de la Dino-Semejanza</label>
                    <div class="zone-input-group">
                        <input type="number" id="zone1Input" class="form-control" min="0" max="6" />
                        <i class="bi bi-info-circle-fill info-icon" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Este recinto solo acepta dinos de una misma especie,
                            1 Dino + 2 Puntos,
                            2 Dinos Iguales + 4 Puntos,
                            3 Dinos Iguales + 8 Puntos,
                            4 Dinos Iguales + 12 Puntos,
                            5 Dinos Iguales + 18 Puntos,
                            6 Dinos Iguales + 24 Puntos,
                          
                            Coloca la cantidad de dinos de la misma especie."></i>
                    </div>
                </div>

                <div class="zone" id="zone2">
                    <label for="zone2Input" class="form-label">El Trío Dino-Frondoso</label>
                    <div class="zone-input-group">
                        <input type="number" id="zone2Input" class="form-control" min="0" max="1" />
                        <i class="bi bi-info-circle-fill info-icon" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Este recinto solo suma 7 Puntos si tienes unicamente 3 Dinos, de lo contrario no sumaras puntos. Coloca 1 si unicamente tienes 3 Dinos, ni mas, ni menos."></i>
                    </div>
                </div>

                <div class="zone" id="zone3">
                    <label for="zone3Input" class="form-label">La Dino-Pradera del Dino-Amor</label>
                    <div class="zone-input-group">
                        <input type="number" id="zone3Input" class="form-control" min="0" max="12" />
                        <i class="bi bi-info-circle-fill info-icon" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Este recinto acepta todo tipo de Dinos, pero solo sumaran 5 puntos cada pareja de la misma especie, Coloca la cantidad de parejas que tienes en este recinto."></i>
                    </div>
                </div>

                <div class="zone" id="zone4">
                    <label class="form-label">El Dino-Rey de la Dino-Selva</label>
                    <div class="zone-input-group" style="flex-direction: column; align-items: center;">
                        <!-- Contenedor de fichas -->
                        <div class="zone4-species-options d-flex gap-2 justify-content-center">
                            <label class="species-option">
                                <input type="radio" name="zone4Species" value="Azul" />
                                <img src="/draftosaurus/public/img/2d-blue.PNG" alt="Azul" />
                            </label>
                            <label class="species-option">
                                <input type="radio" name="zone4Species" value="Verde" />
                                <img src="/draftosaurus/public/img/2d-green.PNG" alt="Verde" />
                            </label>
                            <label class="species-option">
                                <input type="radio" name="zone4Species" value="Naranja" />
                                <img src="/draftosaurus/public/img/2d-orange.PNG" alt="Naranja" />
                            </label>
                            <label class="species-option">
                                <input type="radio" name="zone4Species" value="Rosa" />
                                <img src="/draftosaurus/public/img/2d-pink.png" alt="Rosa" />
                            </label>
                            <label class="species-option">
                                <input type="radio" name="zone4Species" value="Rojo" />
                                <img src="/draftosaurus/public/img/2d-red.PNG" alt="Rojo" />
                            </label>
                            <label class="species-option">
                                <input type="radio" name="zone4Species" value="Amarillo" />
                                <img src="/draftosaurus/public/img/2d-yellow.PNG" alt="Amarillo" />
                            </label>
                            <label class="species-option">
                                <input type="radio" name="zone4Species" value="none" />
                                <div class="no-dino">X</div>
                            </label>

                        </div>

                        <input type="number" id="zone4Input" class="form-control" min="0" max="12"
                            style="width: 70px;" />

                        <i class="bi bi-info-circle-fill info-icon" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Selecciona la especie de tu Dino-Rey y coloca la cantidad que tienes. Ganarás 7 puntos si eres quien más tiene de esa especie al final de la partida."></i>
                    </div>
                </div>



                <div class="zone" id="zone5">
                    <label for="zone5Input" class="form-label">El Dino-Prado de la Dino-Diferencia</label>
                    <div class="zone-input-group">
                        <input type="number" id="zone5Input" class="form-control" min="0" max="6" />
                        <i class="bi bi-info-circle-fill info-icon" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Este recinto solo acepta dinos de diferente especie,
                            1 Dino + 1 Punto,
                            2 Dinos Diferentes + 3 Puntos,
                            3 Dinos Diferentes + 6 Puntos,
                            4 Dinos Diferentes + 10 Puntos,
                            5 Dinos Diferentes + 15 Puntos,
                            6 Dinos Diferentes + 21 Puntos,
                          
                            Coloca la cantidad de dinos de diferente especie."></i>
                    </div>
                </div>

                <div class="zone" id="zone6">
                    <label for="zone6Input" class="form-label">La Dino-Isla Dino-Solitaria</label>
                    <div class="zone-input-group">
                        <input type="number" id="zone6Input" class="form-control" min="0" max="1" />
                        <i class="bi bi-info-circle-fill info-icon" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Este Recinto acepta solo 1 Dino, Si es el unico de esta especie en tu tablero, indica 1, de lo contrario estaras haciendo Dino-trampa!!"></i>
                    </div>
                </div>

                <div class="zone" id="zone7">
                    <label for="zone7Input" class="form-label">El Dino-Rio de la Dino-Vida</label>
                    <div class="zone-input-group">
                        <input type="number" id="zone7Input" class="form-control" min="0" max="12" />
                        <i class="bi bi-info-circle-fill info-icon" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Aqui van los Dinosaurios que necesitan un baño, Cada uno suma 1 Punto por limpio"></i>
                    </div>
                </div>
            </div>

            <!-- Botones principales -->
            <div class="d-flex justify-content-center gap-3 mt-4 position-relative">
                <button class="btn btn-primary" id="nextBtn">Siguiente</button>
                <button class="btn btn-success" id="finishBtn" style="display: none;">Finalizar</button>
            </div>
        </main>

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/draftosaurus/app/views/layouts/footer.php'; ?>
    </div>

    <!-- Modal ganador -->
    <div class="modal fade" id="winnerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <h2 id="winnerTitle" class="mb-3"></h2>
                <div id="winnerList"></div>
                <div class="d-flex justify-content-center gap-3 mt-3">
                    <button class="btn btn-success" id="newGameBtn">Nueva Dino-Partida</button>
                    <button class="btn btn-primary" id="closeWinnerBtn" data-bs-dismiss="modal">Volver al
                        Dino-Inicio</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    const players = <?= json_encode($players) ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/draftosaurus/public/js/tracking.js"></script>
</body>

</html>