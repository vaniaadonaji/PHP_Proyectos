<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
//Importamos el modelo de pelicula
use App\Models\Pelicula;
use App\Models\Ticket;
//Controlador de Peliculas
class Peliculas extends Controller{

    //metodo para retornar la vista principal de peliculas
    public function index()
    {
        //Hacemos un objeto de tipo Pelicula
        $pelicula = new Pelicula();
        //le pasamos a la vista un arreglo que almacenará diversos objetos
        //en eset caso cabecera que será igual a una vista
        $datos['cabecera'] = view('template/cabecera_peli');
        //y aca mandamos el pie de pagina
        $datos['piepagina'] = view('template/piepagina');

        //Hacemos la funcion de los filtros, genero, estado_pelicula y u(es la busqueda por texto)
        $filtro_genero = $this->request->getGet('genero');
        $filtro_estado_pelicula = $this->request->getGet('estado_pelicula');
        $filtro_titulo_pelicula = $this->limpiar_cadena($this->request->getGet('u'));

        //hacemos una variable que será igual al objeto de tipo pelicula
        $query = $pelicula; 
        //si el filtro es diferente a genero entonces...
        if ($filtro_genero && $filtro_genero != 'genero') {
            // se hará una consulta a la base de datos en donde se buscara la opcion del genero para mostrarse
            $query = $query->where('genero', $filtro_genero);
        }
        //si el filtro es diferente a estado_pelicula entonces...
        if ($filtro_estado_pelicula && $filtro_estado_pelicula != 'estado_pelicula') {
            //Hara una consulta a la base de datos y traerá la opción deseada por el usuario
            $query = $query->where('estado_pelicula', $filtro_estado_pelicula);
        }
        // si se escribe en el input entonces..
        if ($filtro_titulo_pelicula) {
            // se hara una consulta con like en donde mostrará todas las peliculas que contengan 
            //las letras, silabas o palabras que contenga el titulo de la pelicula
            $query = $query->like('titulo_pelicula', $filtro_titulo_pelicula);
        }
        //Contará todas las peliculas mostradas para el paginado
        $total_peliculas = count($query->findAll());
        //Le decimos las peliculas que queremos que esten mostradas en cada pagina
        $peliculas_por_pagina = 5;
        //Hacemos una división del total de las peliculas entre las peliculas 
        //por pagina para mostrar los iconos del paginado
        $total_pages = ceil($total_peliculas / $peliculas_por_pagina);
        //Modificamos la ruta de navegacion segun la pagina del paginado en que estamos
        $current_page = $this->request->getVar('page') ?? 1;
        //Calcula el desplazamiento necesario para obtener el conjunto de elementos de una lista (por ejemplo, películas) 
        //que deben mostrarse en una página específica, dado el número de elementos que se mostrarán por página y el número de la página actual.
        $offset = ($current_page - 1) * $peliculas_por_pagina;

        //Hacemos de nuevo los filtros para mantenerlos
        $query = $pelicula;
        if ($filtro_genero && $filtro_genero != 'genero') {
            $query = $query->where('genero', $filtro_genero);
        }
        if ($filtro_estado_pelicula && $filtro_estado_pelicula != 'estado_pelicula') {
            $query = $query->where('estado_pelicula', $filtro_estado_pelicula);
        }
        if ($filtro_titulo_pelicula) {
            $query = $query->like('titulo_pelicula', $filtro_titulo_pelicula);
        }
        //Ordenamos las peliculas por el título de la película y se la mandamos por el arreglo
        $datos['peliculas'] = $query->orderBy('titulo_pelicula', 'ASC')->findAll($peliculas_por_pagina, $offset);
        //mandamos el total de paginas que se calcularon
        $datos['total_pages'] = $total_pages;
        //Mandamos la ruta
        $datos['current_page'] = $current_page;
        //retornamos la vista y le mandamos el vector de $datos que contiene los datos requeridos para la vista
        return view('peliculas/principal_peliculas', $datos);
    }


    //metodo para crear una nueva pelicula
    public function crear_pelicula_view()
    {
        //Hacemos un vector que mandara a la vista diversos datos, en este caso la cabecera de la pagina y el pie de pagina
        $datos['cabecera2'] = view('template/cabecera_insertar');
        $datos['piepagina'] = view('template/piepagina');
        //Retornamos la vista y le mandamos el arreglo
        return view('peliculas/insertar_pelicula', $datos);
    }

