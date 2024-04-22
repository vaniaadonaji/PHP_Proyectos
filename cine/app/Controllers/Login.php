<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
//importamos el modelo de los usuarios
use App\Models\Usuario;
//Controlador del Login
class Login extends Controller{

    //Metodo de la vista del formulario del login
    public function index()
    {
        //retornamos la vista principal
        return view('principal/login');
    }

    //metodo para el inicio de sesion
    public function loggeo()
    {
        //hacemos un objeto de tipo Usuario
        $usuarioModel = new Usuario();
        //recogemos el nombre del usuario y su password desde el formulario
        $nombre_usuario = $this->request->getVar('nombre_usuario');
        $password = $this->request->getVar('password');
    
        //traemos el primer usuario encontrado en la base de datos con el nombre de usuario proporcionado
        $usuario = $usuarioModel->where('nombre_usuario', $nombre_usuario)->first();
        // si encontramos un usario con ese nombre entonces...
        if ($usuario) {
            //desencriptamos la contraseña de la base de datos
            $contrasenia = $this->desencriptar($usuario['password'], 'Hola123.');  
            // verificamos que la contraseña que esta en la base de datos
            // y la que dio el usuario en el formulario coinsidan  
            if ($contrasenia === $password) { 
    
                // si coinciden entonces verificamos que le usuario este activo
                if ($usuario['estado_usuario'] == 'Activo') {
    
                    // Dentro del método loggeo() después de iniciar sesión y redirigir al usuario
                    if ($usuario['tipo_usuario'] == 'Administrador') {
                        session()->set('id_usuario', $usuario['id_usuario']);
                        session()->set('tipo_usuario', $usuario['tipo_usuario']);
                        session()->set('estado_usuario', $usuario['estado_usuario']);
                        session()->set('nombre_usuario', $usuario['nombre_usuario']);
                        return redirect()->to('home/');
                    } elseif ($usuario['tipo_usuario'] == 'Taquillero') {
                        session()->set('id_usuario', $usuario['id_usuario']);
                        session()->set('tipo_usuario', $usuario['tipo_usuario']);
                        session()->set('estado_usuario', $usuario['estado_usuario']);
                        session()->set('nombre_usuario', $usuario['nombre_usuario']);
                        return redirect()->to('taquilla');
                    }
                // si no esta activo el usuario no lo dejamos pasar.
                } else {
                    // le mandamos un mensaje al usuario diciendo que su cuenta ya esta inactiva
                    $sesion = session();
                    $sesion->setFlashdata("mensaje", "Tu cuenta está inactiva");
                    //retornamos al usuario a la página donde estaba
                    return redirect()->back()->withInput();
                }
            // si las contraseñas no coinciden no lo dejamos pasar
            } else {
                //mandamos un mensaje donde le indicamos que la contraseña proporsionada es incorrecta
                $sesion = session();
                $sesion->setFlashdata("mensaje", "Contraseña Incorrecta");
                //retornamos al usuario a la página donde estaba
                return redirect()->back()->withInput();
            }
        } else {
            // si no se encontro ningun nombre de usuario igual al que fue proporsionado mandamos un mensaje
            // que indique que el nombre de usuario no fue encontrado
            $sesion = session();
            $sesion->setFlashdata("mensaje", "Usuario no encontrado");
            //retornamos al usuario a la página donde estaba
            return redirect()->back()->withInput();
        }
    }

    //metodo para desencriptar las contraseñas
    public function desencriptar($password, $clave) {
        //se decodifica la contraseña encriptada que esta en formato base64
        $datos = base64_decode($password);
        // La variable $iv se establece como los primeros 16 bytes de los datos decodificados. 
        //El vector de inicialización (IV) es necesario para el modo CBC del algoritmo de cifrado AES. 
        //Es esencialmente una semilla aleatoria que se utiliza junto con la clave para mejorar la seguridad de la encriptación.
        $iv = substr($datos, 0, 16); 
        //La contraseña encriptada se extrae de los datos decodificados. 
        //La contraseña encriptada aquí es el resto de los datos decodificados después de los primeros 16 bytes, que son el IV.
        $password = substr($datos, 16);
        //para desencriptar la contraseña. Toma como parámetros la contraseña encriptada, el algoritmo de cifrado (aes-256-cbc), 
        //la clave de desencriptación, un parámetro de opciones (en este caso, 0 para indicar que no se utilizan opciones adicionales), y el IV. 
        //Esta función utiliza la extensión OpenSSL de PHP para realizar la desencriptación.
        $password = openssl_decrypt($password, 'aes-256-cbc', $clave, 0, $iv);
        //retornamos la contraseña desencriptada
        return $password;
    }
    //metodo para cerrar sesion
    public function logout()
    {
        //destrozamos la sesion y redirigimos al usuario a que inicie sesion para poder acceder.
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}