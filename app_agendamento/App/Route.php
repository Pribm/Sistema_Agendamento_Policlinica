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

        $routes['cadastra_funcionario'] = array(
            'route' => '/funcionario_cadastrado',
            'controller' => 'AppController',
            'action' => 'cadastraFuncionario'
        );

        $routes['upload_foto'] = array(
            'route' => '/upload_foto',
            'controller' => 'AppController',
            'action' => 'fazerUpload'
        );

        $routes['lista_funcionarios'] = array(
            'route' => '/lista_funcionarios',
            'controller' => 'AppController',
            'action' => 'listaFuncionarios'
        );

        $routes['agenda_paciente'] = array(
            'route' => '/agendaPaciente',
            'controller' => 'AppController',
            'action' => 'agendaPaciente'
        );

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

        $routes['sair'] = array(
            'route' => '/sair',
            'controller' => 'AuthController',
            'action' => 'sair'
        );

      

        $this->setRoutes($routes);
    }

}

?>