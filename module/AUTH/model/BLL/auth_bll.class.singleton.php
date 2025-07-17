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

		public function get_social_login_google_BLL($uid, $username, $email, $avatar){ // iniciar sesión mediante google
			if (!empty($this -> dao -> select_user_google($this->db, $username))) { // si el usuario de google existe inicia sesión con el
				$user = $this -> dao -> select_user_google($this->db, $username); // coger los datos del usuario de google
				// echo json_encode($user[0]['username']);
				// exit;
				$token = middleware::create_token_provider($user[0]['username'], 'google'); // crear el token JWT indicando el provider
				return $token;
            } else { // si el usuario de google no existe se inserta en la db y se inicia sesión
				$this -> dao -> insert_user_google($this->db, $uid, $username, $email, $avatar); // insertar en la db el usuario de google
				// echo json_encode($username);
				// exit;
				$user = $this -> dao -> select_user_google($this->db, $username); // coger los datos del usuario de google
				// echo json_encode($user[0]['username']);
				// exit;
				$token = middleware::create_token_provider($user[0]['username'], 'google'); // crear el token JWT indicando el provider
				return $token;
			}
		}

		public function get_social_login_github_BLL($uid, $username, $email, $avatar){ // iniciar sesión mediante github
			if (!empty($this -> dao -> select_user_github($this->db, $email))) { // si el usuario de github existe se inicia sesión
				$user = $this -> dao -> select_user_github($this->db, $email); // coger los datos del usuario de github
				// echo json_encode($user[0]['username']);
				// exit;
				$token = middleware::create_token_provider($user[0]['username'], 'github'); // crear un token JWT indicando el provider
				return $token;
            } else { // si el usuario de github no existe se inserta en la db y se inicia sesión
				$this -> dao -> insert_user_github($this->db, $uid, $username, $email, $avatar); // insertar en la db el usuario de github
				// echo json_encode($username);
				// exit;
				$user = $this -> dao -> select_user_github($this->db, $email); // coger los datos del usuario de github
				// echo json_encode($user[0]['username']);
				// exit;
				$token = middleware::create_token_provider($user[0]['username'], 'github'); // crear un token JWT indicando el provider
				return $token;
			}
		}

		public function get_data_user_BLL($username){ // coger los datos de un usuario local
			return $this -> dao -> select_data_user($this -> db, $username);
		}

		public function get_data_user_google_bll($username){ // coger los datos de un usuario de google
			return $this -> dao -> select_user_google($this -> db, $username);
		}

		public function get_data_user_github_bll($username){ // coger los datos de un usuario de github
			// echo json_encode('hola github BLL '. $username);
			// exit;
			return $this -> dao -> select_user_github_menu($this -> db, $username);
		}

		public function get_user_log_BLL($username){ // coger los datos de un usuario local al iniciar sesión por username
			// echo json_encode('Login BLL ' . $username);
			// exit;
			return $this -> dao -> select_user_log($this -> db, $username);
		}

		public function get_email_log_BLL($email){ // coger los datos de un usuario local al iniciar sesión por email
			// echo json_encode('hola email log BLL '. $email);
			// exit;
			return $this -> dao -> select_email_log($this -> db, $email);
		}

		public function insert_local_user_BLL($username, $email, $pwd, $tlf){ // registrar un usuario local
			// $tokenEmail = common::generate_token_secure(20);
			$tokenEmail = middleware::create_token_2h($email); // crear un token válido solamente durante 2 horas
			$insert = $this -> dao -> insert_local_user($this -> db, $username, $email, $pwd, $tokenEmail, $tlf); // insertar el usuario local en la db
			$dataEmail = ['tipo' => 'register', 'email' => $email, 'username' => $username, 'tokenEmail' => $tokenEmail];
			$email = mail::send_email($dataEmail); // enviar el email de verificación
			if(!empty($email)){
				return $insert;
			}
		}
		
		public function check_google_email_BLL($email){ // verificar si existe un usuario de google con el mismo email
			return $this -> dao -> check_google_email($this -> db, $email);
		}

		public function check_github_email_BLL($email){ // verificar si existe un usuario de github con el mismo email
			return $this -> dao -> check_github_email($this -> db, $email);
		}

		public function check_local_email_BLL($email){ // verificar si existe un usuario local con el mismo email
			return $this -> dao -> check_local_email($this -> db, $email);
		}

		public function check_username_BLL($username){ // verificar si existe un usuario local con el mismo username
			return $this -> dao -> check_username($this -> db, $username);
		}

		public function welcome_email_BLL($email, $username){ // mandar un correo de bienvenida (no en uso)
			$dataEmail = ['tipo' => 'welcome', 'email' => $email, 'username' => $username ];
			mail::send_email($dataEmail); // mandar el correo de bienvenida
		}

		public function get_verify_email_BLL($tokenEmail){ // verificar si el token es válido al registrar un nuevo usario local
			$tokenDec = middleware::decode_token($tokenEmail); // decodificar el token JWT
			$user = $tokenDec['username']; // coger el username del token decodificado
			if (!$tokenDec || !isset($tokenDec['exp']) || time() > $tokenDec['exp']) { // si el token ha expirado se elimina la cuenta
				$deleteAccount = $this -> dao -> token_register_expires($this -> db, $tokenEmail); // eliminar la cuenta en la db
				return 'expired';
			}

			if($this -> dao -> select_verify_email_token($this->db, $tokenEmail, $user)){ // si el token aún no ha expirado se activa la cuenta local para poder iniciar sesión
				$this -> dao -> update_verify_email($this->db, $tokenEmail, $user); // actualizar activate a 1 en la db para poder iniciar sesión
				return 'verify';
			} else {
				return 'fail';
			}
		}

		public function send_email_recover_pwd_BLL($email){ // mandar un email para restablecer la contraseña
			// echo json_encode($email);
			// exit;
			$checkEmail = $this -> dao -> check_local_email($this -> db, $email);
			if($checkEmail == 1){ // si el email introducido no existe devolver fail para avisar al cliente
				return 'fail';
			}
			// $tokenEmail = common::generate_token_secure(20);
			$tokenEmail = middleware::create_token_2h($email); // crear un token válido solamente por 2 horas
			$insertToken = $this -> dao -> insert_token_recover_pwd($this->db, $email, $tokenEmail); // desactivar la cuneta temporalmente y añadir el tokenemail al usuario en la db
			$dataEmail = ['tipo' => 'recover', 'email' => $email, 'tokenEmail' => $tokenEmail]; // datos para el email
			$email = mail::send_email($dataEmail); // mandar el email para restablecer la contraseña
			if(!empty($email)){
				return 'ok';
			}
		}

		public function get_verify_token_BLL($tokenEmail, $pwd){ // verificar el token al restablecer la contraseña
			$tokenDec = middleware::decode_token($tokenEmail); // decodificar el token para verificar si su tiempo ha expirado
			// echo json_encode($tokenDec['username']);
			// exit;
			$user = $tokenDec['username']; // sacar el username del token decodificado
			if (!$tokenDec || !isset($tokenDec['exp']) || time() > $tokenDec['exp']) { // si el token ha expirado no deja cambiar la contraseña
				return 'expired';
			}
			// si el token es válido verificar que usuario existe con el mismo token para cambiar su contraseña
			if($this -> dao -> select_verify_email_token($this->db, $tokenEmail, $user)){ // si en la db existe un usuario con el mismo token y username/email actualizar su contraseña
				$checkPwd = $this -> dao -> select_email_log($this->db, $user); // coger la anterior contraseña del usuario
				if(password_verify($pwd, $checkPwd[0]['pwd'])){ // si la contraseña es la misma que la anterior no deja cambiar la contraseña
					return 'samePwd';
					exit;
				}
				$updatePWD = $this -> dao -> update_pwd($this->db, $tokenEmail, $pwd, $user); // si la contraseña introducida no coincide con la anterior actualizar su contraseña en la db
				return 'ok';
			}else{
				return 'fail';
			}
		}

		public function get_prefijos_phone_BLL(){ // coger los nº de los prefijos de tlf de la tabla country
			return $this -> dao -> select_prefijos_phone($this->db);
		}

		public function send_OTP_BLL($param){ // enviar un OTP por whatsapp mediante ultramsg
			// echo json_encode('hola send OTP BLL');
			// exit;
			$check = $this -> dao -> check_username_or_email_local($this -> db, $param); // verificar si existe un usuario local con el mismo username/email
			// echo json_encode('hola despues de check username or email local' . $check);
			// exit;
			if($check == 1){ // si el usuario existe en la db enviar el OTP
				$intents = $this -> dao -> select_log_intents($this -> db, $param); // coger cuantos intentos fallidos de inicio de sesión tiene el usuario
				// echo json_encode('var intents send OTP BLL' . $intents[0]['log_intents']);
				// exit;
				if($intents[0]['log_intents'] == 3){ // enviar OTP por whatsapp al fallar 3 veces la contraseña
					$dataUser = $this -> dao -> select_username_or_email_local($this->db, $param); // coger los datos del usuario local
					$otp = common::generate_token_secure(4); // generar el código OTP que se manda al whatsapp del usuario
					$this -> dao -> set_otp_db($this->db, $param, $otp); // insertar el código OTP al usuario en la db
					// echo json_encode($otp);
					// exit;
					// echo json_encode($dataUser[0]['telf']);
					// exit;
					$dataMessage = ['tipo' => 'otp', 'otp' => $otp, 'tlf' => $dataUser[0]['telf']]; // datos del mensaje
					// echo json_encode($dataMessage);
					// exit;
					$sendOTP = ultramsg::send_whatsapp($dataMessage); // enviar el whatsapp al usuario
					// echo json_encode($sendOTP);
					// exit;
					return 'otp_send';
					
					
				}else{ // si los intentos fallidos de inicio de sesión del usuario son menores que 3 y hace un intento fallido sumar el nº de intentos fallidos en la db
					// echo json_encode('hola log_intents <3');
					// exit;
					$this -> dao -> update_log_intents($this -> db, $param); // sumar los intetnos fallidos en la db al usuario
					return 1;
				}
			}
			return 0;
			
		}

		public function verify_OTP_BLL($user, $otp){ // verificar si el OTP introducido es correcto
			return $this -> dao -> verify_OTP($this -> db, $user, $otp);
		}

		public function iniciar_sesion_OTP_BLL($user){ // iniciar sesión mediante el código OTP
			return $this -> dao -> select_username_or_email_local($this -> db, $user);
		}

		public function disable_OTP_db_BLL($username){ // eliminar el código OTP al usuario al iniciar sesión
			$this -> dao -> disable_OTP_db($this -> db, $username);
		}

		public function updateUsernameGoogle_BLL($oldUsername, $newUsername){
			return $this -> dao -> updateUsernameGoogle_DB($this -> db, $oldUsername, $newUsername);
		}

		public function updateUsernameGitHub_BLL($oldUsername, $newUsername){
			return $this -> dao -> updateUsernameGitHub_DB($this -> db, $oldUsername, $newUsername);
		}

		public function updateUsernameLocal_BLL($oldUsername, $newUsername){
			// echo json_encode($oldUsername);
			// exit;
			// echo json_encode($newUsername);
			// exit;
			return $this -> dao -> updateUsernameLocal_DB($this -> db, $oldUsername, $newUsername);
		}
    } // auth_bll

?>