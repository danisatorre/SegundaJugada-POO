<?php
    // echo 'hola ctrl_home.class.php';
    // exit;
    $path = $_SERVER['DOCUMENT_ROOT'] . '/SegundaJugada-POO';

    class ctrl_home{
        
        function view(){
            // echo 'hola view home';
            // exit;
            // include('module/home/view/home.html');
            // echo SITE_PATH . 'view/css/glider.css';
            // exit;
            common::load_view('top_page_home.html', VIEW_PATH_HOME . 'home.html');
        }

    } // ctrl_home

?>