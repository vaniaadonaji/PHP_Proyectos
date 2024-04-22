<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    /**
     * Email de origen
     */
    public string $fromEmail  = 'benjagitgithub@gmail.com';

    /**
     * Nombre de origen
     */
    public string $fromName   = 'Benjamin Peña';

    /**
     * Destinatarios predeterminados
     */
    public string $recipients = '';

    /**
     * El "agente de usuario"
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * El protocolo de envío de correo: mail, sendmail, smtp
     */
    public string $protocol = 'smtp';

    /**
     * La ruta del servidor a Sendmail.
     */
    public string $mailPath = '/usr/sbin/sendmail';

    /**
     * Hostname del servidor SMTP
     */
    public string $SMTPHost = 'smtp.gmail.com';

    /**
     * Nombre de usuario SMTP
     */
    public string $SMTPUser = 'benjagitgithub@gmail.com';

    /**
     * Contraseña SMTP
     */
    public string $SMTPPass = 'loma dlgf pegb ttko';

    /**
     * Puerto SMTP
     */
    public int $SMTPPort = 587;

    /**
     * Tiempo de espera SMTP (en segundos)
     */
    public int $SMTPTimeout = 5;

    /**
     * Habilitar conexiones SMTP persistentes
     */
    public bool $SMTPKeepAlive = false;

    /**
     * Encriptación SMTP.
     *
     * @var string '', 'tls' o 'ssl'. 'tls' emitirá un comando STARTTLS
     * al servidor. 'ssl' significa SSL implícito. La conexión en el puerto
     * 465 debe establecer esto en ''.
     */
    public string $SMTPCrypto = 'tls';

    /**
     * Habilitar el ajuste de línea
     */
    public bool $wordWrap = true;

    /**
     * Cantidad de caracteres para envolver
     */
    public int $wrapChars = 76;

    /**
     * Tipo de correo, ya sea 'text' o 'html'
     */
    public string $mailType = 'text';

    /**
     * Juego de caracteres (utf-8, iso-8859-1, etc.)
     */
    public string $charset = 'UTF-8';

    /**
     * Si se debe validar la dirección de correo electrónico
     */
    public bool $validate = false;

    /**
     * Prioridad del correo electrónico. 1 = más alto. 5 = más bajo. 3 = normal
     */
    public int $priority = 3;

    /**
     * Carácter de nueva línea. (Use "\r\n" para cumplir con RFC 822)
     */
    public string $CRLF = "\r\n";

    /**
     * Carácter de nueva línea. (Use "\r\n" para cumplir con RFC 822)
     */
    public string $newline = "\r\n";

    /**
     * Habilitar el modo de lote BCC.
     */
    public bool $BCCBatchMode = false;

    /**
     * Número de correos electrónicos en cada lote BCC
     */
    public int $BCCBatchSize = 200;

    /**
     * Habilitar mensaje de notificación del servidor
     */
    public bool $DSN = false;
}
