<?php
require_once __DIR__ . '/../models/RecoveryPassModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Dotenv\Dotenv;

class RecoveryPassController {
    private $recoveryModel;
    private $userModel;

    public function __construct() {
        require_once __DIR__ . '/../../vendor/autoload.php';

        $this->recoveryModel = new RecoveryPassModel();
        $this->userModel = new UserModel();

        if (file_exists(__DIR__ . '/../../.env')) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();
        }

    }

    // Enviar correo de recuperación
    public function sendResetEmail($email) {
        $user = $this->userModel->getUserByEmail($email);
        if (!$user) return false;

        $token = bin2hex(random_bytes(16));
        $this->recoveryModel->createToken($user['user_id'], $token);

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];

        $mail->setFrom($_ENV['SMTP_USER'], 'Draftosaurus');
        $mail->addAddress($email);
        $mail->Subject = 'Recupera tu contraseña';
        $resetLink = "http://localhost/draftosaurus/public/index.php?page=resetPassword&token=$token";
        $mail->Body = "Haz clic aquí para cambiar tu contraseña: $resetLink";

        return $mail->send();
    }

    // Verificar token válido
    public function verifyToken($token) {
        return $this->recoveryModel->getUserByToken($token);
    }

    // Actualizar contraseña y marcar token usado
    public function updatePassword($user_id, $newPassword, $token) {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->userModel->updatePassword($user_id, $hashed);
        $this->recoveryModel->markTokenUsed($token);
    }
}