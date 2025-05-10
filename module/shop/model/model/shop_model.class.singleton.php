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

        public function getEquipos(){
            // echo json_encode('hola getEquipos shop_model');
            // exit;
            return $this -> bll -> get_equipos_BLL();
        } // getEquipos

    } // shop_model

?>