<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP de Gmail
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'benjagitgithub@gmail.com'; // Correo electrónico de origen
    $mail->Password   = 'loma dlgf pegb ttko'; // Contraseña del correo electrónico de origen
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Usar STARTTLS
    $mail->Port       = 587; // Puerto TLS

    // Destinatario
    $destinatario = $_POST['destinatario'];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];

    // Establecer el destinatario, asunto y mensaje
    $mail->setFrom('benjagitgithub@gmail.com', 'Benja Git');
    $mail->addAddress($destinatario);
    $mail->Subject = $asunto;
    $mail->Body    = $mensaje;

    // Enviar el correo
    $mail->send();
    echo 'El correo ha sido enviado correctamente';
    header("Location: index.php");
} catch (Exception $e) {
    echo "El correo no pudo ser enviado. Error: {$mail->ErrorInfo}";
}
