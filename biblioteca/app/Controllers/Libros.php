<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Libro;
class Libros extends Controller{

    public function index(){
        $libro = new Libro();
        $datos['libros'] = $libro->orderBy('id','ASC')->findAll();
        $datos['cabecera'] = view('template/cabecera');
        $datos['piepagina'] = view('template/piepagina');
        return view("libros/listar", $datos);
    }
    public function crear(){
        $datos['cabecera'] = view('template/cabecera');
        $datos['piepagina'] = view('template/piepagina');
        return view("libros/crear", $datos);
    }

    public function guardar(){
        $libro = new Libro();
        $nombre = $this->request->getVar("nombre");
        $imagen=$this->request->getFile("imagen");

        $validacion =$this->validate([
            "nombre"=> "required|min_length[3]",
            'imagen'=>
                'uploaded[imagen]',
                'mime_in[imagen,image/jpg,image/jpeg,image/png,image/webp]',
                'max_size[imagen,1024]',
        ]);

        if($validacion){
            if($imagen=$this->request->getFile("imagen")){
                $nuevoNombre=$imagen->getRandomName();
                $imagen->move("../public/uploads/", $nuevoNombre);
                $datos=["nombre"=>$nombre,"imagen"=>$nuevoNombre];
            }
        }else{
            $session = session();
            $session->setFlashdata("mensaje","Información inválida, el libro debe contener más de 3 caracteres 
            y el archivo debe ser una imágen, extensión (.png, .jpg, .jpeg o .webp).
            \n Y ambos son Obligatorios");

            return redirect()->back()->withInput();
        }
        $libro->insert($datos);
        print_r($this->request->getFile("imagen"));
        print_r($this->request->getVar("nombre"));
        return $this->response->redirect(site_url('/'));
    }
    public function borrar($id=null){
        echo('Borrar registro'. $id );
        $libro = new Libro();
        $datosLibro = $libro->where('id',$id)->first();
        $ruta =('../public/uploads/'. $datosLibro['imagen']);
        unlink($ruta);
        $libro->where('id',$id)->delete($id);
        echo('Se elimino el libro '.$datosLibro['nombre'].' con el id: '.$id);
        return $this->response->redirect(site_url('/'));
    }
    
    public function editar($id=null){
        $libro = new Libro();
        $datos['libro']= $libro->where('id',$id)->first();
        $datos['cabecera'] = view('template/cabecera');
        $datos['piepagina'] = view('template/piepagina');
        return view("libros/editar", $datos);
    }

    public function actualizar($id=null){
        $libro = new Libro();

        $datos=["nombre"=>$nombre=$this->request->getVar("nombre")];   

        $id=$this->request->getVar('id');
        $validacion =$this->validate([
            'nombre'=> 'required|min_length[3]',
        ]);
        if(! $validacion){
            $session = session();
            $session->setFlashdata("mensaje","Información inválida, el libro debe contener más de 3 caracteres 
            y el archivo debe ser una imágen, extensión (.png, .jpg, .jpeg o .webp).
            \n Y ambos son Obligatorios");

            return redirect()->back()->withInput();
        }
        else{
            $libro->update($id,$datos);
            $validacion =$this->validate([
                'imagen'=>
                    'uploaded[imagen]',
                    'mime_in[imagen,image/jpg,image/jpeg,image/png,image/webp]',
                    'max_size[imagen,1024]',
            ]);
            if($validacion){
                if($imagen=$this->request->getFile("imagen")){
                    
                    $datosLibro = $libro->where('id',$id)->first();
                    $ruta =('../public/uploads/'. $datosLibro['imagen']);
                    unlink($ruta);

                    $nuevoNombre=$imagen->getRandomName();
                    $imagen->move("../public/uploads/", $nuevoNombre);
                    $datos=["imagen"=>$nuevoNombre];
                    $libro->update($id,$datos);
                }
            }
            return $this->response->redirect(site_url('/'));
        }
    }
    public function correo(){
        $datos['cabecera'] = view('template/cabecera');
        $datos['piepagina'] = view('template/piepagina');
        return view("correo/ver-correo", $datos);
    }
}