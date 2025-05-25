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

		public function insert_local_user_BLL($username, $email, $pwd, $tlf){ // registrar un usuario local
			// $tokenEmail = common::generate_token_secure(20);
			$tokenEmail = middleware::create_token_2h($email);
			$insert = $this -> dao -> insert_local_user($this -> db, $username, $email, $pwd, $tokenEmail, $tlf);
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
			$tokenDec = middleware::decode_token($tokenEmail);
			if (!$tokenDec || !isset($tokenDec['exp']) || time() > $tokenDec['exp']) {
				// si el token ha expirado se elimina la cuenta
				$deleteAccount = $this -> dao -> token_register_expires($this -> db, $tokenEmail);
				return 'expired';
			}

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
			$checkEmail = $this -> dao -> check_local_email($this -> db, $email);
			if($checkEmail == 1){ // si el email introducido no existe devolver fail para avisar al cliente
				return 'fail';
			}
			// $tokenEmail = common::generate_token_secure(20);
			$tokenEmail = middleware::create_token_2h($email);
			$insertToken = $this -> dao -> insert_token_recover_pwd($this->db, $email, $tokenEmail);
			$dataEmail = ['tipo' => 'recover', 'email' => $email, 'tokenEmail' => $tokenEmail];
			$email = mail::send_email($dataEmail);
			if(!empty($email)){
				return 'ok';
			}
		}

		public function get_verify_token_BLL($tokenEmail, $pwd){
			// decodificar el token para verificar si su tiempo ha expirado
			$tokenDec = middleware::decode_token($tokenEmail);
			if (!$tokenDec || !isset($tokenDec['exp']) || time() > $tokenDec['exp']) {
				return 'expired';
			}
			// si el token es válido verificar que usuario existe con el mismo token para cambiar su contraseña
			if($this -> dao -> select_verify_email($this->db, $tokenEmail)){
				$updatePWD = $this -> dao -> update_pwd($this->db, $tokenEmail, $pwd);
				return 'ok';
			}else{
				return 'fail';
			}
		}

		public function get_prefijos_phone_BLL(){
			return $this -> dao -> select_prefijos_phone($this->db);
		}

		public function send_OTP_BLL($param){
			// echo json_encode('hola send OTP BLL');
			// exit;
			$check = $this -> dao -> check_username_or_email_local($this -> db, $param);
			// echo json_encode('hola despues de check username or email local' . $check);
			// exit;
			if($check == 1){
				$intents = $this -> dao -> select_log_intents($this -> db, $param);
				// echo json_encode('var intents send OTP BLL' . $intents[0]['log_intents']);
				// exit;
				if($intents[0]['log_intents'] == 3){ // enviar OTP por whatsapp al fallar 3 veces la contraseña
					$dataUser = $this -> dao -> select_username_or_email_local($this->db, $param);
					$otp = common::generate_token_secure(4);
					$this -> dao -> set_otp_db($this->db, $param, $otp);
					// echo json_encode($otp);
					// exit;
					// echo json_encode($dataUser[0]['telf']);
					// exit;
					$dataMessage = ['tipo' => 'otp', 'otp' => $otp, 'tlf' => $dataUser[0]['telf']];
					// echo json_encode($dataMessage);
					// exit;
					$sendOTP = ultramsg::send_whatsapp($dataMessage);
					// echo json_encode($sendOTP);
					// exit;
					return 'otp_send';
					
					
				}else{
					// echo json_encode('hola log_intents <3');
					// exit;
					$this -> dao -> update_log_intents($this -> db, $param);
					return 1;
				}
			}
			return 0;
			
		}

		public function verify_OTP_BLL($user, $otp){
			return $this -> dao -> verify_OTP($this -> db, $user, $otp);
		}

		public function iniciar_sesion_OTP_BLL($user){
			return $this -> dao -> select_username_or_email_local($this -> db, $user);
		}

		public function disable_OTP_db_BLL($username){
			$this -> dao -> disable_OTP_db($this -> db, $username);
		}
    } // auth_bll

?>