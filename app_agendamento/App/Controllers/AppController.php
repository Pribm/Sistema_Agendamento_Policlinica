<?php
namespace App\Controllers;
use MF\Model\Container;
use MF\Controller\Action;
use MF\Controller\FormInputFunctions;
class AppController extends Action{
    //as funções dessa classe equivalem as actions estabelecidas dentro da rota
    public function navAgendaPaciente(){
        $this->validaAutenticacao();
        $this->view->status = '';
        $medicos = Container::getModel('Usuario');
        $this->render('agenda_paciente', 'layout');
    }

    public function navAgendaDia(){
        $this->validaAutenticacao();
        $usuario = Container::getModel('Usuario');
        $this->view->medicos = $usuario->listaMedicosAtivosInativos();
        $this->view->agendamentos = $usuario->listaAgendamentos();
        $this->render('agenda_dia', 'layout');
    }

    public function navCadastraFuncionario(){
        $this->validaAutenticacao();
        $setores = Container::getModel('Usuario');
        //incluir no formulario da view os setores.
        $this->view->setores = $setores->listaSetores();
        $this->view->horarios = $setores->listaHorarios();
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
        if($_POST['email'] != '' && $_POST['senha'] != '' && $_POST['nome'] != '' && $_POST['telefone'] != '' && $_POST['id_setor'] != ''){
            /*echo '<pre>';
            print_r($_POST);
            echo '</pre>';*/
            $funcionario->__set('email', $_POST['email']);
            $funcionario->__set('senha', $_POST['senha']);
            $funcionario->__set('nome', $_POST['nome']);
            $funcionario->__set('telefone', $_POST['telefone']);
            $funcionario->__set('id_setor', $_POST['id_setor']);
            $funcionario->__set('id_horario', $_POST['id_horario']);
            $funcionario->cadastraFuncionario();
        }
        $this->view->setores = $funcionario->listaSetores();
        $this->view->horarios = $funcionario->listaHorarios();
        echo json_encode($funcionario->listaFuncionarios());
    }

    public function insereHorarioAtendimentos(){

    }

    public function listaFuncionarios(){
        $funcionario = Container::getModel('Usuario');
        $response['todos_funcionarios'] = $funcionario->listaFuncionarios();
        $response['medicos'] = $funcionario->listaMedicos();
        echo json_encode($response);
    }

    public function fazerUpload(){
        $formatos_permitidos = array('gif', 'jpg', 'jpeg', 'png');
        $extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION );
        if(in_array($extensao, $formatos_permitidos)){
            $pasta = "img/avatar/";
            $temporario = $_FILES['arquivo']['tmp_name'];
            $novo_nome = uniqid().".$extensao";
            if(move_uploaded_file($temporario, $pasta.$novo_nome)){
                $mensagem = "Upload Feito com sucesso";
            }else{
                $mensagem = "Erro! Não foi possível realizar o upload";  
            }
            echo $mensagem;
        }else{
            $mensagem = "Formato inválido";
        }
    }

    public function confirmacaoAgendamento(){
        $this->validaAutenticacao();
        $response['post'] = $_POST;
        $paciente = Container::getModel('Consulta');
        $paciente->__set('medico_id',$_POST['medico_id']);
        $paciente->__set('dia',$_POST['dia']);
        $contaPac = $paciente->contaAtendidos();
    if($_POST['paciente'] != '' && $_POST['medico_id'] != '' && $_POST['prontuario'] != '' && $_POST['sus'] != '' && $_POST['horario'] != '' && $_POST['dia'] != ''){    
        if($contaPac['dia'] < $_POST['atendimentos']){
            $response['mensagem'] = 'Gostaria de confirmar o agendamento?';
            $response['status'] = 0;
        }else{
            $response['mensagem'] = 'Numero de agendamentos dessa data superior ao permitido! Gostaria de inserir como Extra?';
            $response['status'] = 1;
        }
    }else{
        $response['mensagem'] = 'Não é possível realizar o agendamento, por favor preencha todos os campos';
        $response['status'] = 2;
    }
        echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function agendaPaciente(){
        $this->validaAutenticacao();
        $dados_salvos = json_decode($_POST['save_data']);
        
        $paciente = Container::getModel('Consulta');
        $medicos = Container::getModel('Usuario');
            $paciente->__set('paciente',$dados_salvos->paciente);
            $paciente->__set('medico_id',$dados_salvos->medico_id);
            $paciente->__set('prontuario',$dados_salvos->prontuario);
            $paciente->__set('sus',$dados_salvos->sus);
            $paciente->__set('horario',$dados_salvos->horario);
            $paciente->__set('dia',$dados_salvos->dia);
            $paciente->__set('agendado_por',$dados_salvos->agendado_por);
            $paciente->agendaPaciente($_POST['status']);
        $response['mensagem'] = 'Paciente agendado com sucesso';
        echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
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
            echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        if(isset($_GET['action']) && $_GET['action'] == 'atualizar'){
           // print_r($_POST);
            
            $usuario = Container::getModel('Usuario');
            $usuario->__set('nome',$_POST['nome']);
            $usuario->__set('email',$_POST['email']);
            $usuario->__set('telefone',$_POST['fone']);
            $usuario->__set('id_setor',$_POST['setor']);
            $usuario->__set('id_horario',$_POST['horario']);
            $usuario->atualizar($_POST['id']);
            $this->listaFuncionarios();
            
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
        echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function filtrarRelatorio(){
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
                if(isset($_POST['flexRadioDefault']) && $_POST['flexRadioDefault'] == 'atendimentos'){
                    $atendimentosPorDia[$med][] = $atendidos->contagemAtendimentosPorDia()['realizados'];
                }
                else if (isset($_POST['flexRadioDefault']) && $_POST['flexRadioDefault'] == 'extras'){
                    $atendimentosPorDia[$med][] = $atendidos->contagemExtrasPorDia()['extras'];
                }
                else if (isset($_POST['flexRadioDefault']) && $_POST['flexRadioDefault'] == 'agendamentos'){
                    $atendimentosPorDia[$med][] = $atendidos->contagemAgendamentosPorMedico()['atendidos'];
                }
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
        echo json_encode($responses, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
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