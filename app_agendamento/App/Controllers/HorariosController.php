<?php
namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;

    class HorariosController extends Action{
        
        public function addHorario(){
            $horario = Container::getModel('Horario');
            $horario->__set('horario', $_POST['horario']);
            $horario->create();
            $response = $horario->read();
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }
?>