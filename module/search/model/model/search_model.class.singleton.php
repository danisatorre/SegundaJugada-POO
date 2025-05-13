<?php

    class search_model{

        private $bll;
        static $_instance;

        function __construct() {
            $this -> bll = search_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function getCategorias(){
            //  echo json_encode('hola getCategorias search_model');
            //  exit;
            return $this -> bll -> get_categorias_BLL();
        }

        public function getTipos(){
            // echo json_encode('hola getTipos search_model');
            // exit;
            return $this -> bll -> get_tipos_BLL();
        }

        public function getCiudadTipo($params){
            $completar = $params[0];
            $tipo_producto = $params[1];
            return $this -> bll -> get_ciudad_tipo_BLL($completar, $tipo_producto);
        }

        public function getCiudadTipoCategoria($params){
            $completar = $params[0];
            $tipo_producto = $params[1];
            $categoria_producto = $params[2];
            return $this -> bll -> get_ciudad_tipo_categoria_BLL($completar, $tipo_producto, $categoria_producto);
        }

        public function getCiudadCategoria($params){
            $completar = $params[0];
            $categoria_producto = $params[1];
            return $this -> bll -> get_ciudad_categoria_BLL($completar, $categoria_producto);
        }

        public function getCiudad($completar){
            // echo json_encode('hola getCiudad search_model');
            // exit;
            return $this -> bll -> get_ciudad_BLL($completar);
        }

    } // search_model

?>