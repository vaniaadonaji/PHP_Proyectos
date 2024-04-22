<?php

use App\Controllers\Taquilla;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// La diagonal es la parte que se agrega a la URL, Login es el controlador, index es la funcion 
//ruta para el login
$routes->get('/', 'Login::index');
//ruta para la lista de los usuarios
$routes->get('usuarios', 'Usuarios::usuarios_view',['filter' => 'auth']);
//ruta para la vista de crear un usuario
$routes->get('usuarios/crear', 'Usuarios::crear_usuario_view',['filter' => 'auth']);
//ruta para guardar un usuario
$routes->post('usuarios/guardar', 'Usuarios::guardar_usuario', ['filter' => 'auth']);
//ruta para borrar un usuario
$routes->post('usuarios/borrar/(:num)', 'Usuarios::borrar_usuario/$1',['filter' => 'auth']);
//ruta para loggear un usuario
$routes->post('login', 'Login::loggeo');
//no me acuerdo, creo que no hace nada, solo era un ejemplo
$routes->get('dashboard', 'Usuarios::dashboard', ['filter' => 'auth']);
//ruta para la vista de editar con id
$routes->get('usuarios/editar/(:num)', 'Usuarios::editar/$1',['filter' => 'auth']);
//ruta para actualizar ese usuario
$routes->post('usuarios/actualizar', 'Usuarios::actualizar', ['filter' => 'auth']);
//ruta para taquilla
$routes->get('taquilla', 'Taquilla::index', ['filter' => 'auth']);
//ruta para salir de la sesión
$routes->get('salir', 'Login::logout');
//ruta para la vista del HOME
$routes->get('home', 'Home::index', ['filter' => 'auth']);
//ruta para la vista del de peliculas
$routes->get('peliculas', 'Peliculas::index', ['filter' => 'auth']);
//ruta para la vista de crear una pelicula
$routes->get('peliculas/crear', 'Peliculas::crear_pelicula_view',['filter' => 'auth']);
//ruta para guardar una pelicula
$routes->post('peliculas/guardar', 'Peliculas::guardar_pelicula', ['filter' => 'auth']);
//ruta para borar un usuario
$routes->post('peliculas/borrar/(:num)', 'Peliculas::borrar_pelicula/$1',['filter' => 'auth']);
//ruta para la vista de actualizar
$routes->get('peliculas/editar/(:num)', 'Peliculas::editar_pelicula/$1');
//ruta para actualizar una pelicula
$routes->post('peliculas/actualizar', 'Peliculas::actualizar_pelicula');
//ruta para obtener los horarios de la sala
$routes->get('taquilla/horarios/(:num)', 'Horarios::getHorariosPorSala/$1');
// Ruta para comprar boletos
$routes->get('taquilla/comprar/(:num)', 'Taquilla::vista_comprar_boletos/$1');
// Ruta para filtrar películas
$routes->get('taquilla/filtrarPeliculas/(:num)', 'Taquilla::filtrarPeliculas/$1');
// Ruta para guardar en ticket
$routes->post('taquilla/guardar', 'Taquilla::guardar_ticket');
// Ruta de la vista de ventas
$routes->get('ventas', 'Taquilla::vista_ventas');
//Ruta para eliminar una venta
$routes->post('ticket/borrar/(:num)', 'Taquilla::eliminar_ticket/$1');
//Ruta para editar una venta
$routes->get('ticket/editar/(:num)', 'Taquilla::editar_ticket/$1');
// ruta para actualizar la venta
$routes->post('ticket/actualizar', 'Taquilla::actualizar_ticket');