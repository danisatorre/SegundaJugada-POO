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

        public function insert_user_github($db, $uid, $username, $email, $avatar){
            // echo json_encode('hola inset_user_google');
            // exit;
            $sql = "INSERT INTO github_users (uid, username, email, tipo_usuario, avatar, token_email, activate)
                VALUES ('$uid', '$username', '$email', 'client', '$avatar', '', 1)";
            return $stmt = $db -> ejecutar($sql);
        }

        public function select_user_google($db, $username){
            $sql = "SELECT uid, username, email, tipo_usuario, avatar, token_email, activate
                FROM google_users 
                WHERE username = '$username'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_user_github($db, $email){
            $sql = "SELECT uid, username, email, tipo_usuario, avatar, token_email, activate
                FROM github_users 
                WHERE email = '$email'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_user_github_menu($db, $username){
            // echo json_encode('hola dao github user '. $username);
            // exit;
            $sql = "SELECT uid, username, email, tipo_usuario, avatar, token_email, activate
                FROM github_users 
                WHERE username = '$username'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_data_user($db, $username){
            // buscar usuarios locales
            $sql = "SELECT * FROM users WHERE username='$username'";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);

            // // buscar usuarios de google
            // $sql = "SELECT * FROM google_users WHERE username='$username'";
            // $stmt = $db->ejecutar($sql);
            // $result = $db->listar($stmt);
            // if (!empty($result)) {
            //     return $result;
            // }

            // // buscar usuarios de github
            // $sql = "SELECT * FROM github_users WHERE username='$username'";
            // $stmt = $db->ejecutar($sql);
            // $result = $db->listar($stmt);
            // if (!empty($result)) {
            //     return $result;
            // }
        }

        public function select_user_log($db, $username){
            // echo json_encode('Login DAO '. $username);
            // exit;
            $sql = "SELECT `username`, `pwd`, `email`, `tipo_usuario`, `avatar` FROM `users` WHERE username='$username'";
            $stmt = $db->ejecutar($sql);
            $result = $db->listar($stmt);
            if (empty($result)) {
                return "error_user";
            } else {
                return $result;
            }
            // echo json_encode('Login DAO despues de ejecutar la consulta');
            // exit;
        }

        public function select_email_log($db, $email){
            // echo json_encode('hola email log DAO '. $email);
            // exit;
            $sql = "SELECT `username`, `pwd`, `email`, `tipo_usuario`, `avatar` FROM `users` WHERE email='$email'";
            $stmt = $db->ejecutar($sql);
            $result = $db->listar($stmt);
            if (empty($result)) {
                return "error_email";
            } else {
                return $result;
            }
        }
    } // auth_dao

?>