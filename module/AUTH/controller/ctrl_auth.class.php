<?php

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

        function data_user(){
            $token = $_POST['token'];
            // $data_user = $token;
            // echo json_encode($data_user['username']);
            // exit;
            $json_token = decode_token($token);
            // echo json_encode($json_token);
            // exit();
            echo json_encode(common::load_model('auth_model', 'getDataUser', $json_token['username']));
        }

        

    } //ctrl_auth

?>