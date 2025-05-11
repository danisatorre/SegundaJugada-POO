<?php

    class shop_bll{

        private $dao;
        private $db;
        static $_instance;

        function __construct(){
            // echo json_encode('hola __construct shop_bll');
            // exit;
            $this -> dao = shop_dao::getInstance();
            $this -> db = db::getInstance();
        } // __construct

        public static function getInstance(){
            // echo json_encode('hola getInstance shop_bll');
            // exit;
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        } // getInstance

        public function get_all_BLL($offset, $limit){
            return $this -> dao -> select_all($this -> db, $offset, $limit);
        }

        public function get_filtrar_BLL($filtro, $offset, $limit){
            return $this -> dao -> select_filtrar($this -> db, $filtro, $offset, $limit);
        }

        public function get_equipos_BLL(){
            // echo json_encode('hola get_equipos_BLL');
            // exit;
            return $this -> dao -> select_equipos($this -> db);
        } // get_equipos_BLL

        public function get_count_productos_filtros_BLL($filtro){
            return $this -> dao -> select_count_productos_filtros($this -> db, $filtro);
        }

        public function get_count_buscador_BLL($ciudad, $tipo, $categoria){
            return $this -> dao -> select_count_buscador($this -> db, $ciudad, $tipo, $categoria);
        }

        public function get_count_productos_all_BLL(){
            return $this -> dao -> select_count_all($this -> db);
        }

        public function get_load_likes_user_BLL($username){
            return $this -> dao -> select_load_likes_user($this -> db, $username);
        }

        public function get_likes_BLL($id_producto, $username){
            return $this -> dao -> select_likes($this -> db, $id_producto, $username);
        }

        public function like_BLL($id_producto, $username){
            $this -> dao -> set_like_user($this -> db, $id_producto, $username);
        }

        public function sumar_like_BLL($id_producto){
            $this -> dao -> set_like_producto($this -> db, $id_producto);
        }

        public function dislike_BLL($id_producto, $username){
            $this -> dao -> set_dislike_user($this -> db, $id_producto, $username);
        }

        public function restar_like_BLL($id_producto){
            $this -> dao -> set_dislike_producto($this -> db, $id_producto);
        }

    } // shop_bll

?>