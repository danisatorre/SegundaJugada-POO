<?php
    class home_dao {
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            // return 'hola getInstance dao home';
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function select_marcas($db) {
        // public function select_data_carrusel() {
            // return 'hola select_marcas home_dao.class...';
            // echo json_encode('hola select_marcas home_dao.class...');
            // echo json_encode($db);
            // exit;
            $sql = "SELECT * FROM marcas";
            // return $sql;
            $stmt = $db -> ejecutar($sql);
            // return $stmt;
            // echo json_encode($db -> listar($stmt));
            // exit;
            return $db -> listar($stmt);
        }

        public function select_data_category($db) {

            $sql = "SELECT * FROM category LIMIT 3";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_data_type($db) {

            $sql = "SELECT * FROM type LIMIT 4";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

    }
?>