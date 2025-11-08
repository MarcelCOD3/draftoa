<?php
// Si querés usar sesión para usuario logueado
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<div class="app-layout">

    <!-- Barra lateral de Hugo -->
    <aside class="sidebar">
        <div class="hugo-profile">
            <div class="hugo-avatar-container">
                <img src="/draftosaurus/public/img/chatbot.gif" alt="Avatar de Hugo">
            </div>
            <h2>Hugo</h2>
            <p>Tu asistente para Draftosaurus</p>
            <div class="status">
                <span class="status-indicator"></span> En línea
            </div>
        </div>
    </aside>

    <!-- Panel principal del chat -->
    <main class="chat-panel">
        <div class="chat-box" id="chat-box">
            <div class="chat-message bot-message">
                <p>Hola, soy Hugo. ¿En qué puedo ayudarte con Draftosaurus?</p>
            </div>
        </div>
        <footer class="chat-input-area">
            <input type="text" id="user-input" placeholder="Escribe tu pregunta a Hugo...">
            <button id="send-button">Enviar</button>
        </footer>
    </main>

</div>

<!-- JS -->
<script src="/draftosaurus/public/js/chatbot.js"></script>
<link rel="stylesheet" href="/draftosaurus/public/css/views/chatbot.css">