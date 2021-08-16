<?php
namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;

class AgendaController extends Action{


    public function create(){
        $this->validaAutenticacao();
        $prontuario = Container::getModel('Prontuario');

        $prontuario->__set('nome', $_POST['paciente']);
        $prontuario->__set('sus', $_POST['sus']);
        $prontuario->__set('prontuario', $_POST['prontuario']);
        $prontuario->__set('nome_pai', '');
        $prontuario->__set('nome_mae', '');
        
        if($_POST['id'] === ''){
            $pagina_atual = 1;
            $pagina_atual  = isset($_POST['page']) ? intval($_POST['page']) : intval($pagina_atual);
            $limit  = 25;
            $paginationRange = 6;
            $offset = ($pagina_atual * $limit) - $limit;
            $prontuarios = $prontuario->pesquisarPorPagina($limit, $offset);

            if(!empty($prontuarios)){
                
                $total_registros = $prontuario-> getTotalRegistros()['total'];
                $ultima_pagina  = ceil($total_registros / $limit);
                $links[] =  "<button onclick='changePage(1)' class='page-link'>Primeira</button>";
            
                foreach ($this->range_limit($pagina_atual, $total_registros, $paginationRange) as $pagina) {
                    if ($pagina <= $ultima_pagina) {
                        $links[] = "<button onclick='changePage($pagina)' class='page-link'>$pagina</button>";
                    }
                }
                $links[] =  "<button onclick='changePage($ultima_pagina)' class='page-link' id='ultima_pagina'>Ultima</button>";

                echo json_encode(['mensagem' => 'Estes pacientes foram encontrados na base de dados, selecione um para o agendamento', 'pacientes' => $prontuarios, 'links' => $links]);
            }else{
                $this->cadastrarPaciente();
            }
        }else{
            $this->cadastrarPaciente();
        }
        
    }

    private function cadastrarPaciente(){
        $this->validaAutenticacao();
        $agenda = Container::getModel('Agenda');
        $agenda->__set('paciente', $_POST['paciente']);
        $agenda->__set('medico_id', $_POST['medico_id']);
        $agenda->__set('prontuario', $_POST['prontuario']);
        $agenda->__set('sus', $_POST['sus']);
        $agenda->__set('horario', $_POST['horario']);
        $agenda->__set('dia', $_POST['dia']);
        $agenda->__set('agendado_por', $_POST['agendado_por']);
        $agenda->__set('extra', $_POST['extra']);

        if($_POST['paciente'] === '' || $_POST['prontuario'] === ''){
            echo json_encode(['erro' => 'Por favor preencha o nome e/ou número de prontuário para poder realizar o agendamento']);
        }else{
            $agenda->create();
            echo json_encode(['sucesso' => 'Paciente cadastrado com sucesso na base de dados!']);
        }
    }

    public function read(){
        $this->validaAutenticacao();
        $agendamento = Container::getModel('Agenda');
        $pagina_atual = 1;
        $pagina_atual  = isset($_POST['page']) ? intval($_POST['page']) : intval($pagina_atual);
        $limit  = 25;
        $offset = ($pagina_atual * $limit) - $limit;

        $agendamento->__set('paciente', $_POST['paciente']);
        $agendamento->__set('prontuario', $_POST['prontuario']);
        $agendamento->__set('medico_id', $_POST['medico']);
        $agendamento->__set('horario_id', $_POST['horario']);
        $agendamento->__set('agendado_por', $_SESSION['id']);
        $agendamento->__set('dia', $_POST['dia']);
        $agendamento->__set('limit', $limit);
        $agendamento->__set('offset', $offset);

        $registros = $agendamento->read();
        $total_registros = $agendamento->count()['total'];

        $ultima_pagina  = ceil($total_registros / $limit);

        
        $links[] =  "<button onclick='changePage(1)' class='page-link'>Primeira</button>";
        
        foreach ($this->range_limit($pagina_atual, $total_registros, $limit) as $pagina) {
            if ($pagina <= $ultima_pagina) {
                $links[] = "<button onclick='changePage($pagina)' class='page-link'>$pagina</button>";
            }
            
        }
        $links[] =  "<button onclick='changePage($ultima_pagina)' class='page-link' id='ultima_pagina'>Ultima</button>";

        $response = ['agendamentos' => $registros, 'links' => $links, 'total' => $total_registros];
        echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function update(){
        $this->validaAutenticacao();
        $agendamento = Container::getModel('Agenda');
        if($_GET['action'] === 'atender'){
            $agendamento->__set('id', $_GET['id']);
            $agendamento->atender();
            echo json_encode(['mensagem' => 'Paciente Atendido']);
        }
        /*if($_GET['action'] === 'seed'){
            $agendamento->createTest(1200);
        }*/
    }

    public function delete(){
        $this->validaAutenticacao();
        $agendamento = Container::getModel('Agenda');
        if($_GET['action'] === 'delete'){
            $agendamento->__set('id', $_GET['id']);
            $agendamento->delete();
        }

        echo json_encode(['mensagem' => 'Agendamento Apagado com sucesso']);
    }

    public function countAgendamentos(){
        $this->validaAutenticacao();
        $agendamento = Container::getModel('Agenda');
        $agendamento->__set('dia', $_GET['dia']);
        $agendamento->__set('medico_id', $_GET['medico_id']);
        echo json_encode($agendamento->countAgendamentos());
    }
}

?>