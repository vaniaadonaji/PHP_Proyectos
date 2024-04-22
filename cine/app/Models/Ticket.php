<?php 
namespace App\Models;

use CodeIgniter\Model;

class Ticket extends Model{
    protected $table      = 'tickets';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $primaryKey = 'id_ticket';
    protected $allowedFields = ['id_sala','id_horario','numero_asientos', 'fecha_compra','nombre_cliente','folio','id_pelicula','total','id_usuario'];
}