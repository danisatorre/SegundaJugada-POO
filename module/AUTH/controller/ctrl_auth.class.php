<?php

    class ctrl_auth{

        function login_view(){
            common::load_view('top_page_auth.html', VIEW_PATH_AUTH . 'login.html');
        }

        function register_view(){
            common::load_view('top_page_auth.html', VIEW_PATH_AUTH . 'register.html');
        }

    } //ctrl_auth

?>