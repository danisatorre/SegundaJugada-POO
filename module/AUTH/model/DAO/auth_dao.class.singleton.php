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
            $sql = "SELECT `username`, `pwd`, `email`, `tipo_usuario`, `avatar`, `token_email`, `activate` FROM `users` WHERE username='$username'";
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
            $sql = "SELECT `username`, `pwd`, `email`, `tipo_usuario`, `avatar`, `token_email`, `activate` FROM `users` WHERE email='$email'";
            $stmt = $db->ejecutar($sql);
            $result = $db->listar($stmt);
            if (empty($result)) {
                return "error_email";
            } else {
                return $result;
            }
        }

        public function insert_local_user($db, $username, $email, $pwd, $tokenEmail, $tlf){
            $hashpwd = password_hash($pwd, PASSWORD_DEFAULT, ['cost' => 12]); // encriptar la contraseña
            $hashemail = md5(strtolower(trim($email)));
            $avatar = "https://i.pravatar.cc/500?u=$hashemail";
            $sql ="   INSERT INTO `users`(`username`, `pwd`, `email`, `tipo_usuario`, `avatar`, `telf`, `token_email`, `activate`)
            VALUES ('$username','$hashpwd','$email','client','$avatar','$tlf','$tokenEmail', 0)";
            return $stmt = $db->ejecutar($sql);
        }

        // revisar que no exista una cuenta de google con el mismo email al registrarse
        public function check_google_email($db, $email){
            $sql = "SELECT uid, username, email, tipo_usuario, avatar, token_email, activate
                FROM google_users 
                WHERE email = '$email'";

            $stmt = $db->ejecutar($sql);
            $result = $db->listar($stmt);
            if (empty($result)) {
                return 1;
            } else {
                return "error_email_google";
            }
        }

        // revisar que no exista una cuenta de github con el mismo email al registrarse
        public function check_github_email($db, $email){
            $sql = "SELECT uid, username, email, tipo_usuario, avatar, token_email, activate
                FROM github_users 
                WHERE email = '$email'";

            $stmt = $db->ejecutar($sql);
            $result = $db->listar($stmt);
            if (empty($result)) {
                return 1;
            } else {
                return "error_email_github";
            }
        }

        public function check_local_email($db, $email){
            $sql = "SELECT `username`, `pwd`, `email`, `tipo_usuario`, `avatar` FROM `users` WHERE email='$email'";
            $stmt = $db->ejecutar($sql);
            $result = $db->listar($stmt);
            if(empty($result)){
                return 1;
            }else{
                return "error_email";
            }
        }

        public function check_username($db, $username){
            $sql = "SELECT `username`, `pwd`, `email`, `tipo_usuario`, `avatar` FROM `users` WHERE username='$username'";
            $stmt = $db->ejecutar($sql);
            $result = $db->listar($stmt);
            if (empty($result)) {
                return 1;
            } else {
                return "error_username";
            }
        }

        public function select_verify_email_token($db, $tokenEmail, $user){
            $sql = "SELECT token_email
                    FROM users 
                    WHERE (username = '$user' OR email = '$user')
                    AND token_email = '$tokenEmail'";

            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function update_verify_email($db, $tokenEmail){
            $sql = "UPDATE users 
                    SET activate = 1, token_email= ''
                    WHERE token_email = '$tokenEmail'";

            $stmt = $db->ejecutar($sql);
            return "updated";
        }

        public function insert_token_recover_pwd($db, $email, $tokenEmail){
            $sql = "UPDATE users
                    SET activate = 0, token_email = '$tokenEmail'
                    WHERE email = '$email'";

            $stmt = $db->ejecutar($sql);
            return 'ok';
        }

        public function update_pwd($db, $tokenEmail, $pwd, $email){
            $hashpwd = password_hash($pwd, PASSWORD_DEFAULT, ['cost' => 12]);

            $sql = "UPDATE users
                    SET activate = 1, token_email = '', pwd = '$hashpwd'
                    WHERE email = '$email'
                    AND token_email = '$tokenEmail'";

            return $stmt = $db->ejecutar($sql);
        }

        public function token_register_expires($db, $tokenEmail){
            $sql = "DELETE
                    FROM users
                    WHERE token_email = '$tokenEmail'";

            $stmt = $db->ejecutar($sql);
            return 1;
        }

        public function select_prefijos_phone($db){
            $sql ="SELECT * FROM country";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function check_username_or_email_local($db, $param){
            $sql = "SELECT *
                    FROM users
                    WHERE username = '$param'
                    OR email = '$param'";

            $stmt = $db -> ejecutar($sql);
            $result = $db->listar($stmt);
            if (empty($result)) {
                return 0;
            } else {
                return 1;
            }
        }

        public function select_log_intents($db, $param){
            $sql = "SELECT log_intents
                    FROM users
                    WHERE username = '$param'
                    OR email = '$param'";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function update_log_intents($db, $param){
            $sql = "UPDATE users
                    SET log_intents = log_intents + 1
                    WHERE username = '$param'
                    OR email = '$param'";
            
            $stmt = $db -> ejecutar($sql);
        }

        public function select_username_or_email_local($db, $param){
            $sql = "SELECT *
                    FROM users
                    WHERE (username = '$param' OR email = '$param')";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function set_otp_db($db, $param, $otp){
            $sql = "UPDATE users
                    SET otp = '$otp'
                    WHERE username = '$param'
                    OR email = '$param'";
            
            $stmt = $db -> ejecutar($sql);
        }

        public function verify_OTP($db, $user, $otp){
            $sql = "SELECT *
                    FROM users
                    WHERE (username = '$user' OR email = '$user')
                    AND otp = '$otp'";
            
            $stmt = $db -> ejecutar($sql);
            $result = $db->listar($stmt);
            if (empty($result)) {
                return 0;
            } else {
                return 1;
            }
        }

        public function disable_OTP_db($db, $username){
            $sql = "UPDATE users
                    SET otp = '', log_intents = 0
                    WHERE username = '$username'";

            $stmt = $db -> ejecutar($sql);
        }

        public function updateUsernameGoogle_DB($db, $oldUsername, $newUsername){
            $sql = "UPDATE google_users
                    SET username = '$newUsername'
                    WHERE username = '$oldUsername'";
            
            $stmt = $db -> ejecutar($sql);
        }

        public function updateUsernameGitHub_DB($db, $oldUsername, $newUsername){
            $sql = "UPDATE github_users
                    SET username = '$newUsername'
                    WHERE username = '$oldUsername'";
            
            $stmt = $db -> ejecutar($sql);
        }

        public function updateUsernameLocal_DB($db, $oldUsername, $newUsername){
            $sql = "UPDATE users
                    SET username = '$newUsername'
                    WHERE username = '$oldUsername'";
            
            $stmt = $db -> ejecutar($sql);
        }
    } // auth_dao

?>