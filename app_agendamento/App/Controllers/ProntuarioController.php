<?php

namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;


class ProntuarioController extends Action
{

    public function cadastraProntuario()
    {
        $prontuario = Container::getModel('Prontuario');

        if (isset($_POST['nome']) && $_POST['nome'] != '' && isset($_POST['sus']) && $_POST['sus'] != '' && isset($_POST['prontuario']) && $_POST['prontuario'] != '') {

            $prontuario->__set('bairro',  $_POST['bairro']);
            $prontuario->__set('complemento', $_POST['complemento']);
            $prontuario->__set('endereco', $_POST['endereco']);
            $prontuario->__set('estado_civil', $_POST['estado_civil']);
            $prontuario->__set('telefone', $_POST['telefone']);
            $prontuario->__set('nome_mae', $_POST['nome_mae']);
            $prontuario->__set('naturalidade', $_POST['naturalidade']);
            $prontuario->__set('nome', $_POST['nome']);
            $prontuario->__set('numero', $_POST['numero']);
            $prontuario->__set('observacao', $_POST['obs']);
            $prontuario->__set('nome_pai', $_POST['nome_pai']);
            $prontuario->__set('profissao', $_POST['profissao']);
            $prontuario->__set('prontuario', $_POST['prontuario']);
            $prontuario->__set('sexo', $_POST['sexo']);
            $prontuario->__set('sus', $_POST['sus']);

            $response = ['dados' => $_POST, 'status' => 'sucesso', 'mensagem' => 'Registro inserido com sucesso no banco de dados!'];
            $prontuario->inserir();
        } else {
            $response = ['dados' => '', 'status' => 'erro', 'mensagem' => 'Não foi possível cadastrar estr prontuário, por favor insira os campos requeridos!'];
            $prontuario->inserir();
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }


    public function pesquisaProntuario()
    {
        $pagina_atual  = isset($_POST['pagina']) ? $_POST['pagina'] : 1;

        $limite_da_paginacao  = 5;
        $offset = ($pagina_atual * $limite_da_paginacao) - $limite_da_paginacao;

        $prontuario = Container::getModel('Prontuario');
        $prontuario->__set('nome', $_POST['nome']);
        $prontuario->__set('sus', $_POST['sus']);
        $prontuario->__set('prontuario', $_POST['prontuario']);
        $prontuario->__set('nome_pai', $_POST['nome_pai']);
        $prontuario->__set('nome_mae', $_POST['nome_mae']);

        $limite_de_links = 10;
        $ultima_pagina  = ceil($prontuario->getTotalRegistros()['total'] / $limite_da_paginacao);
        $ultimo_registro = ceil($prontuario->getTotalRegistros()['total']);

        $links[] =  "<button onclick='changePage(1)' class='page-link'>Primeira</button>";

        foreach ($this->range_limit($pagina_atual, $ultimo_registro, $limite_de_links) as $pagina) {
            if ($pagina <= $ultima_pagina) {
                $links[] = "<button onclick='changePage($pagina)' class='page-link'>$pagina</button>";
            }
            
        }
        
        $links[] =  "<button onclick='changePage($ultima_pagina)' class='page-link' id='ultima_pagina'>Ultima</button>";

        $response = [$prontuario->pesquisarPorPagina($limite_da_paginacao, $offset), 'links' => $links];
        echo json_encode($response);
    }

}
