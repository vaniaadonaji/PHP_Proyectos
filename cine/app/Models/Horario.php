<?php 
namespace App\Models;

use CodeIgniter\Model;

class Horario extends Model{
    protected $table      = 'horarios';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $primaryKey = 'id_horario';
    protected $allowedFields = ['horario_final','horario_inicio', 'id_sala'];
}