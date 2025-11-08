<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mail = new PHPMailer();

    //Server settings
    $mail->isSMTP();
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->Host       = $_ENV['SMTP_HOST'];
    $mail->Port       = $_ENV['SMTP_PORT'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['SMTP_USER'];
    $mail->Password   = $_ENV['SMTP_PASS'];

    //Recipients
    $mail->setFrom($_ENV['SMTP_USER'], 'Draftosaurus');
    $mail->addReplyTo($_ENV['SMTP_USER'], 'Draftosaurus');
    $mail->addAddress('softwarexstudio@gmail.com', 'Recipient Name');
    $mail->Subject = 'Test Email from Draftosaurus';
    $mail->isHtml(false);
    $mail->Body    = 'This is a test email sent from Draftosaurus using PHPMailer with SMTP configuration.';
     if ($mail->send()) {
        echo 'Mensaje enviado con exito' . $mail->ErrorInfo;}
        else {
        echo 'El mensaje no se pudo enviar. Error de correo: ' . $mail->ErrorInfo;
        } 
    ?>