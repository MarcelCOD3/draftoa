<?php
require_once __DIR__ . '/database.php';

// Datos de ejemplo
$users = [
    ['nickname' => 'D4RKK1LL', 'first_name' => 'Marcos', 'last_name' => 'Sierra', 'email' => 'marcos.sierra@gmail.com', 'password' => 'marcos1234', 'active' => 1, 'is_admin' => 1, 'banned_until' => null],
    ['nickname' => 'nacho', 'first_name' => 'Nacho', 'last_name' => 'Alonso', 'email' => 'nacho.alonso@gmail.com', 'password' => 'nacho1234', 'active' => 1, 'is_admin' => 0, 'banned_until' => null],
    ['nickname' => 'marcel', 'first_name' => 'Marcel', 'last_name' => 'Barrios', 'email' => 'marcel.barrios@gmail.com', 'password' => 'papitas1234', 'active' => 1, 'is_admin' => 0, 'banned_until' => null],
    ['nickname' => 'gabriel', 'first_name' => 'Gabriel', 'last_name' => 'Barboza', 'email' => 'gabriel.barboza@gmail.com', 'password' => 'gabi1234', 'active' => 1, 'is_admin' => 0, 'banned_until' => null],
    ['nickname' => 'luis', 'first_name' => 'Luis', 'last_name' => 'Fagundez', 'email' => 'luis.fagundez@gmail.com', 'password' => 'luis1234', 'active' => 1, 'is_admin' => 0, 'banned_until' => null],
];

// Preparar la query
$stmt = $db->prepare("
    INSERT INTO Users (nickname, first_name, last_name, email, password_hash, active, is_admin, banned_until)
    VALUES (:nickname, :first_name, :last_name, :email, :password_hash, :active, :is_admin, :banned_until)
");

foreach ($users as $user) {
    $stmt->execute([
        ':nickname' => $user['nickname'],
        ':first_name' => $user['first_name'],
        ':last_name' => $user['last_name'],
        ':email' => $user['email'],
        ':password_hash' => password_hash($user['password'], PASSWORD_DEFAULT), // hash de la contraseña
        ':active' => $user['active'],
        ':is_admin' => $user['is_admin'],
        ':banned_until' => $user['banned_until'],
    ]);
}

echo "Usuarios insertados correctamente con contraseñas hasheadas y columna banned_until.";