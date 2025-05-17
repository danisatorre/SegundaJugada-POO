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
			if (!empty($this -> dao -> select_user_google($this->db, $username))) {
				$user = $this -> dao -> select_user_google($this->db, $username);
				// echo json_encode($user[0]['username']);
				// exit;
				$token = middleware::create_token($user[0]['username']);
				return $token;
            } else {
				$this -> dao -> insert_user_google($this->db, $uid, $username, $email, $avatar);
				// echo json_encode($username);
				// exit;
				$user = $this -> dao -> select_user_google($this->db, $username);
				// echo json_encode($user[0]['username']);
				// exit;
				$token = middleware::create_token($user[0]['username']);
				return $token;
			}
		}

		public function get_social_login_github_BLL($uid, $username, $email, $avatar){
			if (!empty($this -> dao -> select_user_github($this->db, $email))) {
				$user = $this -> dao -> select_user_github($this->db, $email);
				// echo json_encode($user[0]['username']);
				// exit;
				$token = middleware::create_token($user[0]['username']);
				return $token;
            } else {
				$this -> dao -> insert_user_github($this->db, $uid, $username, $email, $avatar);
				// echo json_encode($username);
				// exit;
				$user = $this -> dao -> select_user_github($this->db, $email);
				// echo json_encode($user[0]['username']);
				// exit;
				$token = middleware::create_token($user[0]['username']);
				return $token;
			}
		}

		public function get_data_user_BLL($username){
			return $this -> dao -> select_data_user($this -> db, $username);
		}

		public function get_data_user_google_bll($username){
			return $this -> dao -> select_user_google($this -> db, $username);
		}

		public function get_data_user_github_bll($username){
			// echo json_encode('hola github BLL '. $username);
			// exit;
			return $this -> dao -> select_user_github_menu($this -> db, $username);
		}

		public function get_user_log_BLL($username){
			// echo json_encode('Login BLL ' . $username);
			// exit;
			return $this -> dao -> select_user_log($this -> db, $username);
		}

		public function get_email_log_BLL($email){
			// echo json_encode('hola email log BLL '. $email);
			// exit;
			return $this -> dao -> select_email_log($this -> db, $email);
		}

		public function insert_local_user_BLL($username, $email, $pwd){
			return $this -> dao -> insert_local_user($this -> db, $username, $email, $pwd);
		}
		
		public function check_google_email_BLL($email){
			return $this -> dao -> check_google_email($this -> db, $email);
		}

		public function check_github_email_BLL($email){
			return $this -> dao -> check_github_email($this -> db, $email);
		}

		public function check_local_email_BLL($email){
			return $this -> dao -> check_local_email($this -> db, $email);
		}

		public function check_username_BLL($username){
			return $this -> dao -> check_username($this -> db, $username);
		}
    } // auth_bll

?>