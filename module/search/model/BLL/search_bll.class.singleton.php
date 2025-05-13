<?php

    class search_bll{

        private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = search_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

        public function get_categorias_BLL(){
            return $this -> dao -> select_categorias($this -> db);
        }

        public function get_tipos_BLL(){
            return $this -> dao -> select_tipos($this -> db);
        }

        public function get_ciudad_tipo_BLL($completar, $tipo_producto){
            return $this -> dao -> select_ciudad_tipo($this -> db, $completar, $tipo_producto);
        }

        public function get_ciudad_tipo_categoria_BLL($completar, $tipo_producto, $categoria_producto){
            return $this -> dao -> select_ciudad_tipo_categoria($this -> db, $completar, $tipo_producto, $categoria_producto);
        }

        public function get_ciudad_categoria_BLL($completar, $categoria_producto){
            return $this -> dao -> select_ciudad_categoria($this -> db, $completar, $categoria_producto);
        }

        public function get_ciudad_BLL($completar){
            return $this -> dao -> select_ciudad($this -> db, $completar);
        }

    } // search_bll

?>