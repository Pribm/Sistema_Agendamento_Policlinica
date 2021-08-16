<?php
namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;

    class HorariosController extends Action{
        
        public function create(){
            $this->validaAutenticacao();
            $horario = Container::getModel('Horario');
            $horario->__set('horario', $_POST['horario']);
            $horario->create();
            $response = $horario->read();
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        public function read(){
            $this->validaAutenticacao();
            $horario = Container::getModel('Horario');
            echo json_encode(['horarios' => $horario->read()]);
        }

        public function delete(){
            $this->validaAutenticacao();
            $horario = Container::getModel('Horario');
            $horario->__set('id', $_GET['id']);
            echo json_encode(['horarios' => $horario->delete()]);
        }
    }
?>