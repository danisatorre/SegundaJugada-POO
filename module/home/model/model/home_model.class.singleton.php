<?php
    class home_model {

        private $bll;
        static $_instance;
        
        function __construct() {
            // return 'hola getInstance __construct home_model.class.singleton.php';
            // echo json_encode('hola __construct home_model.class.singleton.php');
            // exit;
            $this -> bll = home_bll::getInstance();
        }

        public static function getInstance() {
            // return 'hola getInstance home_model.class.singleton.php';
            // echo json_encode('hola getInstance home_model.class.singleton.php');
            // exit;
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function getMarcas() {
            //return 'hola get_carrusel';
            // echo json_encode('hola getMarcas home_model.class.singleton.php');
            // exit;
            return $this -> bll -> get_marcas_BLL();
        }

        public function get_category() {
            return $this -> bll -> get_category_BLL();
        }

        public function get_type() {
            // return 'hola car type';
            return $this -> bll -> get_type_BLL();
        }

    }
?>