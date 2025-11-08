<!-- Tener en cuenta que los nombres de funciones, variables, y demás deben estar en inglés por buena práctica de programación -->
<div id="game">
    <div id="tablero" class="container-fluid">
        <!-- Columna izquierda -->
        <div class="zona" id="zona1">zona1</div>
        <div class="zona" id="zona2">zona2</div>
        <div class="zona" id="zona3">zona3</div>

        <!-- Centro abajo -->
        <div class="zona" id="zona4">zona4</div>

        <!-- Columna derecha -->
        <div class="zona" id="zona5">zona5</div>
        <div class="zona" id="zona6">zona6</div>
        <div class="zona" id="zona7">zona7</div>
    </div>

    <!-- Barra de abajo con fichas y botones -->
    <div id="downbar">
        <div id="barra-completa">
            <div id="fichas" class="barra">
                <img src="/draftosaurus/public/img/2d-blue.PNG" alt="ficha azul" class="ficha">
                <img src="/draftosaurus/public/img/2d-yellow.PNG" alt="ficha amarilla" class="ficha">
                <img src="/draftosaurus/public/img/2d-pink.PNG" alt="ficha rosa" class="ficha">
                <img src="/draftosaurus/public/img/2d-green.PNG" alt="ficha verde" class="ficha">
                <img src="/draftosaurus/public/img/2d-orange.PNG" alt="ficha naranja" class="ficha">
                <img src="/draftosaurus/public/img/2d-red.PNG" alt="ficha roja" class="ficha">
            </div>

            <div id="ajustes">
                <button class="btn btn-primary" id="btn-undo" title="Deshacer">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </button>
                <button class="btn btn-primary" id="btn-redo" title="Rehacer">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
                <button class="btn btn-primary" id="btn-save" title="Guardar Partida">
                    <i class="bi bi-save"></i>
                </button>
            </div>
        </div>
    </div>
</div>