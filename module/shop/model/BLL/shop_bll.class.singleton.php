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

        public function get_load_likes_user_BLL($username, $provider){
            if($provider == "local"){
                return $this -> dao -> select_load_likes_user($this -> db, $username);
            }else if($provider == "google"){
                return $this -> dao -> select_load_likes_user_google($this -> db, $username);
            }else if($provider == "github"){
                return $this -> dao -> select_load_likes_user_github($this -> db, $username);
            }
        }

        public function get_likes_BLL($id_producto, $username, $provider){
            if($provider == "local"){
                return $this -> dao -> select_likes($this -> db, $id_producto, $username);
            }else if($provider == "google"){
                return $this -> dao -> select_likes_google($this -> db, $id_producto, $username);   
            }else if($provider == "github"){
                return $this -> dao -> select_likes_github($this -> db, $id_producto, $username);
            }
        }

        public function like_BLL($id_producto, $username, $provider){
            if($provider == "local"){
                $this -> dao -> set_like_user($this -> db, $id_producto, $username);
            }else if($provider == "google"){
                $this -> dao -> set_like_user_google($this -> db, $id_producto, $username);
            }else if($provider == "github"){
                $this -> dao -> set_like_user_github($this -> db, $id_producto, $username);
            }
        }

        public function sumar_like_BLL($id_producto){
            $this -> dao -> set_like_producto($this -> db, $id_producto);
        }

        public function dislike_BLL($id_producto, $username, $provider){
            if($provider == "local"){
                $this -> dao -> set_dislike_user($this -> db, $id_producto, $username);
            }else if($provider == "google"){
                $this -> dao -> set_dislike_user_google($this -> db, $id_producto, $username);
            }else if($provider == "github"){
                $this -> dao -> set_dislike_user_github($this -> db, $id_producto, $username);
            }
        }

        public function restar_like_BLL($id_producto){
            $this -> dao -> set_dislike_producto($this -> db, $id_producto);
        }

        public function get_categoria_buscador_BLL($categoria, $offset, $limit){
            return $this -> dao -> select_categoria_buscador($this -> db, $categoria, $offset, $limit);
        }

        public function get_tipo_buscador_BLL($tipo, $offset, $limit){
            return $this -> dao -> select_tipo_buscador($this -> db, $tipo, $offset, $limit);
        }

        public function get_ciudad_buscador_BLL($ciudad, $offset, $limit){
            return $this -> dao -> select_ciudad_buscador($this -> db, $ciudad, $offset, $limit);
        }

        public function get_categoria_tipo_buscador_BLL($categoria, $tipo, $offset, $limit){
            return $this -> dao -> select_categoria_tipo_buscador($this -> db, $categoria, $tipo, $offset, $limit);
        }

        public function get_tipo_ciudad_buscador_BLL($tipo, $ciudad, $offset, $limit){
            return $this -> dao -> select_tipo_ciudad_buscador($this -> db, $tipo, $ciudad, $offset, $limit);
        }

        public function get_categoria_ciudad_buscador_BLL($categoria, $ciudad, $offset, $limit){
            return $this -> dao -> select_categoria_ciudad_buscador($this -> db, $categoria, $ciudad, $offset, $limit);
        }

        public function get_all_buscador_BLL($categoria, $tipo, $ciudad, $offset, $limit){
            return $this -> dao -> select_get_all_buscador($this -> db, $categoria, $tipo, $ciudad, $offset, $limit);
        }

        public function get_details_BLL($id_producto){
            return $this -> dao -> select_details($this -> db, $id_producto);
        }

        public function get_img_details_BLL($id_producto){
            return $this -> dao -> select_img_details($this -> db, $id_producto);
        }

        public function get_count_productos_relacionados_BLL($tipo, $id_producto){
            return $this -> dao -> select_count_productos_relacionados($this -> db, $tipo, $id_producto);
        }

        public function get_productos_relacionados_BLL($tipo, $loaded, $items, $id_producto){
            return $this -> dao -> select_productos_relacionados($this -> db, $tipo, $loaded, $items, $id_producto);
        }

        public function sumar_visitas_BLL($id_producto){
            $this -> dao -> sumar_visitas($this -> db, $id_producto);
        }

        public function update_rating_BLL($id_producto, $rating){
            $this -> dao -> update_rating($this -> db, $id_producto, $rating);
        }

        public function update_visitas_categoria_BLL($id_categoria){
            $this -> dao -> update_visitas_categoria($this -> db, $id_categoria);
        }

        public function update_visitas_tipo_BLL($id_tipo){
            $this -> dao -> update_visitas_tipo($this -> db, $id_tipo);
        }

        public function get_filtro_home_BLL($filtro_home){
            return $this -> dao -> filtro_home($this -> db, $filtro_home);
        }
        
        public function get_comentarios_BLL($id_producto){
            return $this -> dao -> select_comentarios($this -> db, $id_producto);
        }

        public function send_comentario_BLL($id_producto, $userID, $provider, $comentario){
            if($provider == "local"){
                $this -> dao -> insert_comentario_local($this -> db, $id_producto, $userID, $comentario);
            }else if($provider == "google"){
                $this -> dao -> insert_comentario_google($this -> db, $id_producto, $userID, $comentario);
            }else if($provider == "github"){
                $this -> dao -> insert_comentario_github($this -> db, $id_producto, $userID, $comentario);
            }
        }

    } // shop_bll

?>