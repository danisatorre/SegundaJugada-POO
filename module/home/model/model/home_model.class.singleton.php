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

        public function carousel_principal(){
            return $this -> bll -> carousel_principal_BLL();
        }

        public function getCategorias() {
            return $this -> bll -> get_categorias_BLL();
        }

        public function getTipos() {
            // return 'hola car type';
            return $this -> bll -> get_tipos_BLL();
        }

        public function getProductos(){
            return $this -> bll -> get_productos_BLL();
        }

        public function getAccesorios(){
            return $this -> bll -> get_accesorios_BLL();
        }

        public function getPopulares(){
            return $this -> bll -> get_populares_BLL();
        }

        public function getMostRating(){
            return $this -> bll -> get_mostrating_BLL();
        }

        public function getMostRatingCategoria(){
            return $this -> bll -> get_mostratingcategoria_BLL();
        }

        public function getMostRatingTipo(){
            return $this -> bll -> get_mostratingtipo_BLL();
        }

    }
?>