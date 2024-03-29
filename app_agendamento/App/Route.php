<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap{

    protected function initRoutes(){

    /*----------Rotas de navegação------------*/

        $routes['nav_Home'] = array(
            'route' => '/',
            'controller' => 'IndexController',
            //as actions são os métodos contidos dentro da classe dos controladores.
            'action' => 'index'
        );

        $routes['nav_cadastra_prontuario'] = array(
            'route' => '/nav_cadastrar_prontuario',
            'controller' => 'AppController',
            'action' => 'navCadastrarProntuario'
        );

        $routes['nav_pesquisa_prontuario'] = array(
            'route' => '/pesquisar_prontuario',
            'controller' => 'AppController',
            'action' => 'navPesquisarProntuario'
        );

        $routes['nav_agenda_paciente'] = array(
            'route' => '/agenda_paciente',
            'controller' => 'AppController',
            'action' => 'navAgendaPaciente'
        );

        $routes['nav_agenda_dia'] = array(
            'route' => '/agenda_dia',
            'controller' => 'AppController',
            'action' => 'navAgendaDia'
        );

        $routes['nav_relatorio'] = array(
            'route' => '/relatorio_atendidos',
            'controller' => 'AppController',
            'action' => 'navRelatorio_atendidos'
        );

        $routes['nav_cadastra_funcionario'] = array(
            'route' => '/cadastra_funcionario',
            'controller' => 'AppController',
            'action' => 'navCadastraFuncionario'
        );

        /*----------fim das rotas de navegação------------*/
        $routes['autenticar'] = array(
            'route' => '/autenticar',
            'controller' => 'AuthController',
            'action' => 'autenticar'
        );

        $routes['prontuario_cadastrado'] = array(
            'route' => '/cadastrar_prontuario',
            'controller' => 'ProntuarioController',
            'action' => 'cadastraProntuario'
        );

        $routes['realizar_pesquisa_prontuario'] = array(
            'route' => '/realizar_pesquisa_prontuario',
            'controller' => 'ProntuarioController',
            'action' => 'pesquisaProntuario'
        );

        $routes['cadastra_funcionario'] = array(
            'route' => '/cadastrar_funcionario',
            'controller' => 'FuncionarioController',
            'action' => 'create'
        );

        $routes['lista_funcionarios'] = array(
            'route' => '/lista_funcionarios',
            'controller' => 'FuncionarioController',
            'action' => 'read'
        );

        $routes['lista_medicos'] = array(
            'route' => '/lista_medicos',
            'controller' => 'MedicoController',
            'action' => 'read'
        );

        //AGENDA CONTROLLER --------------------|
        $routes['agendar_paciente'] = array(
            'route' => '/agendar_paciente',
            'controller' => 'AgendaController',
            'action' => 'create'
        );

        $routes['filtra_agenda'] = array(
            'route' => '/filtra_agenda',
            'controller' => 'AgendaController',
            'action' => 'read'
        );

        $routes['agenda_pagination'] = array(
            'route' => '/agenda_pagination',
            'controller' => 'AgendaController',
            'action' => 'pagination'
        );

        $routes['atende_paciente'] = array(
            'route' => '/atender_paciente',
            'controller' => 'AgendaController',
            'action' => 'update'
        );

        $routes['cancela_agendamento'] = array(
            'route' => '/cancelar_agendamento',
            'controller' => 'AgendaController',
            'action' => 'delete'
        );

        $routes['conta_agendamentos'] = array(
            'route' => '/contar_agendamentos',
            'controller' => 'AgendaController',
            'action' => 'countAgendamentos'
        );
        //FIM AGENDA CONTROLLER --------------

        /*$routes['confirma_agendamento'] = array(
            'route' => '/confirma_agendamento',
            'controller' => 'AppController',
            'action' => 'confirmacaoAgendamento'
        );

        $routes['agenda_paciente'] = array(
            'route' => '/agendaPaciente',
            'controller' => 'AppController',
            'action' => 'agendaPaciente'
        );*/

        //----Horarios controller----------------//

        $routes['create_horario'] = array(
            'route' => '/cadastra_horario',
            'controller' => 'HorariosController',
            'action' => 'create'
        );

        $routes['get_horario'] = array(
            'route' => '/get_horarios',
            'controller' => 'HorariosController',
            'action' => 'read'
        );

        $routes['delete_horario'] = array(
            'route' => '/delete_horario',
            'controller' => 'HorariosController',
            'action' => 'delete'
        );


        //----Fim horario controller------------//


        //----Horarios controller----------------//

        $routes['create_setor'] = array(
            'route' => '/cadastra_setor',
            'controller' => 'SetorController',
            'action' => 'create'
        );

        $routes['get_setor'] = array(
            'route' => '/get_setores',
            'controller' => 'SetorController',
            'action' => 'read'
        );

        $routes['delete_setor'] = array(
            'route' => '/delete_setor',
            'controller' => 'SetorController',
            'action' => 'delete'
        );


        //----Fim horario controller------------//

        $routes['acao'] = array(
            'route' => '/acao',
            'controller' => 'AppController',
            'action' => 'acao'
        );

        $routes['filtra_agendamento'] = array(
            'route' => '/filtra_agendamento',
            'controller' => 'AppController',
            'action' => 'filtraAgendamento'
        );

        $routes['filtro_relatorio'] = array(
            'route' => '/filtra_relatorio',
            'controller' => 'AppController',
            'action' => 'filtrarRelatorio'
        );

        $routes['imprimir_prontuario'] = array(
            'route' => '/imprimir_prontuario',
            'controller' => 'ProntuarioController',
            'action' => 'imprimeProntuario'
        );

        $routes['sair'] = array(
            'route' => '/sair',
            'controller' => 'AuthController',
            'action' => 'sair'
        );

      

        $this->setRoutes($routes);
    }

}

?>