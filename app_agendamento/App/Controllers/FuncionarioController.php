<?php
namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;

class FuncionarioController extends Action{


    public function create(){
        $this->validaAutenticacao();
        $turnos = [];

        $funcionario = Container::getModel('Funcionario');
        $horarios = Container::getModel('Horario');
        $diasSemana = Container::getModel('DiaSemana');
        

        if($_POST['id_horario'][0] && $_POST['id_horario'][0] !== "0"){
            $dias = [];
            if(isset($_POST['dia_semana1'])){
                 
                 for ($i=0; $i < count($_POST['dia_semana1']); $i++) { 
                    array_push($dias, ['dia' => $_POST['dia_semana1'][$i], 'label_dia' =>  $diasSemana->labelDias($_POST['dia_semana1'][$i]),'atendimentos' => $_POST['numero_vagas1'][$i]]);
                 }
     
                $horario = [
                     'horario_id' => $_POST['id_horario'][0],
                     'horario_label' => $horarios->labelHorarios($_POST['id_horario'][0]),
                     'dias' => $dias
                ];
                array_push($turnos, $horario);
            }
        }

        if($_POST['id_horario'][1] && $_POST['id_horario'][1] !== "0"){
            $dias = [];
            if(isset($_POST['dia_semana2'])){
                 
                 for ($i=0; $i < count($_POST['dia_semana2']); $i++) { 
                    array_push($dias, ['dia' => $_POST['dia_semana2'][$i], 'label_dia' =>  $diasSemana->labelDias($_POST['dia_semana2'][$i]),'atendimentos' => $_POST['numero_vagas2'][$i]]);
                 }
     
                $horario = [
                     'horario_id' => $_POST['id_horario'][1],
                     'horario_label' => $horarios->labelHorarios($_POST['id_horario'][1]),
                     'dias' => $dias
                ];
                array_push($turnos, $horario);
            }
        }

        if($_POST['id'] === ''){
            if($_POST['id_setor']  !== '' && $_POST['id_setor']  === '2' && $turnos !== [] && $_POST['email'] !== '' && $_POST['senha'] !== '' && $_POST['nome'] !== '' && $_POST['telefone'] !== '' && $_POST['id_horario'] !== ''){
                    $funcionario->__set('email', $_POST['email']);
                    $funcionario->__set('senha', md5($_POST['senha']));
                    $funcionario->__set('nome', $_POST['nome']);
                    $funcionario->__set('telefone', $_POST['telefone']);
                    $funcionario->__set('id_setor', $_POST['id_setor']);
                    $funcionario->__set('turnos', json_encode($turnos, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                    $funcionario->create();
                echo json_encode(['Sucesso' => 'Médico cadastrado com sucesso na base de dados']);
            }
            else if($_POST['id_setor'] !== '' && $_POST['id_setor']  !== '2' && $_POST['email'] !== '' && $_POST['senha'] !== '' && $_POST['nome'] !== '' && $_POST['telefone'] !== '' && $_POST['id_horario'] !== ''){
                    $funcionario->__set('email', $_POST['email']);
                    $funcionario->__set('senha', md5($_POST['senha']));
                    $funcionario->__set('nome', $_POST['nome']);
                    $funcionario->__set('telefone', $_POST['telefone']);
                    $funcionario->__set('id_setor', $_POST['id_setor']);
                    $funcionario->create();
                echo json_encode(['Sucesso' => 'Funcionario cadastrado com sucesso na base de dados']);
            }else{
                echo json_encode(['Erro' => 'Por favor, preencha todos os campos']);
            }
        }else{
            if($_POST['id_setor']  !== '' && $_POST['id_setor']  === '2' && $turnos !== [] && $_POST['email'] !== '' && $_POST['nome'] !== '' && $_POST['telefone'] !== '' && $_POST['id_horario'] !== ''){
                $funcionario->__set('id', $_POST['id']);
                $funcionario->__set('email', $_POST['email']);
                $funcionario->__set('nome', $_POST['nome']);
                $funcionario->__set('telefone', $_POST['telefone']);
                $funcionario->__set('id_setor', $_POST['id_setor']);
                $funcionario->__set('turnos', json_encode($turnos, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                $funcionario->update();
                echo json_encode(['Sucesso' => 'Médico Alterado com sucesso']);
            }
            else if($_POST['id_setor'] !== '' && $_POST['id_setor']  !== '2' && $_POST['email'] !== '' && $_POST['nome'] !== '' && $_POST['telefone'] !== '' && $_POST['id_horario'] !== ''){
                    $funcionario->__set('id', $_POST['id']);
                    $funcionario->__set('email', $_POST['email']);
                    $funcionario->__set('nome', $_POST['nome']);
                    $funcionario->__set('telefone', $_POST['telefone']);
                    $funcionario->__set('id_setor', $_POST['id_setor']);
                    $funcionario->update();
                    echo json_encode(['Sucesso' => 'Funcionario alterado com sucesso']);
            }else{
                echo json_encode(['Erro' => 'Por favor, preencha todos os campos']);
            }
        }
    }

    public function read(){
        $this->validaAutenticacao();

        $funcionario = Container::getModel('Funcionario');

        if(!isset($_GET['id'])){
            $lista = $funcionario->read();
        }else{
            $funcionario->__set('id', $_GET['id']);
            $lista = $funcionario->getFuncionario();
        }

        echo json_encode($lista , JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function update(){

    }

    public function delete(){

    }
}

?>