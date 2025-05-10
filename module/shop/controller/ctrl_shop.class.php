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
            $offset = $_POST['offset'];
            $limit = $_POST['limit'];

            echo json_encode(common::load_model('shop_model', 'getAll', [$offset, $limit]));
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

        function filtrar(){
            $filtro=($_POST['filtro']);
            $offset = $_POST['offset'];
            $limit = $_POST['limit'];

            echo json_encode(common::load_model('shop_model', 'getFiltrar', [$filtro, $offset, $limit]));
        }
        
        function count_productos_filtros(){
            $filtro = $_POST['filtro'];
            echo json_encode(common::load_model('shop_model', 'getCountProductosFiltros', $filtro));
        }

        function count_buscador(){
            $buscador = $_POST['buscar'];
            $ciudad = ($buscador[0]['filtro_ciudad']);
            $tipo = ($buscador[1]['filtro_tipo'][0]);
            $categoria = ($buscador[2]['filtro_categoria']);
            echo json_encode(common::load_model('shop_model', 'getCountBuscador', [$ciudad, $tipo, $categoria]));
        }

        function count_productos_all(){
            echo json_encode(common::load_model('shop_model', 'getCountProductosAll'));
        }

    } // ctrl_home

?>