<?php

    class auth_bll{
        private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = auth_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_social_login_google_BLL($uid, $username, $email, $avatar){
			if (!empty($this -> dao -> select_user_google($this->db, $username, $email))) {
				$user = $this -> dao -> select_user_google($this->db, $username, $email);
				$token = middleware::create_token($user[0]['username']);
				return json_encode($token);
            } else {
				$this -> dao -> insert_user_google($this->db, $uid, $username, $email, $avatar);
				$user = $this -> dao -> select_user_google($this->db, $username, $email);
				$token = middleware::create_token($user[0]['username']);
				return json_encode($token);
			}
		}

		public function get_data_user_BLL($username){
			return $this -> dao -> select_data_user($this -> db, $username);
		}
    } // auth_bll

?>