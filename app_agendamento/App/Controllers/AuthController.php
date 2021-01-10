<?php
namespace App\Controllers;

use MF\Model\Container;
use MF\Controller\Action;

    class AuthController extends Action{

        public function autenticar(){
            
            $usuario = Container::getModel('Usuario'); //está instanciando a classe Usuario com o objeto usuário


            $usuario->__set('email', $_POST['email']);
            $usuario->__set('senha', md5($_POST['senha']));


            $usuario->autenticarUsuario();

            if($usuario->__get('nome') != '' && $usuario->__get('id') != ''){
                session_start();

                $_SESSION['id'] = $usuario->__get('id');
                $_SESSION['nome'] = $usuario->__get('nome');
                $_SESSION['setor'] = $usuario->__get('setor');

                //print_r($_SESSION);

                header('location: /agenda_paciente');
            }else{
                header('Location: /?login=erro');
            }
        }

        public function sair(){
            session_start();
            session_destroy();
            header('location: /');
        }
    }
?>