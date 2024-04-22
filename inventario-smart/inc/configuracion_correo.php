<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Establece la ruta al archivo autoload.php
require_once __DIR__ . '/../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'inventariosmart@cinetickett.com';                     //SMTP username
    $mail->Password   = 'Hola123.';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('inventariosmart@cinetickett.com', 'Tu inventario smart');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Alerta de producto';

    $mail->send();
    echo '';
} catch (Exception $e) {
    echo ''; // Esto lo hacemos porque marca error aunque no hay error debido a que el cuerpo del email lo mandamos desde producto_actualizar.php
}