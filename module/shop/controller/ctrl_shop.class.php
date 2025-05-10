<?php
    // echo 'hola ctrl_shop.class.php';
    // exit;
    $path = $_SERVER['DOCUMENT_ROOT'] . '/SegundaJugada-POO';

    class ctrl_shop{
        
        function view(){
            // echo 'hola view shop';
            // exit;
            common::load_view('top_page_shop.html', VIEW_PATH_SHOP . 'shop.html');
        }

        function getall(){

        }

        function filtro_equipos(){
            // echo json_encode('hola filtro_equipos ctrl_shop.class.php');
            // exit;
            echo json_encode(common::load_model('shop_model', 'getEquipos'));
        }

    } // ctrl_home

?>