<?php
namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;

class AgendaController extends Action{


    public function create(){
        
    }

    public function read(){
        $this->validaAutenticacao();
        $agendamento = Container::getModel('Agenda');
        $pagina_atual = 1;
        $pagina_atual  = isset($_POST['page']) ? intval($_POST['page']) : $pagina_atual;
        $limit  = 16;
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
        
        $total_registros = $registros['count'];
        $agendamentos = $registros['agendamentos'];



        $limite_de_links = 20;

        $ultima_pagina  = ceil($total_registros / $limit);
        $ultimo_registro = $total_registros;

        
        $links[] =  "<button onclick='changePage(1)' class='page-link'>Primeira</button>";
        foreach ($this->range_limit($pagina_atual, $ultimo_registro, $limite_de_links) as $pagina) {
            if ($pagina <= $ultima_pagina) {
                $links[] = "
                <li class='page-item " .(($pagina_atual == $pagina) ? 'active' : ''). "' aria-current='page'>
                <a role='button' onclick='changePage($pagina)' class='page-link'>$pagina</a>
                </li>
                ";
            } 
        }
        $links[] =  "<button onclick='changePage($ultima_pagina)' class='page-link' id='ultima_pagina'>Ultima</button>";

        $response = ['agendamentos' => $agendamentos, 'links' => $links, 'total' => $total_registros];
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
            $agendamento->createTest(600);
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

    public function count(){
        $this->validaAutenticacao();
        $agendamento = Container::getModel('Agenda');
        $agendamento->__set('dia', $_GET['dia']);
        $agendamento->__set('medico_id', $_GET['medico_id']);
        echo json_encode($agendamento->count());
    }
}

?>