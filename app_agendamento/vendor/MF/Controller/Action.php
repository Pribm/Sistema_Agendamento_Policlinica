<?php

    namespace MF\Controller;

    abstract class Action{

        protected $view;

        public function __construct(){
            $this->view = new \stdClass();
        }

        protected function render($view, $layout){
            $this->view->page = $view;

            if(file_exists('../App/Views/'.$layout.'.phtml') && $layout != ''){
                require_once '../App/Views/'.$layout.'.phtml';
            }else{
                $layout = 'layout';
                $this->content();
            }
        }

        protected function content(){

            $classAtual = get_class($this);
            $classAtual = str_replace('App\\Controllers\\','', $classAtual);
            $classAtual = str_replace('Controller', '', $classAtual);

            require_once '../App/Views/' .$classAtual. '/' . $this->view->page . '.phtml';
        }

        protected function validaAutenticacao(){
            session_start();
            $this->view->usuario = $_SESSION['nome'];
            if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
                header('Location: /?login=erro2');
            }
        }

        protected function range_limit($current, $total, $limit = 10, $start_at = 1)
        {
            $middle = ceil($limit / 2);
        
            $current = max($start_at, min($total, $current));
        
            $start = $current - $middle;
        
            $end = $middle + $current;
        
            if ($start <= $start_at) {
                $start = $start_at;
                $end = $limit;
        
            } elseif ($end >= $total) {
                $end = $total;
                $start = $total - $limit;
            }
        
            for ($i = $start; $i <= $end; $i++) yield $i;
        }
    }
?>