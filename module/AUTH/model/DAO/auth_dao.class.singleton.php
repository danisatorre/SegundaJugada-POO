<?php

    class auth_dao{
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function insert_user_google($db, $uid, $username, $email, $avatar){
            // echo json_encode('hola inset_user_google');
            // exit;
            $sql = "INSERT INTO google_users (uid, username, email, tipo_usuario, avatar, token_email, activate)
                VALUES ('$uid', '$username', '$email', 'client', '$avatar', '', 1)";
            return $stmt = $db -> ejecutar($sql);
        }

        public function select_user_google($db, $username, $email){
            $sql = "SELECT uid, username, email, tipo_usuario, avatar, token_email, activate
                FROM google_users 
                WHERE username = '$username' OR email = '$email'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_data_user($db, $username){
            // buscar usuarios locales
            $sql = "SELECT * FROM users WHERE username='$username'";
            $stmt = $db->ejecutar($sql);
            $result = $db->listar($stmt);
            if (!empty($result)) {
                return $result;
            }

            // buscar usuarios de google
            $sql = "SELECT * FROM google_users WHERE username='$username'";
            $stmt = $db->ejecutar($sql);
            $result = $db->listar($stmt);
            if (!empty($result)) {
                return $result;
            }

            // buscar usuarios de github
            $sql = "SELECT * FROM github_users WHERE username='$username'";
            $stmt = $db->ejecutar($sql);
            $result = $db->listar($stmt);
            if (!empty($result)) {
                return $result;
            }
        }
    } // auth_dao

?>