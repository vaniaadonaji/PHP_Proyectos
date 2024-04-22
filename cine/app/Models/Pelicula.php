<?php 
namespace App\Models;

use CodeIgniter\Model;

class Pelicula extends Model{
    protected $table      = 'peliculas';
    
    protected $primaryKey = 'id_pelicula';
    protected $allowedFields = ['titulo_pelicula','duracion','sinopsis', 'genero','imagen','precio','estado_pelicula'];
}