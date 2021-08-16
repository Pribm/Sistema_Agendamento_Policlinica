<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class SetorController extends Action{
    public function create(){
        $this->validaAutenticacao();
        $setor = Container::getModel('Setor');
        $setor->__set('setor', $_POST['setor']);
        $setor->create();
        echo json_encode(['sucesso' => 'Setor cadastrado com sucesso!']);
    }

    public function read(){
        $this->validaAutenticacao();
        $setor = Container::getModel('Setor');
        echo json_encode($setor->read());
    }

    public function update(){

    }

    public function delete(){
        $this->validaAutenticacao();
        if($_GET['action'] === 'delete'){
            $setor = Container::getModel('Setor');
            $setor->__set('id', $_GET['id']);
            $setor->delete();
            echo json_encode(['success' => 'setor deletado com sucesso!']);
        }
    }
} 
?>