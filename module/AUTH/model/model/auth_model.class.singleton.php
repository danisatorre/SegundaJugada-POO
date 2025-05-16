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

        public function getDataUser($username){
            return $this -> bll -> get_data_user_BLL($username);
        }
    } // auth_model

?>