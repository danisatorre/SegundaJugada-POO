<?php

    class shop_dao{
        
        static $_instance;

        private function __construct(){
            
        }

        public static function getInstance(){
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        } // getInstance

        public function select_equipos($db){
            $sql ="SELECT * FROM teams";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

    } // shop_dao

?>