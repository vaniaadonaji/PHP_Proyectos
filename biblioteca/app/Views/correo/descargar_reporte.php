<?php
// Configuración FTP
$ftp_server = "191.101.79.91";
$ftp_username = "u954703204.cuentaParaProyectoVentaBoletos";
$ftp_password = "BjfiKqxi1";
$ftp_port = 21;
$file = "Reporte.pdf";

// Conexión FTP
$conn_id = ftp_connect($ftp_server, $ftp_port);
$login_result = ftp_login($conn_id, $ftp_username, $ftp_password);

// Verificar conexión
if ((!$conn_id) || (!$login_result)) {
    die("La conexión FTP ha fallado");
}

// Cambiar al modo pasivo
ftp_pasv($conn_id, true);

// Obtener tamaño del archivo
$file_size = ftp_size($conn_id, $file);

// Enviar encabezados para forzar la descarga
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$file\"");
header("Content-Length: $file_size");

// Descargar el archivo y enviarlo al navegador
if (ftp_fget($conn_id, STDOUT, $file, FTP_BINARY)) {
    echo "¡El archivo $file se ha descargado satisfactoriamente!";
} else {
    echo "¡Ha ocurrido un error al descargar el archivo $file!";
}

// Cerrar conexión FTP
ftp_close($conn_id);
