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

        public function getSocialLoginGoogle($params){
            $uid = $params[0];
            $username = $params[1];
            $email = $params[2];
            $avatar = $params[3];
            return $this -> bll -> get_social_login_google_BLL($uid, $username, $email, $avatar);
        }

        public function getSocialLoginGithub($params){
            $uid = $params[0];
            $username = $params[1];
            $email = $params[2];
            $avatar = $params[3];
            return $this -> bll -> get_social_login_github_BLL($uid, $username, $email, $avatar);
        }

        public function getDataUser($username){
            return $this -> bll -> get_data_user_BLL($username);
        }

        public function getDataUserGoogle($username){
            return $this -> bll -> get_data_user_google_bll($username);
        }

        public function getDataUserGithub($username){
            // echo json_encode("hola getDataUserGithub " . $username);
            // exit;
            return $this -> bll -> get_data_user_github_bll($username);
        }

        public function getUserLog($username){
            // echo json_encode($username);
            // exit;
            return $this -> bll -> get_user_log_BLL($username);
        }

        public function getEmailLog($email){
            // echo json_encode('hols email log MODEL');
            // exit;
            return $this -> bll -> get_email_log_BLL($email);
        }

        public function insertLocalUser($params){
            $username = $params[0];
            $email = $params[1];
            $pwd = $params[2];
            $tlf = $params[3];
            return $this -> bll -> insert_local_user_BLL($username, $email, $pwd, $tlf);
        }

        public function checkGoogleEmail($email){
            return $this -> bll -> check_google_email_BLL($email);
        }

        public function checkGithubEmail($email){
            return $this -> bll -> check_github_email_BLL($email);
        }

        public function checkLocalEmail($email){
            return $this -> bll -> check_local_email_BLL($email);
        }

        public function checkUsername($username){
            return $this -> bll -> check_username_BLL($username);
        }

        public function welcomeEmail($params){
            $email = $params[0];
            $username = $params[1];
            $this -> bll -> welcome_email_BLL($email, $username);
        }

        public function getVerifyEmail($tokenEmail){
            return $this -> bll -> get_verify_email_BLL($tokenEmail);
        }

        public function sendEmailRecoverPwd($email){
            return $this -> bll -> send_email_recover_pwd_BLL($email);
        }

        public function getVerifyToken($params){
            $tokenEmail = $params[0];
            $pwd = $params[1];
            return $this -> bll -> get_verify_token_BLL($tokenEmail, $pwd);
        }

        public function getPrefijosPhone(){
            return $this -> bll -> get_prefijos_phone_BLL();
        }

        public function sendOTP($param){
            return $this -> bll -> send_OTP_BLL($param);
        }
    } // auth_model

?>