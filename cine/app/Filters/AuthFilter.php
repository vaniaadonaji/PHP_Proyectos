<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (!$session->has('id_usuario')) {
            return redirect()->to('/')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $tipo_usuario = $session->get('tipo_usuario');
        $estado_usuario = $session->get('estado_usuario');

        if ($estado_usuario !== 'Activo') {
            return redirect()->to('/')->with('error', 'Tu cuenta está inactiva.');
        }

        if ($tipo_usuario !== 'Administrador' && $tipo_usuario !== 'Taquillero') {
            return redirect()->to('/')->with('error', 'No tienes permiso para acceder a esta página.');
        }

        $request = service('request');
        $uri = $request->uri;
        $path = $uri->getPath();

        if ($tipo_usuario === 'Taquillero' && 
            ($path === 'usuarios' || 
            $path === 'usuarios/crear' || 
            $path === 'usuarios/guardar' ||
            $path === 'home' || 
            $path === 'peliculas' || 
            $path === 'peliculas/crear' ||  
            $path === 'peliculas/guardar' ||  
            $path === 'usuarios/actualizar')) {
                $sesion = session();
                $sesion->setFlashdata("mensaje", "No tienes permiso para acceder a esta página.");
                return redirect()->back()->withInput();
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
