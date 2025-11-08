<?php
require_once __DIR__ . '/../controllers/UserController.php';

header('Content-Type: application/json');

if (!isset($_GET['nickname'])) {
    echo json_encode(['available' => false]);
    exit;
}

$nickname = trim($_GET['nickname']);
$userController = new UserController();

$available = !$userController->nicknameExists($nickname);

echo json_encode(['available' => $available]);