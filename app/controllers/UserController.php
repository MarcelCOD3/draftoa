<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/PlayerModel.php';

class UserController {
    private $db;
    private $playerModel;

    public function __construct() {
        global $db;
        $this->db = $db;
        $this->playerModel = new PlayerModel();
    }

    private function ensureSession() {
        if(session_status() === PHP_SESSION_NONE) session_start();
    }

    /**
     * Login de usuario con comprobación de baneos
     */
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE email = :email AND active = 1");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si está baneado
            if (!empty($user['banned_until']) && strtotime($user['banned_until']) > time()) {
                return ['success' => false, 'banned_until' => $user['banned_until']];
            }

            if (password_verify($password, $user['password_hash'])) {
                $this->ensureSession();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['nickname'] = $user['nickname'];
                $_SESSION['is_admin'] = $user['is_admin'];
                return ['success' => true];
            }
        }

        return ['success' => false];
    }

    public function register($data) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM Users WHERE nickname = :nickname OR email = :email");
            $stmt->execute([
                ':nickname' => $data['nickname'],
                ':email'    => $data['email']
            ]);
            if ($stmt->rowCount() > 0) {
                return ['success' => false, 'error' => 'El nickname o correo ya está en uso.'];
            }

            $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

            $insert = $this->db->prepare("
                INSERT INTO Users (nickname, first_name, last_name, email, password_hash, active, is_admin)
                VALUES (:nickname, :first_name, :last_name, :email, :password_hash, 1, 0)
            ");

            $insert->execute([
                ':nickname'      => $data['nickname'],
                ':first_name'    => $data['first_name'],
                ':last_name'     => $data['last_name'],
                ':email'         => $data['email'],
                ':password_hash' => $passwordHash
            ]);

            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => 'Error en base de datos: ' . $e->getMessage()];
        }
    }

    public function getUserByNickname($nickname) {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE nickname = :nickname");
        $stmt->bindParam(':nickname', $nickname, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserProfile($nickname) {
        $user = $this->getUserByNickname($nickname);
        if (!$user) return null;

        $stats = $this->playerModel->getUserStats($user['user_id']);
        return ['user' => $user, 'stats' => $stats];
    }

    public function logout() {
        $this->ensureSession();
        session_unset();
        session_destroy();
        header("Location: /draftosaurus/public/index.php?page=main");
        exit();
    }
}
?>