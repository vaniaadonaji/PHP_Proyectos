<?php 
namespace App\Models;

use CodeIgniter\Model;

class Sala extends Model{
    protected $table      = 'salas';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $primaryKey = 'id_sala';
    protected $allowedFields = ['nombre_sala','descripcion'];
}