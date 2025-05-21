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
			$tokenEmail = common::generate_token_secure(20);
			$insert = $this -> dao -> insert_local_user($this -> db, $username, $email, $pwd, $tokenEmail);
			$dataEmail = ['tipo' => 'register', 'email' => $email, 'username' => $username, 'tokenEmail' => $tokenEmail];
			$email = mail::send_email($dataEmail);
			if(!empty($email)){
				return $insert;
			}
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

		public function welcome_email_BLL($email, $username){
			$dataEmail = ['tipo' => 'welcome', 'email' => $email, 'username' => $username ];
			mail::send_email($dataEmail);
		}

		public function get_verify_email_BLL($tokenEmail){
			if($this -> dao -> select_verify_email($this->db, $tokenEmail)){
				$this -> dao -> update_verify_email($this->db, $tokenEmail);
				return 'verify';
			} else {
				return 'fail';
			}
		}

		public function send_email_recover_pwd_BLL($email){
			// echo json_encode($email);
			// exit;
			$tokenEmail = common::generate_token_secure(20);
			$insertToken = $this -> dao -> insert_token_recover_pwd($this->db, $email, $tokenEmail);
			$dataEmail = ['tipo' => 'recover', 'email' => $email, 'tokenEmail' => $tokenEmail];
			$email = mail::send_email($dataEmail);
			if(!empty($email)){
				return $insertToken;
			}
		}

		public function get_verify_token_BLL($tokenEmail, $pwd){
			if($this -> dao -> select_verify_email($this->db, $tokenEmail)){
				$updatePWD = $this -> dao -> update_pwd($this->db, $tokenEmail, $pwd);
				return 'ok';
			}else{
				return 'fail';
			}
		}
    } // auth_bll

?>