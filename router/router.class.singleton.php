<?php
    
    $path = $_SERVER['DOCUMENT_ROOT'] . '/SegundaJugada-POO';

    require ($path . "/autoload.php");

    ob_start();
    session_start();

    class router {
        private $uriModule;
        private $uriFunction;
        private $moduleName;
        static $_instance;
        
        // crear el constructor si no existe
        public static function getInstance() {
            // echo 'hola getInstance';
            // exit;
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
    
        function __construct() {   
            // echo 'hola __construct';
            // exit;
            if(isset($_GET['module'])){
                // echo $_GET['module'];
                // exit;
                $this -> uriModule = $_GET['module'];
            }else{
                $this -> uriModule = 'home';
            }
            if(isset($_GET['op'])){
                // echo $_GET['op'];
                // exit;
                $this -> uriFunction = ($_GET['op'] === "") ? 'view' : $_GET['op'];
            }else{
                $this -> uriFunction = 'view';
            }
        }
    
        function routingStart() {
            // echo 'hola routingstart';
            // exit;
            try {
                call_user_func(array($this -> loadModule(), $this -> loadFunction()));
            }catch(Exception $e) {
                common::load_error();
            }
        }
        
        private function loadModule() {
            // echo 'hola loadModule';
            // exit;
            $pathModulesXML = $_SERVER['DOCUMENT_ROOT'] . '/SegundaJugada-POO/resources/modules.xml';
            // echo $pathModulesXML;
            // exit;
            if (file_exists($pathModulesXML)) {
                // echo 'file exists $pathModulesXML';
                // exit;
                $modules = simplexml_load_file($pathModulesXML);
                // echo 'simplexml load file $pathModulesXML';
                // exit;
                foreach ($modules as $row) {
                    if (in_array($this -> uriModule, (Array) $row -> uri)) {
                        $path = MODULES_PATH . $row->name . '/controller/ctrl_' . (string) $row->name . '.class.singleton.php';
                        // echo $path;
                        // exit;
                        if (file_exists($path)) {
                            // echo 'file exists $path';
                            // exit;
                            require_once($path);
                            $controllerName = 'ctrl_' . (String) $row -> name;
                            $this -> moduleName = (String) $row -> name;
                            // echo $controllerName;
                            // exit;
                            //return new $controllerName;

                            return $controllerName::getInstance();
                        }
                    }
                }
            }
            throw new Exception('Modulo no encontrado.');
        }
        
        private function loadFunction() {
            // echo 'hola loadFunction';
            // exit;
            $path = MODULES_PATH . $this -> moduleName . '/resources/function.xml'; 
            // echo $path;
            // exit;
            if (file_exists($path)) {
                // echo 'file exists $path';
                // exit;
                $functions = simplexml_load_file($path);
                foreach ($functions as $row) {
                    if (in_array($this -> uriFunction, (Array) $row -> uri)) {
                        // echo (string) $row -> name;
                        // exit;
                        return (String) $row -> name;
                    }
                }
            }
            throw new Exception('Función no encontrada');
        }
    } // router
    
    router::getInstance() -> routingStart();