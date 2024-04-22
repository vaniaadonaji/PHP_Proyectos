<?php

namespace App\Controllers;
//Controlador del Inicio

class Home extends BaseController
{
    //Metodo para mandar llamar la vista principal al inicar sesion
    public function index(): string
    {
        //Retornar la vista al ser llamdo el metodo
        return view('principal/home');
    }
}   