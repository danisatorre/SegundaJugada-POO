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

        public function select_cphome($db){
            $sql= "SELECT * FROM carousel_home ORDER BY id_cphome ASC";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_categoria($db) {

            $sql= "SELECT * FROM categorias ORDER BY id_categoria ASC";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_tipo($db) {

            $sql= "SELECT * FROM tipo ORDER BY id_tipo DESC";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_productos($db){
            $sql= "SELECT * FROM productos ORDER BY id_producto DESC LIMIT 6";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_accesorios($db){
            $sql= "SELECT * FROM productos WHERE tipo = 8 ORDER BY nom_prod LIMIT 10";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_populares($db){
            $sql= "SELECT * FROM productos ORDER BY visitas DESC LIMIT 10";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_most_rating($db){
            $sql= "SELECT * FROM productos ORDER BY rating DESC LIMIT 20";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_most_rating_categoria($db){
            $sql= "SELECT * FROM categorias ORDER BY visitas_cat DESC";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_most_rating_tipo($db){
            $sql= "SELECT * FROM tipo ORDER BY visitas_tipo DESC";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

    }
?>