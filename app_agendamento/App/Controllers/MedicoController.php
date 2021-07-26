<?php
namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;

class MedicoController extends Action {

    public function read(){
        $medicos = Container::getModel('Medico');
        $lista = $medicos->read();
        echo(json_encode($lista, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}

?>