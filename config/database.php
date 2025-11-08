<?php


try {
    $db = new PDO(
        'mysql:host=127.0.0.1;dbname=draftosaurus_db;charset=utf8',
        'root',
        '' // contraseña vacia por defecto en XAMPP
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}