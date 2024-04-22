<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DescargarArchivo extends Controller
{
    public function index()
    {
        $ftp_server = "191.101.79.91";
        $ftp_username = "u954703204";
        $ftp_password = "BjfiKqxi1";
        $remote_file = "/domains/cinetickett.com/public_html/Reporte.pdf"; // Ruta al archivo en el servidor FTP

        $this->descargarArchivoFTP($ftp_server, $ftp_username, $ftp_password, $remote_file);
    }

    private function descargarArchivoFTP($ftp_server, $ftp_username, $ftp_password, $remote_file)
    {
        // Establecer conexión FTP
        $conn_id = ftp_connect($ftp_server);
        if (!$conn_id) {
            die("No se pudo conectar al servidor FTP");
        }
        
        // Iniciar sesión con usuario y contraseña
        $login_result = ftp_login($conn_id, $ftp_username, $ftp_password);
        if (!$login_result) {
            die("Inicio de sesión FTP fallido");
        }
        
        // Establecer modo pasivo
        ftp_pasv($conn_id, true);

        // Carpeta temporal donde se guardará el archivo descargado
        $local_file = sys_get_temp_dir() . '/documento.pdf';

        // Descargar el archivo desde el servidor FTP al servidor web
        if (ftp_get($conn_id, $local_file, $remote_file, FTP_BINARY)) {
            // Cerrar conexión FTP
            ftp_close($conn_id);

            // Establecer encabezados para forzar la descarga del archivo
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="documento.pdf"');
            header('Content-Length: ' . filesize($local_file));

            // Leer el archivo y enviar su contenido al navegador
            readfile($local_file);

            // Eliminar el archivo temporal después de descargarlo
            unlink($local_file);
        } else {
            // Cerrar conexión FTP
            ftp_close($conn_id);

            die("No se pudo descargar el archivo del servidor FTP");
        }
    }

}
