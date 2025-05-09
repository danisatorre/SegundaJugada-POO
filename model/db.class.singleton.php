<?php
    class db {
        private $server;
        private $user;
        private $pwd;
        private $database;
        private $port;
        private $link;
        private $stmt;
        private $array;
        static $_instance;

        private function __construct() {
            // return 'hola __construct db';
            // echo json_encode('hola __construct db.class...');
            // exit;
            $this -> setConexion();
            $this -> conectar();
        }
        
        private function setConexion() {
            // return 'hola setConexion db';
            // echo json_encode('hola setConexion');
            // exit;
            require_once 'Conf.class.singleton.php'; 
            $conf = Conf::getInstance();
            // echo json_encode('hola setConexion -> getInstance Conf.class');
            // exit;
            
            $this->server = $conf -> getHostDB();
            // echo json_encode($this->server);
            // exit;
            $this->database = $conf -> getDB();
            // echo json_encode($this->database);
            // exit;
            $this->user = $conf -> getUserDB();
            // echo json_encode($this->user);
            // exit;
            $this->pwd = $conf -> getPwdDB();
            // echo json_encode($this->pwd);
            // exit;
            $this->port = $conf -> getPortDB();
            // echo json_encode($this->port);
            // exit;
            
            // echo json_encode($conf);
            // exit;
        }

        private function __clone() {

        }

        public static function getInstance() {
            // return 'hola getInstance db';
            // echo json_encode('hola getInstance db.class');
            // exit;
            if (!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        private function conectar() {
            // return 'hola conectar db';
            // echo json_encode('hola conectar db.class');
            // exit;
            // echo json_encode($this -> link = new mysqli($this -> server, $this -> user, $this -> pwd, $this -> database, $this -> port));
            // exit;
            $this -> link = new mysqli($this -> server, $this -> user, $this -> pwd, $this -> database, $this -> port);
            // echo json_encode($this -> link);
            // exit;
            // echo json_encode($this -> link -> select_db($this -> database));
            // exit;
            $this -> link -> select_db($this -> database);
        }

        public function ejecutar($sql) {
            // return 'hola ejecutar db.class';
            // return $sql;
            // echo json_encode('hola ejecutar db.class');
            // exit;
            // echo json_encode($this -> stmt = $this -> link -> query($sql));
            // exit;
            $this -> stmt = $this -> link -> query($sql);
            // echo json_encode($this->stmt);
            // exit;
            return $this->stmt;
        }
        
        public function listar($stmt) {
            // echo json_encode('hola listar db.class');
            // exit;
            // echo json_encode($this -> array = array());
            // exit;
            $this -> array = array();
            while ($row = $stmt -> fetch_array(MYSQLI_ASSOC)) {
                array_push($this -> array, $row);
            }
            // echo json_encode('hola listar despues while');
            // echo json_encode($this -> array);
            // exit;
            return $this -> array;
        }

    }
