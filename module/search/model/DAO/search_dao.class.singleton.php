<?php

    class search_dao{

        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        public function select_categorias($db){
            $sql="SELECT * FROM categorias";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_tipos($db){
            $sql="SELECT * FROM tipo";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_ciudad_tipo($db, $completar, $tipo_producto){
            $sql = "SELECT DISTINCT p.ciudad
                FROM productos p
                LEFT JOIN tipo t
                ON p.tipo = t.id_tipo
                WHERE t.id_tipo = '$tipo_producto'
                AND p.ciudad LIKE '$completar%'";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_ciudad_tipo_categoria($db, $completar, $tipo_producto, $categoria_producto){
            $sql = "SELECT DISTINCT p.ciudad
                    FROM productos p
                    LEFT JOIN tipo t ON p.tipo = t.id_tipo
                    LEFT JOIN categorias c ON p.categoria = c.id_categoria
                    WHERE t.id_tipo = '$tipo_producto'
                    AND c.id_categoria = '$categoria_producto'
                    AND p.ciudad LIKE '$completar%'";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_ciudad_categoria($db, $completar, $categoria_producto){
            $sql = "SELECT DISTINCT p.ciudad
                    FROM productos p
                    LEFT JOIN categorias c ON p.categoria = c.id_categoria
                    WHERE c.id_categoria = '$categoria_producto'
                    AND p.ciudad LIKE '$completar%'";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_ciudad($db, $completar){
            $sql = "SELECT DISTINCT p.ciudad
                    FROM productos p
                    WHERE p.ciudad LIKE '$completar%'";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

    } // search_dao

?>