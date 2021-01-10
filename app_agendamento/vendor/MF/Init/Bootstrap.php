<?php
    namespace MF\Init;

    abstract class Bootstrap {

        private $routes;

        abstract protected function initRoutes();

        public function __construct(){
            $this->initRoutes();
            $this->run($this->getUrl());
        }

        public function getRoutes(){
            return $this->routes;
        }
    
        public function setRoutes(array $routes){
            $this->routes = $routes;
        }

        
    //este método
    //1.instancia a classe do controlador
    //2.dispara a action dentro do controlador
    protected function run($url){

        foreach ($this->getRoutes() as $key => $route) {
            if($url == $route['route']){
                
          /*1.*/$class = "App\\Controllers\\".ucfirst($route['controller']);

                $controller = new $class;

                $action = $route['action'];

          /*2.*/$controller->$action();
            }
        }
    }

    protected function getUrl(){
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

}
?>