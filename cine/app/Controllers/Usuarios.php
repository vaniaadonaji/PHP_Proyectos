<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuario;
use App\Models\Ticket;
use Database;

class Usuarios extends Controller {


    public function usuarios_view()
    {
        $usuarios = new Usuario();
        $datos['cabecera'] = view('template/cabecera');
        $datos['piepagina'] = view('template/piepagina');

        $filtro_tipo_usuario = $this->request->getGet('tipo_usuario');
        $filtro_estado_usuario = $this->request->getGet('estado_usuario');
        $filtro_nombre_usuario = $this->limpiar_cadena($this->request->getGet('u'));

        $query = $usuarios;
        if ($filtro_tipo_usuario && $filtro_tipo_usuario != 'tipo_usuario') {
            $query = $query->where('tipo_usuario', $filtro_tipo_usuario);
        }
        if ($filtro_estado_usuario && $filtro_estado_usuario != 'estado_usuario') {
            $query = $query->where('estado_usuario', $filtro_estado_usuario);
        }
        if ($filtro_nombre_usuario) {
            $query = $query->like('nombre_usuario', $filtro_nombre_usuario);
        }
        $total_usuarios = count($query->findAll());

        $usuarios_por_pagina = 5;

        $total_pages = ceil($total_usuarios / $usuarios_por_pagina);

        $current_page = $this->request->getVar('page') ?? 1;

        $offset = ($current_page - 1) * $usuarios_por_pagina;

        $query = $usuarios;
        if ($filtro_tipo_usuario && $filtro_tipo_usuario != 'tipo_usuario') {
            $query = $query->where('tipo_usuario', $filtro_tipo_usuario);
        }
        if ($filtro_estado_usuario && $filtro_estado_usuario != 'estado_usuario') {
            $query = $query->where('estado_usuario', $filtro_estado_usuario);
        }
        if ($filtro_nombre_usuario) {
            $query = $query->like('nombre_usuario', $filtro_nombre_usuario);
        }
        $datos['usuarios'] = $query->orderBy('nombre_usuario', 'ASC')->findAll($usuarios_por_pagina, $offset);

        $datos['total_pages'] = $total_pages;
        $datos['current_page'] = $current_page;

        return view('usuarios/crud_usuarios', $datos);
    }



    public function crear_usuario_view()
    {
        $datos['cabecera2'] = view('template/cabecera_insertar');
        $datos['piepagina'] = view('template/piepagina');
        return view('usuarios/insertar_usuario', $datos);
    }
    public function guardar_usuario()
    {
        $usuario = new Usuario();
        $nombre_usuario=$this->limpiar_cadena($this->request->getVar('nombre_usuario'));
        $password=$this->limpiar_cadena($this->request->getVar('password'));
        $tipo_usuario=$this->limpiar_cadena($this->request->getVar('tipo_usuario'));
        $estado_usuario=$this->limpiar_cadena($this->request->getVar('estado_usuario'));
        $confirmar_password =$this->limpiar_cadena( $this->request->getVar('confirmar_password'));
        $usuario_existente = $usuario->where('nombre_usuario', $nombre_usuario)->first();
        if ($usuario_existente) {
            $sesion = session();
            $sesion->setFlashdata("mensaje", "El nombre de usuario ya está en uso. Por favor, elige otro.");
            return redirect()->back()->withInput();
        }
        if (!$this->longitud_valida($nombre_usuario, $password)) {
            $sesion = session();
            $sesion->setFlashdata("mensaje", "El nombre de usuario debe tener mínimo 4 caracteres y la contraseña debe tener mínimo 8 caracteres.");
            return redirect()->back()->withInput();
        }
        if (!$this->contrasena_fuerte($password)) {
            $sesion = session();
            $sesion->setFlashdata("mensaje", "La contraseña debe contener al menos un número, una letra minúscula, una letra mayúscula y un carácter especial.");
            return redirect()->back()->withInput();
        }
        if (!$this->es_valido($nombre_usuario, $password, $confirmar_password, $tipo_usuario, $estado_usuario)) {
            $sesion = session();
            $sesion->setFlashdata("mensaje", "Por favor, completa todos los campos obligatorios.");
            return redirect()->back()->withInput();
        }
        if (!$this->coincidir_password($password,$confirmar_password)) {
            $sesion = session();
            $sesion->setFlashdata("mensaje","Las contraseñas no coinciden. Por favor, inténtalo de nuevo.");
            return redirect()->back()->withInput();
        }
        
            $password_encriptada = $this->encriptar($password, 'Hola123.');

            $datos = [
                "nombre_usuario" => $nombre_usuario,
                "password" => $password_encriptada,
                "tipo_usuario" => $tipo_usuario,
                "estado_usuario" => $estado_usuario
            ];
            $usuario->insert($datos);    
            return $this->response->redirect(site_url('usuarios'));
    }
    private function coincidir_password(string $password, string $confirmar_password){
        
        if ($password != $confirmar_password) {
            return false;
        }else{
            return true;
        }
    }
    private function longitud_valida($nombre_usuario, $password)
    {
        if (strlen($nombre_usuario) < 4 || strlen($password) < 8) {
            return false;
        }
        return true;
    }
    private function longitud_nombre($nombre_usuario)
    {
        if (strlen($nombre_usuario) <= 4 || strlen($nombre_usuario)<=1) {
            return false;
        }
        return true;
    }

