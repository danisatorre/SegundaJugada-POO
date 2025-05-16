<?php
    // echo 'hola ctrl_home.class.php';
    // exit;
    $path = $_SERVER['DOCUMENT_ROOT'] . '/SegundaJugada-POO';
    // ACTIVIDAD DEL USUARIO
    if(isset($_SESSION['tiempo'])){
        $_SESSION['tiempo'] = time(); // devuelve la fecha actual
    }
    class ctrl_home{
        
        function view(){
            // echo 'hola view home';
            // exit;
            // include('module/home/view/home.html');
            // echo SITE_PATH . 'view/css/glider.css';
            // exit;
            common::load_view('top_page_home.html', VIEW_PATH_HOME . 'home.html');
        }

        function marcas(){
            // echo json_encode('hola marcas home');
            // exit;
            echo json_encode(common::load_model('home_model', 'getMarcas'));
        }

        function carousel_principal(){
            echo json_encode(common::load_model('home_model', 'carousel_principal'));
        }

        function categorias(){
            echo json_encode(common::load_model('home_model', 'getCategorias'));
        }

        function tipos(){
            echo json_encode(common::load_model('home_model', 'getTipos'));
        }

        function carousel_productos(){
            echo json_encode(common::load_model('home_model', 'getProductos'));
        }

        function accesorios(){
            echo json_encode(common::load_model('home_model', 'getAccesorios'));
        }

        function populares(){
            echo json_encode(common::load_model('home_model', 'getPopulares'));
        }

        function mostrating(){
            echo json_encode(common::load_model('home_model', 'getMostRating'));
        }

        function mostratingcategoria(){
            echo json_encode(common::load_model('home_model', 'getMostRatingCategoria'));
        }

        function mostratingtipo(){
            echo json_encode(common::load_model('home_model', 'getMostRatingTipo'));
        }

    } // ctrl_home

?>