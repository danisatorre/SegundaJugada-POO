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
            echo json_encode(common::load_model('auth_model', 'getSocialLogin', [$uid, $username, $email, $avatar]));
        }

    } //ctrl_auth

?>