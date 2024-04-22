<?php

namespace App\Controllers;

use App\Models\Horario;
use App\Models\Ticket;
use App\Models\Usuario;
use CodeIgniter\Controller;
use App\Models\Sala;
use App\Models\Pelicula;
use TCPDF;

class Taquilla extends Controller
{
    public function gethorarios()
    {
        $salaModel = new Sala();
        $datos['salas'] = $salaModel->findAll(); // Obtener todas las salas

        $datos['cabecera'] = view('template/cabecera_taquilla');
        $datos['piepagina'] = view('template/piepagina');

        return view('taquilla/venta_ticket', $datos);
    }

    public function index()
    {
        $peliculaModel = new Pelicula();

        // Obtener todas las películas activas
        $peliculas_activas = $peliculaModel->where('estado_pelicula', 1)->findAll();

        $datos['peliculas_activas'] = $peliculas_activas;
        $datos['cabecera'] = view('template/cabecera_taquilla');
        $datos['piepagina'] = view('template/piepagina');

        return view('taquilla/principal_taquilla', $datos);
    }

    public function filtrarPeliculas($idPelicula)
    {
        $peliculaModel = new Pelicula();
        $pelicula = $peliculaModel->find($idPelicula);

        // Devolver los detalles de la película en formato JSON
        return $this->response->setJSON($pelicula);
    }

    public function vista_comprar_boletos($id_pelicula = null)
    {
        // Verificar si hay un usuario en sesión y obtener su nombre
        $nombreUsuario = session()->get('nombre_usuario');

        $salaModel = new Sala();

        $datos['salas'] = $salaModel->findAll();

        // Crea una nueva instancia de la clase Pelicula
        $peliculaModel = new Pelicula();
        // Obtiene los datos de una película específica utilizando el ID proporcionado como parámetro
        // y los asigna a la variable $datos['pelicula']
        $datos['pelicula'] = $peliculaModel->where('id_pelicula', $id_pelicula)->first();

        // Obtener los horarios seleccionados si están disponibles en la solicitud anterior
        $horario_seleccionado = $this->request->getPost('horarios');
        $horarioModel = new Horario();
        $datos['horarios'] = $horarioModel->findAll();

        // Pasar el horario seleccionado a la vista
        $datos['horario_seleccionado'] = $horario_seleccionado;

        // Asigna vistas de cabecera y pie de página a las variables $datos['cabecera'] y $datos['piepagina'], respectivamente.
        $datos['cabecera'] = view('template/cabecera_comprar_boletos');
        $datos['piepagina'] = view('template/piepagina');

        // Pasar el nombre de usuario a la vista
        $datos['nombre_usuario'] = $nombreUsuario;

        // Devuelve una vista llamada "peliculas/actualizar_peliculas" con los datos obtenidos
        return view("taquilla/venta_ticket", $datos);
    }

    public function guardar_ticket()
{
    // Crear una nueva instancia del modelo Ticket
    $ticketModel = new Ticket();
    $peliculaModel = new Pelicula();

    // Obtener los datos del formulario
    $id_sala = $this->request->getVar('sala');
    $id_horario = $this->request->getVar('horarios');
    $numero_asientos = $this->limpiar_cadena($this->request->getVar('numero_asientos'));
    $fecha_compra = $this->request->getVar('fecha_compra');
    $nombre_cliente = $this->limpiar_cadena($this->request->getVar('nombre_cliente'));
    $id_pelicula = $this->request->getVar('id_pelicula');
    $total = $this->limpiar_cadena($this->request->getVar('precio_total'));
    $id_usuario = $this->request->getVar('id_usuario');

    // Generar un folio aleatorio único para cada compra
    $folio = uniqid();

    // Preparar los datos para la inserción en la base de datos
    $datos_ticket = [
        'id_sala' => $id_sala,
        'id_horario' => $id_horario,
        'numero_asientos' => $numero_asientos,
        'fecha_compra' => $fecha_compra,
        'nombre_cliente' => $nombre_cliente,
        'folio' => $folio,
        'id_pelicula' => $id_pelicula,
        'total' => $total,
        'id_usuario' => $id_usuario
    ];

    // Insertar el ticket en la base de datos
    $ticketModel->insert($datos_ticket);

    // Obtener los detalles de la película para pasar a la función de generación de PDF
    $pelicula = $peliculaModel->find($id_pelicula);

    $usuario_model = new Usuario();
    $usuario = $usuario_model->find($id_usuario);

    $horario_model = new Horario();
    $horario = $horario_model->find($id_horario);

    // Generar y descargar el PDF del ticket
    $this->generar_y_descargar_ticket_pdf($datos_ticket, $pelicula, $horario, $usuario);
    return redirect()->to(site_url('taquilla'));
}

