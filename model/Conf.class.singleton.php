<?php
    class Conf {
        private $_userdb;
        private $_pwddb;
        private $_hostdb;
        private $_db;
        private $_portdb;
        static $_instance;

        private function __construct() {
            // return 'hola __construct Conf';
            // echo json_encode('hola __construct Conf.class');
            // exit;
            $paramDB = parse_ini_file(UTILS."db.ini");
            // echo json_encode('hola __construct despues ini file Conf.class');
            // exit;
            $this->_userdb = $paramDB['DB_USER'];
            $this->_pwddb = $paramDB['DB_PWD'];
            $this->_hostdb = $paramDB['DB_HOST'];
            $this->_db = $paramDB['DB_DB'];
            $this->_portdb = $paramDB['DB_PORT'];
            
            // echo json_encode($paramDB);
            // echo json_encode($this->_db);
            // exit;
        }

        private function __clone() {

        }

        public static function getInstance() {
            // return 'hola getInstance Conf';
            // echo json_encode('hola getInstance Conf.class');
            // exit;
            if (!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function getUserDB() {
            $var = $this->_userdb;
            return $var;
        } // coger el usuario de la db

        public function getHostDB() {
            $var = $this->_hostdb;
            return $var;
        } // coger el host de la db

        public function getPwdDB() {
            $var = $this->_pwddb;
            return $var;
        } // coger la pwd de la db

        public function getDB() {
            $var = $this->_db;
            return $var;
        } // coger la base de datos

        public function getPortDB(){
            $var = $this->_portdb;
            return $var;
        } // coger el puerto de la db
    }
