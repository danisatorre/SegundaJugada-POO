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

        function prueba_POST_framework(){
            // $parametro1 = $_POST['parametro1'];
            // $parametro2 = $_POST['parametro2'];
            // echo json_encode($parametro1);
            // exit;
            // echo json_encode($parametro2);
            // exit;
            // echo json_encode(common::load_model('shop_model', 'pruebaPOST', [$parametro1, $parametro2]));
            $parametro = $_POST['parametro'];
            // echo json_encode($parametro);
            // exit;
            echo json_encode(common::load_model('shop_model', 'pruebaPOST', $parametro));
        } // funcion de prueba para aprender a pasar uno o más parametros por POST a los demas ficheros
        
        function count_productos_filtros(){
            $filtro = $_POST['filtro'];
            echo json_encode(common::load_model('shop_model', 'getCountProductosFiltros', [$filtro]));
        }

    } // ctrl_home

?>