<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
//$routes->get('/contacto', 'Home::contacto');
$routes->get('/', 'Libros::index');
$routes->get('crear', 'Libros::crear');
$routes->post('guardar', 'Libros::guardar');
$routes->get('borrar/(:num)', 'Libros::borrar/$1');
$routes->get('editar/(:num)', 'Libros::editar/$1');
$routes->post('actualizar', 'Libros::actualizar');
$routes->get('descargar', 'DescargarArchivo::index');
$routes->get('correo', 'Libros::correo');
$routes->post('enviar-correo', 'EnviarCorreo::enviar');
$routes->get('undefined', 'Libro::undefined');
