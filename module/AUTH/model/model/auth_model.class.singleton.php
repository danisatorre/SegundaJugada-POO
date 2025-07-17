<?php

    class auth_model{
        private $bll;
        static $_instance;
        
        function __construct() {
            $this -> bll = auth_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function getSocialLoginGoogle($params){ // iniciar sesión con un usuario de google
            $uid = $params[0];
            $username = $params[1];
            $email = $params[2];
            $avatar = $params[3];
            return $this -> bll -> get_social_login_google_BLL($uid, $username, $email, $avatar);
        }

        public function getSocialLoginGithub($params){ // iniciar sesión con un usuario de github
            $uid = $params[0];
            $username = $params[1];
            $email = $params[2];
            $avatar = $params[3];
            return $this -> bll -> get_social_login_github_BLL($uid, $username, $email, $avatar);
        }

        public function getDataUser($username){ // coger los datos de un usuario local
            return $this -> bll -> get_data_user_BLL($username);
        }

        public function getDataUserGoogle($username){ // coger los datos de un usuario de google
            return $this -> bll -> get_data_user_google_bll($username);
        }

        public function getDataUserGithub($username){ // coger los datos de un usuario de github
            // echo json_encode("hola getDataUserGithub " . $username);
            // exit;
            return $this -> bll -> get_data_user_github_bll($username);
        }

        public function getUserLog($username){ // coger los datos de un usuario local por username al iniciar sesión
            // echo json_encode($username);
            // exit;
            return $this -> bll -> get_user_log_BLL($username);
        }

        public function getEmailLog($email){ // coger los datos de un usuario local por email al iniciar sesión
            // echo json_encode('hols email log MODEL');
            // exit;
            return $this -> bll -> get_email_log_BLL($email);
        }

        public function insertLocalUser($params){ // registrar un nuevo usuario local
            $username = $params[0];
            $email = $params[1];
            $pwd = $params[2];
            $tlf = $params[3];
            return $this -> bll -> insert_local_user_BLL($username, $email, $pwd, $tlf);
        }

        public function checkGoogleEmail($email){ // verificar si existe un usuario de google con el mismo email
            return $this -> bll -> check_google_email_BLL($email);
        }

        public function checkGithubEmail($email){ // verificar si existe un usuario de github con el mismo email
            return $this -> bll -> check_github_email_BLL($email);
        }

        public function checkLocalEmail($email){ // verificar si existe un usuario local con el mismo email
            return $this -> bll -> check_local_email_BLL($email);
        }

        public function checkUsername($username){ // verificar si existe un usuario local con el mismo username
            return $this -> bll -> check_username_BLL($username);
        }

        public function welcomeEmail($params){ // enviar un correo de bienvenida
            $email = $params[0];
            $username = $params[1];
            $this -> bll -> welcome_email_BLL($email, $username);
        }

        public function getVerifyEmail($tokenEmail){ // validar el email para un usuario que se acaba de registrar
            return $this -> bll -> get_verify_email_BLL($tokenEmail);
        }

        public function sendEmailRecoverPwd($email){ // enviar email para restablecer la contraseña
            return $this -> bll -> send_email_recover_pwd_BLL($email);
        }

        public function getVerifyToken($params){ // verificar el token al restablecer la contraseña
            $tokenEmail = $params[0];
            $pwd = $params[1];
            return $this -> bll -> get_verify_token_BLL($tokenEmail, $pwd);
        }

        public function getPrefijosPhone(){ // coger los prefijos de nº de tlf de la tabla country
            return $this -> bll -> get_prefijos_phone_BLL();
        }

        public function sendOTP($param){ // enviar el código OTP
            return $this -> bll -> send_OTP_BLL($param);
        }

        public function verifyOTP($params){ // verificar si el código OTP es correcto
            $user = $params[0];
            $otp = $params[1];
            return $this -> bll -> verify_OTP_BLL($user, $otp);
        }

        public function iniciarSesionOTP($user){ // iniciar sesión mediante el código OTP
            return $this -> bll -> iniciar_sesion_OTP_BLL($user);
        }

        public function disableOTPDb($username){ // eliminar el código OTP de la tabla users al iniciar sesión
            $this -> bll -> disable_OTP_db_BLL($username);
        }

        public function updateUsernameGoogle($params){
            $oldUsername = $params[0];
            $newUsername = $params[1];
            return $this -> bll -> updateUsernameGoogle_BLL($oldUsername, $newUsername);
        }

        public function updateUsernameGitHub($params){
            $oldUsername = $params[0];
            $newUsername = $params[1];
            return $this -> bll -> updateUsernameGitHub_BLL($oldUsername, $newUsername);
        }

        public function updateUsernameLocal($params){
            // echo json_encode('hola updateUsernameLocal MODEL');
            // exit;
            $oldUsername = $params[0];
            $newUsername = $params[1];
            return $this -> bll -> updateUsernameLocal_BLL($oldUsername, $newUsername);
        }
    } // auth_model

?>