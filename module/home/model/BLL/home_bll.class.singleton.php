<?php
	class home_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			//return 'hola getInstance bll';
			$this -> dao = home_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			//return 'hola getInstance bll';
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_marcas_BLL() {
			//return 'hola get_carrusel_BLL';
            // echo json_encode('hola get_marcas_BLL home_bll.class.singleton.php');
            // exit;
			return $this -> dao -> select_marcas($this -> db);
			//return $this -> dao -> select_data_carrusel();
		}

		public function carousel_principal_BLL(){
			return $this -> dao -> select_cphome($this -> db);
		}

		public function get_categorias_BLL() {
			return $this -> dao -> select_categoria($this -> db);
		}

		public function get_tipos_BLL() {
			return $this -> dao -> select_tipo($this -> db);
		}

		public function get_productos_BLL(){
			return $this -> dao -> select_productos($this -> db);
		}

		public function get_accesorios_BLL(){
			return $this -> dao -> select_accesorios($this -> db);
		}

		public function get_populares_BLL(){
			return $this -> dao -> select_populares($this -> db);
		}

		public function get_mostrating_BLL(){
			return $this -> dao -> select_most_rating($this -> db);
		}

		public function get_mostratingcategoria_BLL(){
			return $this -> dao -> select_most_rating_categoria($this -> db);
		}

		public function get_mostratingtipo_BLL(){
			return $this -> dao -> select_most_rating_tipo($this -> db);
		}
	}
?>