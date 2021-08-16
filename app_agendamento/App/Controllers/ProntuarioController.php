<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use MF\Model\Container;
use MF\Controller\Action;


class ProntuarioController extends Action
{
    public function cadastraProntuario()
    {
        $this->validaAutenticacao();
        $prontuario = Container::getModel('Prontuario');
        /*if(isset($_GET['teste'])){
            $prontuario->inserirRegistrosTeste(2000);
        }*/
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
            $prontuario->__set('nascimento', $_POST['data_nascimento']);
            $prontuario->__set('aberto_por', $_SESSION['nome']);

            
            $prontuario->inserir();

            $prontuario->__set('id', $prontuario->getLastId()['id']);
            $pacienteInserido = $prontuario->getPaciente();

            $response = ['dados' => $pacienteInserido, 'status' => 'sucesso', 'mensagem' => 'Registro inserido com sucesso no banco de dados!'];

        } else {
            $response = ['dados' => '', 'status' => 'erro', 'mensagem' => 'Não foi possível cadastrar estr prontuário, por favor insira os campos requeridos!'];
            $prontuario->inserir();
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }


    public function pesquisaProntuario()
    {
        $this->validaAutenticacao();
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
        $ultimo_registro = $prontuario->getTotalRegistros()['total'];

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

    public function pdfContent(){
        $this->validaAutenticacao();
        $prontuario = Container::getModel('Prontuario');
        
        if(isset($_POST['paciente_id'])){
            $prontuario->__set('id', $_POST['paciente_id']);
            $paciente = $prontuario->getPaciente();
        }

        $html = '<style>
            *{font-family: sans-serif;}
        </style>
        <div style="line-height: 1rem; margin: 0px; font-size:.8rem; text-align: center;">Prontuário aberto dia '.$paciente['data_criacao'].' por '.$paciente['aberto_por'].'</div>
        <table style="font-family: sans-serif; width: 100%;">
        <thead style="border: solid black 1px; border-radius: 5px;">
            <tr>
                <th style="text-align: start">
                    <img src="./img/logo_sus.jpg" height=60 style="margin:25px;"/>
                </th>
                <th>
                    Secretaria de Estado de Saúde<br/>
                    Policlínica Cardoso Fontes<br/>
                    Referência em Pneumologia<br/>
                </th>
            </tr>
        </thead>
        </table>
        <p style="font-family: sans-serif;">Registro N° '.$paciente['prontuario'].'</p>
        <div style="width: 100%; text-align: center; font-family: sans-serif;border: solid black 1px; padding: .5rem; border-radius: 5px;">
            Assistência médica sanitária
        </div>


        <div style="border: solid black 1px; border-radius: 5px; padding: 10px; margin-top: 15px;">

            <div style="text-align: center; width: 100%; background-color: gray; color: white; padding: 10px; border-radius: 5px;">
                <b>Dados do Paciente</b>
            </div>

            <div style="width: 100%; margin-top: 15px; border-bottom: solid black 1px;">
                <span style="border-bottom: solid white 5px;"><b>Nome:</b></span> <span>'.$paciente['nome'].'</span> 
            </div>

            <div style="width: 100%; margin-top: 15px; border-bottom: solid black 1px;">
                <span style="border-bottom: solid white 5px;"><b>Nome do Pai:</b></span> <span>'.$paciente['pai'].'</span> 
            </div>

            <div style="width: 100%; margin-top: 15px; border-bottom: solid black 1px;">
                <span style="border-bottom: solid white 5px;"><b>Nome da Mãe:</b></span> <span>'.$paciente['mae'].'</span> 
            </div>

            <div style="width: 100%; margin-top: 15px; border-bottom: solid black 1px;">
                <span style="border-bottom: solid white 5px;"><b>Naturalidade:</b></span> <span>'.$paciente['naturalidade'].'</span> 
                <span style="border-bottom: solid white 5px;"><b>Sexo:</b></span> <span>'.$paciente['sexo'].'</span> 
            </div>

            <div style="width: 100%; margin-top: 15px; border-bottom: solid black 1px;">
                <span style="border-bottom: solid white 5px;"><b>Data de nascimento:</b></span> <span>'.$paciente['data_nascimento'].'</span> 
                <span style="border-bottom: solid white 5px;"><b>Idade:</b></span> <span>'.$paciente['idade'].' Anos</span> 
            </div>

            <div style="width: 100%; margin-top: 15px; border-bottom: solid black 1px;">
                <span style="border-bottom: solid white 5px;"><b>Telefone:</b></span> <span>'.$paciente['telefone'].'</span> 
                <span style="border-bottom: solid white 5px;"><b>Sus:</b></span> <span>'.$paciente['sus'].'</span> 
            </div>

            <div style="width: 100%; margin-top: 15px; border-bottom: solid black 1px;">
                <span style="border-bottom: solid white 5px;"><b>Estado Civil:</b></span> <span>'.$paciente['estado_civil'].'</span> 
                <span style="border-bottom: solid white 5px;"><b>Profissão:</b></span> <span>'.$paciente['profissao'].'</span> 
            </div>

            <div style="width: 100%; margin-top: 15px; border-bottom: solid black 1px;">
                <span style="border-bottom: solid white 5px;"><b>Endereço:</b></span> <span>'.$paciente['endereco'].', '.$paciente['numero'].' - '.$paciente['bairro'].' - '.$paciente['complemento'].' </span>
            </div>
        </div>

        <div style="border: solid black 1px; border-radius: 5px; padding: 10px; margin-top: 15px;">
            <div style="text-align: center; width: 100%; background-color: gray; color: white; padding: 10px; border-radius: 5px;">
            <b>História Clínica</b>
            </div>

            <p>Queixa principal:</p>
            <p>H. Doença Atual:</p>
            <p>Dor Torácica:</p>
            <span><b>Observações:</b></span><span>  '.$paciente['observacao'].'</span>
            <hr style="margin-top: 25px"/>
            <hr style="margin-top: 25px"/>
            <hr style="margin-top: 25px"/>
            <hr style="margin-top: 25px"/>
        </div>';

        return $html;
    }

    public function imprimeProntuario(){
        $this->validaAutenticacao();
        $domPdf = new Dompdf();

        $options = new Options();
        $options->setChroot(dirname(dirname(__DIR__)));
        $options->set('isRemoteEnabled', true);
        $domPdf = new Dompdf($options);
        $domPdf->loadHtml($this->pdfContent());
        $domPdf->render();
        header('Content-type: application/pdf');
        echo $domPdf->output();
        
        
        //$prontuario = Container::getModel('Prontuario');
        //
    }

}
