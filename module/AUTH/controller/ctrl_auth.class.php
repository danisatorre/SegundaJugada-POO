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

        function social_login_google(){
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
            echo json_encode(common::load_model('auth_model', 'getSocialLoginGoogle', [$uid, $username, $email, $avatar]));
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
                        if (password_verify($pwd, $rdo_email[0]['pwd'])) {
                            $token = middleware::create_token($rdo_email[0]["username"]);
                            // echo json_encode($rdo_email);
                            // exit;
                            $_SESSION['username'] = $rdo_email[0]['username']; //Guardamos el correo
                            $_SESSION['tiempo'] = time(); //Guardamos el tiempo que se logea
                            echo json_encode($token);
                            exit;
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
                    if (password_verify($pwd, $rdo[0]['pwd'])) {
                        // echo json_encode('hola login antes de crear token');
                        // exit;
                        $token= middleware::create_token($rdo[0]["username"]);
                        // echo json_encode($token);
                        // exit;
                        $_SESSION['username'] = $rdo[0]['username']; //Guardamos el usario 
                        $_SESSION['tiempo'] = time(); //Guardamos el tiempo que se logea
                        echo json_encode($token);
                        exit;
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

        function data_user(){
            $token = $_POST['token'];
            // echo json_encode($token);
            // exit;
            $json_token = middleware::decode_token($token);
            // echo json_encode($json_token);
            // echo json_encode($json_token['username']);
            // exit();
            echo json_encode(common::load_model('auth_model', 'getDataUser', $json_token['username']));
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

    } //ctrl_auth

?>