    private function es_valido($nombre_usuario, $password, $confirmar_password, $tipo_usuario, $estado_usuario)
    {
        if (empty($nombre_usuario) || empty($password) || empty($confirmar_password) || empty($tipo_usuario) || empty($estado_usuario)) {
            return false;
        }
        return true;
    }
    private function contrasena_fuerte($password)
    {
        $patron = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()-_+=])[0-9a-zA-Z!@#$%^&*()-_+=]{8,}$/';
        if (!preg_match($patron, $password)) {
            return false;
        }
        return true;
    }
    function limpiar_cadena($cadena){
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);
        $cadena=str_ireplace("<script>", "", $cadena);
        $cadena=str_ireplace("</script>", "", $cadena);
        $cadena=str_ireplace("<script src", "", $cadena);
        $cadena=str_ireplace("<script type=", "", $cadena);
        $cadena=str_ireplace("!DOCTYPE html>", "", $cadena);
        $cadena=str_ireplace("SELECT * FROM", "", $cadena);
        $cadena=str_ireplace("DELETE FROM", "", $cadena);
        $cadena=str_ireplace("INSERT INTO", "", $cadena);
        $cadena=str_ireplace("DROP TABLE", "", $cadena);
        $cadena=str_ireplace("DROP DATABASE", "", $cadena);
        $cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
        $cadena=str_ireplace("SHOW TABLES;", "", $cadena);
        $cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
        $cadena=str_ireplace("<?php", "", $cadena);
        $cadena=str_ireplace("?>", "", $cadena);
        $cadena=str_ireplace("--", "", $cadena);
        $cadena=str_ireplace("^", "", $cadena);
        $cadena=str_ireplace("<", "", $cadena);
        $cadena=str_ireplace("[", "", $cadena);
        $cadena=str_ireplace("]", "", $cadena);
        $cadena=str_ireplace("==", "", $cadena);
        $cadena=str_ireplace(";", "", $cadena);
        $cadena=str_ireplace("::", "", $cadena);
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);
        return $cadena;
    }
    public function borrar_usuario($id_usuario = null)
    {
        $usuarioModel = new Usuario();

        // Verificar si hay registros de tickets vinculados a este usuario
        $ticketModel = new Ticket();
        $ticketsRelacionados = $ticketModel->where('id_usuario', $id_usuario)->findAll();

        // Si hay registros de tickets relacionados, evita eliminar el usuario
        if (!empty($ticketsRelacionados)) {
            $sesion = session();
            $sesion->setFlashdata("mensaje","El usuario no se puede eliminar");
            return redirect()->back()->withInput();        }

        // Si no hay registros de tickets relacionados, procede con la eliminación del usuario
        $usuarioModel->delete($id_usuario);

        // Redirigir de vuelta a la página de usuarios después de eliminar el usuario
        return redirect()->to(site_url('usuarios'))->with('success', 'Usuario eliminado correctamente.');
    }


  
    public function actualizar($id_usuario = null){
        $usuario = new Usuario();
        $id = $this->request->getVar('id'); 
        $nombre_usuario=$this->limpiar_cadena($this->request->getVar('nombre_usuario'));
        $password=$this->limpiar_cadena($this->request->getVar('password'));
        $tipo_usuario=$this->limpiar_cadena($this->request->getVar('tipo_usuario'));
        $estado_usuario=$this->limpiar_cadena($this->request->getVar('estado_usuario'));
        $confirmar_password =$this->limpiar_cadena( $this->request->getVar('confirmar_password'));
        //$usuario_existente = $usuario->where('nombre_usuario', $nombre_usuario)->first();
        
        if (!$this->longitud_valida($nombre_usuario, $password)) {
            $sesion = session();
            $sesion->setFlashdata("mensaje", "El nombre de usuario debe tener mínimo 4 caracteres y la contraseña debe tener mínimo 8 caracteres.");
            return redirect()->back()->withInput();
        }
        if (!$this->contrasena_fuerte($password)) {
            $sesion = session();
            $sesion->setFlashdata("mensaje", "La contraseña debe contener al menos un número, una letra minúscula, una letra mayúscula y un carácter especial.");
            return redirect()->back()->withInput();
        }
        if (!$this->es_valido($nombre_usuario, $password, $confirmar_password, $tipo_usuario, $estado_usuario)) {
            $sesion = session();
            $sesion->setFlashdata("mensaje", "Por favor, completa todos los campos obligatorios.");
            return redirect()->back()->withInput();
        }
        if (!$this->coincidir_password($password,$confirmar_password)) {
            $sesion = session();
            $sesion->setFlashdata("mensaje","Las contraseñas no coinciden. Por favor, inténtalo de nuevo.");
            return redirect()->back()->withInput();
        }
        
            $password_encriptada = $this->encriptar($password, 'Hola123.');

            $datos = [
                "nombre_usuario" => $nombre_usuario,
                "password" => $password_encriptada,
                "tipo_usuario" => $tipo_usuario,
                "estado_usuario" => $estado_usuario
            ];
    
        $usuario->update($id, $datos);
    
        return $this->response->redirect(site_url('usuarios'));
    }
    
    

    public function editar($id_usuario=null){
        $usuario = new Usuario();
        $datos['usuario']= $usuario->where('id_usuario',$id_usuario)->first();
        
        if (!$datos['usuario']) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }
        
        $datos['usuario']['password'] = $this->desencriptar($datos['usuario']['password'], 'Hola123.');
        
        $datos['cabecera2'] = view('template/cabecera_actualizar');
        $datos['piepagina'] = view('template/piepagina');
        
        return view("usuarios/actualizar_usuarios", $datos);
    }
    
    
    public function encriptar($password, $clave) {
        $iv = random_bytes(16); 
        $texto_encriptado = openssl_encrypt($password, 'aes-256-cbc', $clave, 0, $iv);
        return base64_encode($iv . $texto_encriptado); 
    }
    
    public function desencriptar($password, $clave) {
        $datos = base64_decode($password);
        $iv = substr($datos, 0, 16); 
        $password = substr($datos, 16);
        $password = openssl_decrypt($password, 'aes-256-cbc', $clave, 0, $iv);
        return $password;
    }
}