    function limpiar_cadena($cadena)
    {
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        $cadena = str_ireplace("<script>", "", $cadena);
        $cadena = str_ireplace("</script>", "", $cadena);
        $cadena = str_ireplace("<script src", "", $cadena);
        $cadena = str_ireplace("<script type=", "", $cadena);
        $cadena = str_ireplace("!DOCTYPE html>", "", $cadena);
        $cadena = str_ireplace("SELECT * FROM", "", $cadena);
        $cadena = str_ireplace("DELETE FROM", "", $cadena);
        $cadena = str_ireplace("INSERT INTO", "", $cadena);
        $cadena = str_ireplace("DROP TABLE", "", $cadena);
        $cadena = str_ireplace("DROP DATABASE", "", $cadena);
        $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
        $cadena = str_ireplace("SHOW TABLES;", "", $cadena);
        $cadena = str_ireplace("SHOW DATABASES;", "", $cadena);
        $cadena = str_ireplace("<?php", "", $cadena);
        $cadena = str_ireplace("?>", "", $cadena);
        $cadena = str_ireplace("--", "", $cadena);
        $cadena = str_ireplace("^", "", $cadena);
        $cadena = str_ireplace("<", "", $cadena);
        $cadena = str_ireplace("[", "", $cadena);
        $cadena = str_ireplace("]", "", $cadena);
        $cadena = str_ireplace("==", "", $cadena);
        $cadena = str_ireplace(";", "", $cadena);
        $cadena = str_ireplace("::", "", $cadena);
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        return $cadena;
    }

    public function vista_ventas()
    {
        $ticketModel = new Ticket();
        $datos['cabecera'] = view('template/cabecera_ventas');
        $datos['piepagina'] = view('template/piepagina');

        // Obtener valores únicos de los campos para los dropdown lists
        $fechas = $ticketModel->distinct()->select('fecha_compra')->get()->getResultArray();
        $usuarios = $ticketModel->distinct()->select('id_usuario')->get()->getResultArray();
        $folios = $ticketModel->distinct()->select('folio')->get()->getResultArray();

        $datos['fechas'] = $fechas;
        $datos['usuarios'] = $usuarios;
        $datos['folios'] = $folios;

        // Obtener parámetros de filtro
        $filtro_fecha = $this->request->getGet('fecha');
        $filtro_usuario = $this->request->getGet('usuario');
        $filtro_folio = $this->request->getGet('folio');

        // Construir consulta base
        $query = $ticketModel;

        // Aplicar filtros si existen
        if ($filtro_fecha && $filtro_fecha != 'fecha_compra') {
            $query = $query->where('fecha_compra', $filtro_fecha);
        }
        if ($filtro_usuario && $filtro_usuario != 'id_usuario') {
            $query = $query->where('id_usuario', $filtro_usuario);
        }
        if ($filtro_folio && $filtro_folio != 'folio') {
            $query = $query->where('folio', $filtro_folio);
        }

        $total_ventas = count($query->findAll());

        $ventas_por_pagina = 5;

        $total_pages = ceil($total_ventas / $ventas_por_pagina);

        $current_page = $this->request->getVar('page') ?? 1;

        $offset = ($current_page - 1) * $ventas_por_pagina;

        $query = $ticketModel;

        // Aplicar filtros si existen
        if ($filtro_fecha && $filtro_fecha != 'fecha_compra') {
            $query = $query->where('fecha_compra', $filtro_fecha);
        }
        if ($filtro_usuario && $filtro_usuario != 'id_usuario') {
            $query = $query->where('id_usuario', $filtro_usuario);
        }
        if ($filtro_folio && $filtro_folio != 'folio') {
            $query = $query->where('folio', $filtro_folio);
        }

        $datos['tickets'] = $query->findAll($ventas_por_pagina, $offset);

        $datos['total_pages'] = $total_pages;
        $datos['current_page'] = $current_page;

        return view('taquilla/principal_venta', $datos);
    }
    public function eliminar_ticket($id_ticket = null)
    {
        $ticket = new Ticket();

        $ticket->delete($id_ticket);

        return redirect()->to(site_url('ventas'));
    }
    public function actualizar_ticket()
    {
        $ticketModel = new Ticket();

        $id_ticket = $this->request->getVar('id_ticket');

        // Obtener los datos del formulario
        $id_sala = $this->request->getVar('sala');
        $id_horario = $this->request->getVar('horarios');
        $numero_asientos = $this->limpiar_cadena($this->request->getVar('numero_asientos'));
        $fecha_compra = $this->request->getVar('fecha_compra');
        $nombre_cliente = $this->limpiar_cadena($this->request->getVar('nombre_cliente'));
        $id_pelicula = $this->request->getVar('id_pelicula');
        $total = $this->limpiar_cadena($this->request->getVar('precio_total'));
        $id_usuario = $this->request->getVar('id_usuario');

        // Preparar los datos para la actualización en la base de datos
        $datos_ticket = [
            'id_sala' => $id_sala,
            'id_horario' => $id_horario,
            'folio' => $this->request->getVar('folio'),
            'numero_asientos' => $numero_asientos,
            'fecha_compra' => $fecha_compra,
            'nombre_cliente' => $nombre_cliente,
            'id_pelicula' => $this->request->getVar('pelicula'),
            'total' => $total,
            'id_usuario' => $id_usuario
        ];

        // Actualizar el ticket en la base de datos
        $ticketModel->update($id_ticket, $datos_ticket);
        // Obtener los datos actualizados del ticket después de la actualización
        $ticket_actualizado = $ticketModel->find($id_ticket);

        $pelicula_model = new Pelicula();
        $pelicula = $pelicula_model->find($id_pelicula);

        $usuario_model = new Usuario();
        $usuario = $usuario_model->find($id_usuario);

        $horario_model = new Horario();
        $horario = $horario_model->find($id_horario);

        // Generar y descargar el PDF del ticket
        $this->generar_y_descargar_ticket_pdf($datos_ticket, $pelicula, $horario, $usuario);

        // Redirigir a la página de edición del ticket con los datos actualizados
        return redirect()->to(site_url('ventas'));
    }