    //metodo para guardar la pelicula en la base de datos
    public function guardar_pelicula()
    {
        //Hacemos un objeto de tipo pelicula
        $pelicula = new Pelicula();
        //obtenemos los datos del formulario, pero antes los mandamos a un metodo para que limpie los datos ingresados
        $titulo_pelicula=$this->limpiar_cadena($this->request->getVar('titulo_pelicula'));
        $duracion=$this->limpiar_cadena($this->request->getVar('duracion'));
        $sinopsis=$this->limpiar_cadena($this->request->getVar('sinopsis'));
        $genero=$this->limpiar_cadena($this->request->getVar('genero'));
        $imagen =$this->request->getFile('imagen');
        $estado_pelicula=$this->limpiar_cadena($this->request->getVar('estado_pelicula'));
        $precio=$this->limpiar_cadena($this->request->getVar('precio'));
        //obtenemos el titulo de la pelicula y hacemos una consulta para verificar que el tirulo no este ya ocupado
        $pelicula_existente = $pelicula->where('titulo_pelicula', $titulo_pelicula)->first();
        //validamos que la imagen tenga una extension de acuerdo a las especificaciones de uan imagen 
        //y que esta no sea mayor a 1024px
        $validacion =$this->validate([
            'imagen'=>
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png,image/webp]',
                'max_size[imagen,2048]',
        ]);
        //si la validacion no se cumple
        if(!$validacion){
            //mandamos un mensaje al usuario informando las características de la imágen
            $session = session();
            $session->setFlashdata("mensaje","Información inválida. El archivo debe ser una imágen tipo: -jpg -jpeg -png -webp y que esta no sea mayor a 2048píxeles");
            //retornamos al usuario a la página donde estaba
            return redirect()->back()->withInput();
        }
        //si la pelicula ya existe 
        if ($pelicula_existente) {
            //mandamos un mensaje diciendo que la pelicula ya existe
            $sesion = session();
            $sesion->setFlashdata("mensaje", "La película ya existe");
            //retornamos al usuario a la página donde estaba
            return redirect()->back()->withInput();
        }
        //mandamos llamar un metodo, si la longitud no es valida
        if (!$this->longitud_valida($titulo_pelicula)) {
            //mandamos un mensaje informando al usuario
            $sesion = session();
            $sesion->setFlashdata("mensaje", "El titulo de la pelicula debe tener mínimo 2 caracteres.");
            //retornamos al usuario a la página donde estaba
            return redirect()->back()->withInput();
        }
        //mandamos llamar un metodo para verificar que no esten nulos los campos
        if (!$this->es_valido($titulo_pelicula, $duracion, $sinopsis, $genero, $precio, $estado_pelicula)) {
            //mandamos un mensaje informando al usuario
            $sesion = session();
            $sesion->setFlashdata("mensaje", "Por favor, completa todos los campos obligatorios.");
            //retornamos al usuario a la página donde estaba
            return redirect()->back()->withInput();
        }
            //en caso de cumplir con todo, renombramos la imagen, para que no haya confución en la base de datos
            $nuevoNombre=$imagen->getRandomName();
            //La imagen la guardamos en una carpeta en el servidor y le damos el nuevo nombre
            $imagen->move("../public/uploads/", $nuevoNombre);
            //hacemos un arreglo donde vamos a guardar los datos especificando el campo de la base de datos junto con su información
            $datos = [
                "titulo_pelicula" => $titulo_pelicula,
                "duracion" => $duracion,
                "sinopsis" => $sinopsis,
                "genero" => $genero,
                "imagen" => $nuevoNombre,
                "precio" => $precio,
                "estado_pelicula" => $estado_pelicula,
            ];
            //Insertamos los datos
            $pelicula->insert($datos);  
            //retornamos al usuario a la pagina principal de peliculas  
            return $this->response->redirect(site_url('peliculas'));
    }
    //metodo para verificar que la longitud sea valida
    private function longitud_valida($pelicula)
    {
        //si el titulo es menor a 1 
        if (strlen($pelicula) < 1 ) {
            //retornamos falso
            return false;
        }
        // si no es menos a 1, retornamos verdad
        return true;
    }

    //metodo para saber si todos los campos fueron llenados
    private function es_valido($titulo_pelicula, $duracion, $sinopsis, $genero, $precio, $estado_pelicula)
    {
        //si algun campo es nulo
        if (empty($titulo_pelicula) || empty($duracion) || empty($sinopsis) || empty($genero) || empty($precio) || empty($estado_pelicula)) {
            //retornamos falso
            return false;
        }
        //en caso contrario se retorna verdadero
        return true;
    }

    //metodo para limpiar los campos que meta el usuario
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
    //metodo para borar una pelicula
    public function borrar_pelicula($id_pelicula = null)
    {
        // Creamos una instancia del modelo Pelicula
        $peliculaModel = new Pelicula();

        // Verificar si hay registros de tickets vinculados a esta película
        $ticketModel = new Ticket();
        $ticketsRelacionados = $ticketModel->where('id_pelicula', $id_pelicula)->findAll();

        // Si hay registros de tickets relacionados, evita eliminar la película
        if (!empty($ticketsRelacionados)) {
            $session = session();
            $session->setFlashdata("mensaje","La pelicula no se puede eliminar");
            //retornamos al usuario a la página donde estaba
            return redirect()->back()->withInput();
        }

        $datosPelicula = $peliculaModel->find($id_pelicula);

        if (!$datosPelicula) {
            
        }

        $rutaImagen = '../public/uploads/' . $datosPelicula['imagen'];
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }

        $peliculaModel->delete($id_pelicula);

        return redirect()->to(site_url('peliculas'))->with('success', 'Se eliminó la película "' . $datosPelicula['titulo_pelicula'] . '" con el ID: ' . $id_pelicula);
    }

    //metodo que retorna la vista de editar una pelicula
    public function editar_pelicula($id_pelicula=null){
        // Crea una nueva instancia de la clase Pelicula
        $pelicula = new Pelicula();
        // Obtiene los datos de una película específica utilizando el ID proporcionado como parámetro
        // y los asigna a la variable $datos['pelicula']
        $datos['pelicula']= $pelicula->where('id_pelicula',$id_pelicula)->first();
        // Asigna vistas de cabecera y pie de página a las variables $datos['cabecera2'] y $datos['piepagina'], respectivamente.
        $datos['cabecera2'] = view('template/cabecera_actualizar');
        $datos['piepagina'] = view('template/piepagina');
        // Devuelve una vista llamada "peliculas/actualizar_peliculas" con los datos obtenidos
        return view("peliculas/actualizar_peliculas", $datos);
    }

    //metodo que actualiza una pelicula
    public function actualizar_pelicula($id_pelicula=null){
        // Crea una nueva instancia de la clase Pelicula
        $pelicula = new Pelicula();

        // Obtiene el ID de la película del formulario de solicitud
        $id_pelicula=$this->request->getVar('id');

        // Obtiene los datos del formulario de solicitud y los limpia utilizando la función limpiar_cadena
        $titulo_pelicula=$this->limpiar_cadena($this->request->getVar('titulo_pelicula'));
        $duracion=$this->limpiar_cadena($this->request->getVar('duracion'));
        $sinopsis=$this->limpiar_cadena($this->request->getVar('sinopsis'));
        $genero=$this->limpiar_cadena($this->request->getVar('genero'));
        $estado_pelicula=$this->limpiar_cadena($this->request->getVar('estado_pelicula'));
        $precio=$this->limpiar_cadena($this->request->getVar('precio'));

        //mandamos llamar un metodo, si la longitud no es valida
        if (!$this->longitud_valida($titulo_pelicula)) {
            //mandamos un mensaje informando al usuario
            $sesion = session();
            $sesion->setFlashdata("mensaje", "El titulo de la pelicula debe tener mínimo 2 caracteres.");
            //retornamos al usuario a la página donde estaba
            return redirect()->back()->withInput();
        }
        //mandamos llamar un metodo para verificar que todos los campos se hayan llenado
        if (!$this->es_valido($titulo_pelicula, $duracion, $sinopsis, $genero, $precio, $estado_pelicula)) {
            //mandamos un mensaje informando al usuario
            $sesion = session();
            $sesion->setFlashdata("mensaje", "Por favor, completa todos los campos obligatorios.");
            //retornamos al usuario a la página donde estaba
            return redirect()->back()->withInput();
        }
        // Define un arreglo con los datos de la película, exepto de la imagen
        $datos = [
            "titulo_pelicula" => $titulo_pelicula,
            "duracion" => $duracion,
            "sinopsis" => $sinopsis,
            "genero" => $genero,
            "precio" => $precio,
            "estado_pelicula" => $estado_pelicula,
        ];
        // Actualiza la película en la base de datos con los nuevos datos proporcionados
            $pelicula->update($id_pelicula,$datos);
            // en caso de que se proporcione una nueva imagen
            //validamos que la imagen tenga una extension de acuerdo a las especificaciones de uan imagen 
            //y que esta no sea mayor a 1024px
            $validacion =$this->validate([
                'imagen'=>
                    'uploaded[imagen]',
                    'mime_in[imagen,image/jpg,image/jpeg,image/png,image/webp]',
                    'max_size[imagen,2048]',
            ]);
            // Maneja el caso en el que se carga una nueva imagen
            if($validacion){
                //obtiene la imagen del formulario
                if($imagen=$this->request->getFile("imagen")){
                    
                    //obtiene la pelicula a actualizar por medio del id
                    $datosPelicula = $pelicula->where('id_pelicula',$id_pelicula)->first();
                    //obtiene la ruta de la imagen que tenía la pelicula
                    $ruta =('../public/uploads/'. $datosPelicula['imagen']);
                    //elimina la imagen
                    unlink($ruta);

                    //pone un nuevo nombre a la imagen ingresada
                    $nuevoNombre=$imagen->getRandomName();
                    //coloca la nueva imagen en la carpeta del servidor
                    $imagen->move("../public/uploads/", $nuevoNombre);
                    //la guarda en el arreglo
                    $datos=["imagen"=>$nuevoNombre];
                    //actualiza la imagen de la pelicula
                    $pelicula->update($id_pelicula,$datos);
                }
            }
            //redirecciona a la vista principal de peliculas
            return $this->response->redirect(site_url('/peliculas'));
    }
}