<?php

    class shop_model{

        private $bll;
        static $_instance;

        function __construct(){
            // echo json_encode('hola __construct shop_model');
            // exit;
            // echo json_encode(var_dump(class_exists('shop_bll')));
            // exit;
            $this -> bll = shop_bll::getInstance();
        } // __construct

        public static function getInstance(){
            // echo json_encode('hola getInstance shop_model');
            // exit;
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        } // getInstance

        public function pruebaPOST($params){
            // $parametro1 = $params[0];
            // $parametro2 = $params[1];
            // echo json_encode('hola pruebaPOST shop_model');
            // exit;
            // echo json_encode($parametro1);
            // exit;
            // echo json_encode($parametro2);
            // exit;
            echo json_encode($params);
            exit;
        } // prueba para manejar múltiples datos pasados por POST

        public function getEquipos(){
            // echo json_encode('hola getEquipos shop_model');
            // exit;
            return $this -> bll -> get_equipos_BLL();
        } // getEquipos

        public function getCountProductosFiltros($params){
            $filtro = $params[0];
        }

    } // shop_model

?>