<?php
$servername = "localhost";
$username = "root";
$password = ""; //
$dbname = "draftosaurus_chat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error de conexión a la base de datos: ' . $conn->connect_error]);
    exit();
}
?>