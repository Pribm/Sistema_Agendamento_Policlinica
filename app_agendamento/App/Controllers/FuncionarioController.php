<?php
namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;

class FuncionarioController extends Action{


    public function create(){
        print_r($_POST);
        $turnos = [];

        $funcionario = Container::getModel('Funcionario');
        $horarios = Container::getModel('Horario');
        $diasSemana = Container::getModel('DiaSemana');

        if($_POST['id_horario'][0]){

            $labelsDia = [];

            foreach ($_POST['dia_semana1'] as $dia) {
               array_push($labelsDia, $diasSemana->labelDias($dia));
            }

            $horario = [
                'horario1_id' => $_POST['id_horario'][0],
                'horario1_label' => $horarios->labelHorarios($_POST['id_horario'][0]),
                'dias_id' => $_POST['dia_semana1'],
                'dias_labels' =>  $labelsDia
            ];
            array_push($turnos, $horario);
        }

        if($_POST['id_horario'][1]){

            $labelsDia = [];

            foreach ($_POST['dia_semana2'] as $dia) {
               array_push($labelsDia, $diasSemana->labelDias($dia));
            }

            $horario = [
                'horario2' => $_POST['id_horario'][1],
                'horario2_label' => $horarios->labelHorarios($_POST['id_horario'][1]),
                'dias' => $_POST['dia_semana2'],
                'dias_labels' => $labelsDia
            ];
            array_push($turnos, $horario);
        }

        $funcionario->__set('email', $_POST['email']);
        $funcionario->__set('senha', md5($_POST['senha']));
        $funcionario->__set('nome', $_POST['nome']);
        $funcionario->__set('telefone', $_POST['telefone']);
        $funcionario->__set('id_setor', $_POST['id_setor']);
        $funcionario->__set('turnos', json_encode($turnos, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        $funcionario->create();

        
    }

    public function read(){
        $funcionario = Container::getModel('Funcionario');
        $lista = $funcionario->read();
        echo json_encode($lista , JSON_UNESCAPED_SLASHES);
    }

    public function update(){

    }

    public function delete(){

    }
}

?>