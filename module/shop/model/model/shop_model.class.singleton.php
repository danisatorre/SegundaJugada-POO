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

        public function pruebaPOST($params){
            // $parametro1 = $params[0];
            // $parametro2 = $params[1];
            // echo json_encode('hola pruebaPOST shop_model');
            // exit;
            // echo json_encode($parametro1);
            // exit;
            // echo json_encode($parametro2);
            // exit;
            echo json_encode($params);
            exit;
        } // prueba para manejar múltiples datos pasados por POST

        public function getAll($params){
            $offset = $params[0];
            $limit = $params[1];

            return $this -> bll -> get_all_BLL($offset, $limit);
        }

        public function getFiltrar($params){
            $filtro = $params[0];
            $offset = $params[1];
            $limit = $params[2];

            return $this -> bll -> get_filtrar_BLL($filtro, $offset, $limit);
        }

        public function getEquipos(){
            // echo json_encode('hola getEquipos shop_model');
            // exit;
            return $this -> bll -> get_equipos_BLL();
        } // getEquipos

        public function getCountProductosFiltros($filtro){
            return $this -> bll -> get_count_productos_filtros_BLL($filtro);
        }

        public function getCountBuscador($params){
            $ciudad = $params[0];
            $tipo = $params[1];
            $categoria = $params[2];
            return $this -> bll -> get_count_buscador_BLL($ciudad, $tipo, $categoria);
        }

        public function getCountProductosAll(){
            return $this -> bll -> get_count_productos_all_BLL();
        }

        public function getLoadLikesUser($username){
            return $this -> bll -> get_load_likes_user_BLL($username);
        }

        public function getLikes($params){
            $id_producto = $params[0];
            $username = $params[1];
            return $this -> bll -> get_likes_BLL($id_producto, $username);
        }

        public function like($params){
            $id_producto = $params[0];
            $username = $params[1];
            $this -> bll -> like_BLL($id_producto, $username);
        }

        public function sumar_like($id_producto){
            $this -> bll -> sumar_like_BLL($id_producto);
        }

        public function dislike($params){
            $id_producto = $params[0];
            $username = $params[1];
            $this -> bll -> dislike_BLL($id_producto, $username);
        }

        public function restar_like($id_producto){
            $this -> bll -> restar_like_BLL($id_producto);
        }

        public function getCategoriaBuscador($params){
            $categoria = $params[0];
            $offset = $params[1];
            $limit = $params[2];

            return $this -> bll -> get_categoria_buscador_BLL($categoria, $offset, $limit);
        }

        public function getTipoBuscador($params){
            $tipo = $params[0];
            $offset = $params[1];
            $limit = $params[2];

            return $this -> bll -> get_tipo_buscador_BLL($tipo, $offset, $limit);
        }

        public function getCiudadBuscador($params){
            $ciudad = $params[0];
            $offset = $params[1];
            $limit = $params[2];

            return $this -> bll -> get_ciudad_buscador_BLL($ciudad, $offset, $limit);
        }

        public function getCategoriaTipoBuscador($params){
            $categoria = $params[0];
            $tipo = $params[1];
            $offset = $params[2];
            $limit = $params[3];

            return $this -> bll -> get_categoria_tipo_buscador_BLL($categoria, $tipo, $offset, $limit);
        }

        public function getTipoCiudadBuscador($params){
            $tipo = $params[0];
            $ciudad = $params[1];
            $offset = $params[2];
            $limit = $params[3];

            return $this -> bll -> get_tipo_ciudad_buscador_BLL($tipo, $ciudad, $offset, $limit);
        }

        public function getCategoriaCiudadBuscador($params){
            $categoria = $params[0];
            $ciudad = $params[1];
            $offset = $params[2];
            $limit = $params[3];

            return $this -> bll -> get_categoria_ciudad_buscador_BLL($categoria, $ciudad, $offset, $limit);
        }

        public function getAllBuscador($params){
            $categoria = $params[0];
            $tipo = $params[1];
            $ciudad = $params[2];
            $offset = $params[3];
            $limit = $params[4];
            return $this -> bll -> get_all_buscador_BLL($categoria, $tipo, $ciudad, $offset, $limit);
        }

        public function getDetails($id_producto){
            // echo json_encode($id_producto);
            // exit;
            return $this -> bll -> get_details_BLL($id_producto);
        }

        public function getImgDetails($id_producto){
            return $this -> bll -> get_img_details_BLL($id_producto);
        }

        public function getCountProductosRelacionados($params){
            $tipo = $params[0];
            $id_producto = $params[1];
            return $this -> bll -> get_count_productos_relacionados_BLL($tipo, $id_producto);
        }

        public function getProductosRelacionados($params){
            $tipo = $params[0];
            // echo json_encode($tipo);
            // exit;
            $loaded = $params[1];
            $items = $params[2];
            $id_producto = $params[3];
            return $this -> bll -> get_productos_relacionados_BLL($tipo, $loaded, $items, $id_producto);
        }

        public function sumarVisitas($id_producto){
            $this -> bll -> sumar_visitas_BLL($id_producto);
        }

        public function updateRating($params){
            $id_producto = $params[0];
            $rating = $params[1];
            $this -> bll -> update_rating_BLL($id_producto, $rating);
        }

        public function updateVisitasCategoria($id_categoria){
            $this -> bll -> update_visitas_categoria_BLL($id_categoria);
        }

        public function updateVisitasTipo($id_tipo){
            $this -> bll -> update_visitas_tipo_BLL($id_tipo);
        }

        public function getFiltroHome($filtro_home){
            return $this -> bll -> get_filtro_home_BLL($filtro_home);
        }

    } // shop_model

?>