<?php
namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;
use MF\Controller\FormInputFunctions;


class AppController extends Action{


    //as funções dessa classe equivalem as actions estabelecidas dentro da rota
    public function navAgendaPaciente(){
        $this->validaAutenticacao();
        $this->view->agendado = '';

        $medicos = Container::getModel('Usuario');
        $this->view->medicos = $medicos->listaMedicos();

        $this->render('agenda_paciente', 'layout');
    }

    public function navAgendaDia(){
        $this->validaAutenticacao();

        $usuario = Container::getModel('Usuario');
        $this->view->medicos = $usuario->listaMedicosAtivosInativos();

        $this->view->agendamentos = $usuario->listaAgendamentos();

        //print_r($usuario->listaAgendamentos());

        $this->render('agenda_dia', 'layout');
    }

    public function navCadastraFuncionario(){
        $this->validaAutenticacao();

        $setores = Container::getModel('Usuario');

        //incluir no formulario da view os setores.
        $this->view->setores = $setores->listaSetores();

        //incluir na tabela os funcionarios cadastrados.
        $this->view->funcionarios = $setores->listaFuncionarios();

        $this->render('cadastra_funcionario', 'layout');
    }

    public function navRelatorio_atendidos(){
        $this->validaAutenticacao();

        $medicos = Container::getModel('Usuario');
        $this->view->medicos = $medicos->listaMedicosAtivosInativos();
        
        $this->render('relatorio_atendidos', 'layout');
    }


    //*********---------|| FIM DOS NAVS ||---------------********//
    public function cadastraFuncionario(){
        $this->validaAutenticacao();

        $response['email'] = $_POST['email'];
        $response['senha'] = $_POST['senha'];
        $response['nome'] = $_POST['nome'];
        $response['telefone'] = $_POST['telefone'];
        $response['id_setor'] = $_POST['id_setor'];
        
        $funcionario = Container::getModel('Usuario');

        $funcionario->__set('email', $_POST['email']);
        $funcionario->__set('senha', $_POST['senha']);
        $funcionario->__set('nome', $_POST['nome']);
        $funcionario->__set('telefone', $_POST['telefone']);
        $funcionario->__set('id_setor', $_POST['id_setor']);
        
        $funcionario->cadastraFuncionario();

        $this->view->setores = $funcionario->listaSetores();

        echo json_encode($funcionario->listaFuncionarios());
    }

    public function listaFuncionarios(){
        $funcionario = Container::getModel('Usuario');
        echo json_encode($funcionario->listaFuncionarios());
    }

    public function agendaPaciente(){
        $this->validaAutenticacao();

        $paciente = Container::getModel('Consulta');
        
        $medicos = Container::getModel('Usuario');
        $this->view->medicos = $medicos->listaMedicos();

        if($_POST['paciente'] != '' && $_POST['medico_id'] != '' && $_POST['prontuario'] != '' && $_POST['sus'] != '' && $_POST['horario'] != '' && $_POST['dia'] != ''){
            $paciente->__set('paciente',$_POST['paciente']);
            $paciente->__set('medico_id',$_POST['medico_id']);
            $paciente->__set('prontuario',$_POST['prontuario']);
            $paciente->__set('sus',$_POST['sus']);
            $paciente->__set('horario',$_POST['horario']);
            $paciente->__set('dia',$_POST['dia']);
            $paciente->__set('agendado_por',$_POST['agendado_por']);

            $this->view->agendado = 's';

            $paciente->agendaPaciente();
        }else{
            $this->view->agendado = 'n';
        }
        
        $this->render('agenda_paciente', 'layout');
    }


    public function acao(){
        if(isset($_GET['action']) && $_GET['action'] == 'delete'){
            $usuario = Container::getModel('Usuario');
            $usuario->deletar($_GET['id']);
        }

        if(isset($_GET['action']) && $_GET['action'] == 'atender'){
            $consulta = Container::getModel('Consulta');
            $response = $consulta->atender($_GET['id']);
            $response['atendido'] = 's';
            echo json_encode($response);
        }
    }

    public function filtraAgendamento(){
        $this-> validaAutenticacao();
    
        $consulta = Container::getModel('Consulta');
        $medicos = Container::getModel('Usuario');

        $consulta->__set('paciente', $_POST['paciente']);
        $consulta->__set('prontuario', $_POST['prontuario']);
        $consulta->__set('horario', $_POST['horario']);
        $consulta->__set('dia', $_POST['data']);
        $consulta->__set('medico_id', $_POST['medico']);
        
        
        $response['filtro_array'] = $consulta->filtrar();
        echo json_encode($response);

    }



    public function filtrarRelatorio(){

       /* echo '<pre>';
        print_r($_POST);
        echo '</pre>';*/
        
        $dates = FormInputFunctions::getDatesFromRange(date($_POST['data_inicio']), date($_POST['data_fim']));
        $atendidos = Container::getModel('Relatorio_Atendidos');

        //cria os arrays necessários
        $atendimentosPorDia = array();
        $medicos = array();
        $quantidadeAtendimentos = array();
        $post_medicos = array();
        $post_cores = array();
        $response = array();
        $responses = array();
        $cores = array();
        

        //esse laço pega a variável dinâmica de médicos passadas do lado do frontEnd nomeada como medico_[i]
        foreach ($_POST as $k => $v) {
            if(strpos($k, 'medico_') === 0){
                $post_medicos[$k]  = $v;
                
            }
        }
     
        foreach ($dates as $key => $date) {
            $atendidos->__set('dia', $date);
            foreach ($post_medicos as $med => $medico) {
                $atendidos->__set('medico_id', $medico);
                $atendimentosPorDia[$med][] = $atendidos->contagemAgendamentosPorMedico()['atendidos'];
            }
        }

        foreach ($post_medicos as $keyM => $medico) {

            $usuario = Container::getModel('Usuario');
            $medicoNome = $usuario->selecionaMedicos($medico);

            $response['label'] = $medicoNome['nome'];
            $response['datas'] = $dates;
            $response['data'] = $atendimentosPorDia[$keyM];

            foreach ($dates as $key => $date) {
                $atendidos->__set('dia', $date);
            }

                $responses[] = $response;
        }

        foreach ($atendimentosPorDia as $key => $att) {
                $response['atendimentos'] = $att;
        }

        echo json_encode($responses);
    }

    
    public function validaAutenticacao(){

        session_start();

        $this->view->usuario = $_SESSION['nome'];

        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
            header('Location: /?login=erro2');
        }
    }

  
}
?>