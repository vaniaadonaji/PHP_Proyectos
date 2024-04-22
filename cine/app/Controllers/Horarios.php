<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Horario;
class Horarios extends Controller{

    public function getHorarios(){
        $horario = new Horario();
        $sala1= $horario->where('id_sala', 1);
        $datos['sala1']=$sala1;

        $sala2= $horario->where('id_sala', 2);
        $datos['sala2']=$sala2;

        $sala3= $horario->where('id_sala', 3);
        $datos['sala3']=$sala3;

        $sala4= $horario->where('id_sala', 4);
        $datos['sala4']=$sala4;

        $sala5= $horario->where('id_sala', 5);
        $datos['sala5']=$sala5;

        $sala6= $horario->where('id_sala', 6);
        $datos['sala6']=$sala6;

        $sala7= $horario->where('id_sala', 7);
        $datos['sala7']=$sala7;

        return $datos;
    }
    public function getHorariosPorSala($idSala) {
        $horarioModel = new Horario();
        $horarios = $horarioModel->where('id_sala', $idSala)->findAll();
    
        // Devolver los horarios como JSON
        return $this->response->setJSON($horarios);
    }
    
}