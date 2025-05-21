<?php

    @session_start();

    class ctrl_auth{

        function login_view(){
            common::load_view('top_page_auth.html', VIEW_PATH_AUTH . 'login.html');
        }

        function register_view(){
            common::load_view('top_page_auth.html', VIEW_PATH_AUTH . 'register.html');
        }

        function recover_view(){
            common::load_view('top_page_auth.html', VIEW_PATH_AUTH . 'recover.html');
        }

        function recover(){
            ctrl_auth::recover_view();
        }

        function verify(){
            ctrl_auth::login_view();
        }

        function social_login(){
            $uid = $_POST['id'];
            // echo json_encode($uid);
            // exit;
            $username = $_POST['username'];
            // echo json_encode($username);
            // exit;
            $email = $_POST['email'];
            // echo json_encode($email);
            // exit;
            $avatar = $_POST['avatar'];
            // echo json_encode($avatar);
            // exit;
            $provider = $_POST['provider'];
            if($provider == "google"){
                $googleLogin = common::load_model('auth_model', 'getSocialLoginGoogle', [$uid, $username, $email, $avatar]);
                if($googleLogin){
                    $_SESSION['username'] = $username;
                    $_SESSION['tiempo'] = time();
                    echo json_encode($googleLogin);
                    exit;
                }else{
                    echo json_encode('ERRORgoogleLogin');
                    exit;
                }
            }else if($provider == "github"){
                // echo json_encode("social_login: github");
                // exit;
                $githubLogin = common::load_model('auth_model', 'getSocialLoginGithub', [$uid, $username, $email, $avatar]);
                if($githubLogin){
                    $_SESSION['username'] = $username;
                    $_SESSION['tiempo'] = time();
                    echo json_encode($githubLogin);
                    exit;
                }else{
                    echo json_encode('ERRORgithubLogin');
                    exit;
                }
            }
        }

        function login(){
            $username = $_POST['username'];
            // echo json_encode($username);
            // exit;
            $pwd = $_POST['password'];
            // echo json_encode($pwd);
            // exit;
            try {
                // echo json_encode('hola try login');
                // exit;
                $rdo = common::load_model('auth_model', 'getUserLog', $username);
                // echo json_encode('hola login despues rdo');
                // echo json_encode($rdo);
                // echo json_encode($rdo[0]['pwd']);
                // exit;

                if ($rdo == "error_user") {
                    $rdo_email = common::load_model('auth_model', 'getEmailLog', $username);
                    // echo json_encode($rdo_email);
                    // exit;

                    if($rdo_email == "error_email"){
                        echo json_encode("error_user");
                        exit;
                    }else{
                        // echo json_encode($rdo_email);
                        // exit;
                        if (password_verify($pwd, $rdo_email[0]['pwd'])) {
                            if($rdo_email[0]['activate'] == 0){
                                echo json_encode('cuenta_desactivada');
                                exit;
                            }else{
                                $token = middleware::create_token($rdo_email[0]["username"]);
                                // echo json_encode($rdo_email);
                                // exit;
                                $_SESSION['username'] = $rdo_email[0]['username']; //Guardamos el correo
                                $_SESSION['tiempo'] = time(); //Guardamos el tiempo que se logea
                                echo json_encode($token);
                                exit;
                            }
                        } else {
                            echo json_encode("error_pwd");
                            exit;
                        }
                    }
                }else{
                    // echo json_encode('hola antes del if pwd verify user');
                    // exit;
                    // echo json_encode($rdo['pwd']);
                    // exit;
                    // echo json_encode($rdo);
                    // exit;
                    if (password_verify($pwd, $rdo[0]['pwd'])) {
                        if($rdo[0]['activate'] == 0){
                            echo json_encode('cuenta_desactivada');
                            exit;
                        }else{
                            // echo json_encode('hola login antes de crear token');
                            // exit;
                            $token= middleware::create_token($rdo[0]["username"]);
                            // echo json_encode($token);
                            // exit;
                            $_SESSION['username'] = $rdo[0]['username']; //Guardamos el usario 
                            $_SESSION['tiempo'] = time(); //Guardamos el tiempo que se logea
                            echo json_encode($token);
                            exit;
                        }
                    } else {
                        echo json_encode("error_pwd");
                        exit;
                    }
                }
            } catch (Exception $e) {
                echo json_encode("error");
                exit;
            }
        }

        function register(){
            // $pruebaTokenSecure = common::generate_token_secure(20);
            // echo json_encode($pruebaTokenSecure);
            // exit;
            $email = $_POST['email_reg'];
            $username = $_POST['username_reg'];
            $pwd = $_POST['pwd1_reg'];
            // echo json_encode($email);
            // exit;
            try {
                $checkEmail = common::load_model('auth_model', 'checkLocalEmail', $email);
            } catch (Exception $e) {
                echo json_encode("error");
                exit;
            }

            try {
                $checkUsername = common::load_model('auth_model', 'checkUsername', $username);
            } catch (Exception $e) {
                echo json_encode("error");
                exit;
            }

            try{
                $checkEmailGoogle = common::load_model('auth_model', 'checkGoogleEmail', $email);
            }catch(Exception $e){
                echo json_encode("error");
                exit;
            }

            try{
                $checkEmailGithub = common::load_model('auth_model', 'checkGithubEmail', $email);
            }catch(Exception $e){
                echo json_encode("error");
                exit;
            }
    
            // evitar redundancia de emails
            if ($checkEmail == "error_email") {
                echo json_encode("error_email");
                exit;
            } else if($checkUsername == "error_username"){
                echo json_encode("error_username");
                exit;
            } else if ($checkEmailGoogle == "error_email_google"){
                echo json_encode("error_email_google");
                exit;
            } else if ($checkEmailGithub == "error_email_github"){
                echo json_encode("error_email_github");
                exit;
            }else{
                try {
                    $rdo = common::load_model('auth_model', 'insertLocalUser', [$username, $email, $pwd]);
                } catch (Exception $e) {
                    echo json_encode("error");
                    exit;
                }
                if (!$rdo) {
                    echo json_encode("error_user");
                    exit;
                } else {
                    // echo json_encode($rdo); // ver consulta insert por consola
                    // $sendEmail = common::load_model('auth_model', 'welcomeEmail', [$email, $username]);
                    echo json_encode("ok");
                    exit;
                }
            }
                
        }

        function data_user(){
            $token = $_POST['token'];
            // echo json_encode($token);
            // exit;
            $provider = $_POST['provider'];
            $json_token = middleware::decode_token($token);
            // echo json_encode($json_token);
            // echo json_encode($json_token['username']);
            // exit();
            if($provider == "google"){
                echo json_encode(common::load_model('auth_model', 'getDataUserGoogle', $json_token['username']));
            }else if($provider == "github"){
                // echo json_encode('hola data_user github');
                // exit;
                echo json_encode(common::load_model('auth_model', 'getDataUserGithub', $json_token['username']));
            }else {
                echo json_encode(common::load_model('auth_model', 'getDataUser', $json_token['username']));
            }
        }

        function control_user(){
            $tokenNormal = $_POST['token'];
            // echo json_encode($tokenNormal);
            // exit();

            $tokenDec = middleware::decode_token($tokenNormal);
            // echo json_encode($tokenDec['username']);
            // exit();

            if ($tokenDec['exp'] < time()) {
                echo json_encode("UsuarioNoValido");
                exit();
            }

            if (isset($_SESSION['username']) && ($_SESSION['username']) == $tokenDec['username']) {
                echo json_encode("UsuarioValido");
                exit();
            } else {
                echo json_encode("UsuarioNoValido");
                exit();
            }
        }

        function actividad(){
            if(!isset($_SESSION["tiempo"])){
                echo json_encode("inactivo");
                exit();
            }else{
                if((time() - $_SESSION["tiempo"]) >= 60){ // 1800s = 30min
                    echo json_encode("inactivo");
                    exit();
                }else{
                    echo json_encode("activo");
                    exit();
                }
            }
        }

        function refres_token(){
            $tokenNormal = $_POST['token'];
            // echo json_encode($tokenNormal);
            // exit;

            $oldToken = middleware::decode_token($tokenNormal);
            $newToken = middleware::create_token($oldToken['username']);
            echo json_encode($newToken);
        }

        function refres_cookie(){
            session_regenerate_id();
            echo json_encode("cookie_actualizada");
        }

        function logout(){
            unset($_SESSION['username']);
            unset($_SESSION['tiempo']);
            session_destroy();

            echo json_encode('logout_correct');
        }

        function verify_email() { // validar el email al registrarse
            // echo json_encode('hola verify_email');
            // exit;
            $tokenEmail = $_POST['token_email'];
            // echo json_encode($tokenEmail);
            // exit;
            echo json_encode(common::load_model('auth_model', 'getVerifyEmail', $tokenEmail));
        }


        function send_email_recover_pwd(){ // enviar el email para cambiar la contraseña
            $email = $_POST['email'];
            // echo json_encode($email);
            // exit;
            echo json_encode(common::load_model('auth_model', 'sendEmailRecoverPwd', $email));
        }
        
        function verify_token(){ // validar el token al querer cambiar la contraseña
            $tokenEmail = $_POST['token_email'];
            $pwd = $_POST['pwd'];
            echo json_encode(common::load_model('auth_model', 'getVerifyToken', [$tokenEmail, $pwd]));
        }

    } //ctrl_auth

?>