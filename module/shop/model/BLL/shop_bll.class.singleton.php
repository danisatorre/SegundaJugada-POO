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

        public function get_equipos_BLL(){
            // echo json_encode('hola get_equipos_BLL');
            // exit;
            return $this -> dao -> select_equipos($this -> db);
        } // get_equipos_BLL

    } // shop_bll

?>