    public function editar_ticket($id_ticket = null)
    {
        // Obtener el ticket a editar
        $ticketModel = new Ticket();
        $ticket = $ticketModel->find($id_ticket);

        if (!$ticket) {
            return redirect()->back()->with('error', 'Ticket no encontrado');
        }

        // Obtener la información de la película asociada al ticket
        $peliculaModel = new Pelicula();
        $pelicula = $peliculaModel->find($ticket['id_pelicula']);

        // Obtener todas las películas activas
        $peliculas_activas = $peliculaModel->where('estado_pelicula', 1)->findAll();

        // Obtener todas las salas
        $salaModel = new Sala();
        $salas = $salaModel->findAll();

        // Obtener los horarios disponibles para la sala seleccionada en el ticket
        $horarioModel = new Horario();
        $horarios_disponibles = $horarioModel->where('id_sala', $ticket['id_sala'])->findAll();

        $datos = [
            'ticket' => $ticket,
            'pelicula' => $pelicula,
            'peliculas_activas' => $peliculas_activas,
            'salas' => $salas,
            'horarios_disponibles' => $horarios_disponibles,
            'cabecera' => view('template/cabecera_actualizar'),
            'piepagina' => view('template/piepagina')
        ];

        return view("taquilla/actualizar_venta", $datos);
    }

    // Función para generar y descargar el PDF del ticket
    private function generar_y_descargar_ticket_pdf($datos_ticket, $pelicula, $horario, $usuario)
    {
        // Crear instancia de TCPDF
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Establecer información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('BenVani Cineplex');
        $pdf->SetTitle('Ticket de compra');
        $pdf->SetSubject('Ticket de compra');
        $pdf->SetKeywords('Ticket, Compra, Cine');

        // Establecer márgenes
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Establecer auto página breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Establecer modo de subconjunto de fuentes
        $pdf->setFontSubsetting(true);

        // Agregar una página
        $pdf->AddPage();

        // Definir el contenido del ticket en HTML
        $html = view('taquilla/ticket_pdf', ['ticket' => $datos_ticket, 'pelicula' => $pelicula, 'horario' => $horario, 'usuario' => $usuario]);

        // Escribir el contenido HTML en el PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Nombre del archivo PDF
        $file_name = 'ticket_' . date('Y-m-d_H-i-s') . '.pdf';

        // Guardar el PDF en la carpeta temporal
        $tempFilePath = sys_get_temp_dir() . '/' . $file_name;
        $pdf->Output($tempFilePath, 'F');

        // Enviar el PDF al navegador del usuario para descargarlo
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        readfile($tempFilePath);
        redirect()->to(site_url('ventas'));
        exit;
    }
}
