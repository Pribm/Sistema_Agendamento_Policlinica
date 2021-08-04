<?php
namespace App\Controllers;

//recursos do miniFramework
use MF\Model\Container;
use MF\Controller\Action;


    class IndexController extends Action{
        //estes métodos representam as action dos controladores
        public function index(){
            $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
            $this->render('index', 'layout');
        }    
    }
?>