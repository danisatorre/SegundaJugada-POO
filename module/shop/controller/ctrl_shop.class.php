<?php
    // echo 'hola ctrl_shop.class.php';
    // exit;
    $path = $_SERVER['DOCUMENT_ROOT'] . '/SegundaJugada-POO';

    class ctrl_shop{
        
        function view(){
            // echo 'hola view shop';
            // exit;
            // echo VIEW_PATH_SHOP . 'shop.html';
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

        function load_likes_user(){
            $tokenNormal = $_POST['token'];
            $token = decode_token($tokenNormal);
            $username = $token['username'];
            echo json_encode(common::load_model('shop_model', 'getLoadLikesUser'), $username);
        }

        function ctrl_likes(){
            $id_producto = $_POST['id_producto'];
            $tokenNormal = $_POST['token'];
            $token = decode_token($tokenNormal);
            $username = $token['username'];
            
            $likes = common::load_model('shop_model', 'getLikes', [$id_producto, $username]);

            if(!$likes){
                echo json_encode('error');
                exit;
            }else{
                $dsinfo = array();
                foreach($likes as $row){
                    array_push($dsinfo, $row);
                }

                if(count($dsinfo) === 0){
                    $select_ctrl_likes = common::load_model('shop_model', 'like', [$id_producto, $username]);
                    $update_ctrl_likes = common::load_model('shop_model', 'sumar_like', $id_producto);
                    echo json_encode('0');
                    exit;
                }else{
                    $select_ctrl_likes = common::load_model('shop_model', 'dislike', [$id_producto, $username]);
                    $update_ctrl_likes = common::load_model('shop_model', 'restar_like', $id_producto);
                    echo json_encode('1');
                    exit;
                }
            } // end if-else !$likes
        }

        function filtro_buscador(){
            $buscador = $_POST['buscar'];
            $ciudad = ($buscador[0]['filtro_ciudad']);
            $tipo = ($buscador[1]['filtro_tipo'][0]);
            $categoria = ($buscador[2]['filtro_categoria']);
            $offset = $_POST['offset'];
            $limit = $_POST['limit'];

            try {
                if (($categoria != "0") && ($tipo == "0") && ($ciudad == "0")) {
                    echo json_encode(common::load_model('shop_model', 'getCategoriaBuscador', [$categoria, $offset, $limit]));
                } else if (($categoria == "0") && ($tipo != "0") && ($ciudad == "0")) {
                    echo json_encode(common::load_model('shop_model', 'getTipoBuscador', [$tipo, $offset, $limit]));
                } else if (($categoria == "0") && ($tipo == "0") && ($ciudad != "0")) {
                    echo json_encode(common::load_model('shop_model', 'getCiudadBuscador', [$ciudad, $offset, $limit]));
                } else if (($categoria != "0") && ($tipo != "0") && ($ciudad == "0")) {
                    echo json_encode(common::load_model('shop_model', 'getCategoriaTipoBuscador', [$categoria, $tipo, $offset, $limit]));
                } else if (($categoria == "0") && ($tipo != "0") && ($ciudad != "0")) {
                    echo json_encode(common::load_model('shop_model', 'getTipoCiudadBuscador', [$tipo, $ciudad, $offset, $limit]));
                } else if (($categoria != "0") && ($tipo == "0") && ($ciudad != "0")) {
                    echo json_encode(common::load_model('shop_model', 'getCategoriaCiudadBuscador', [$categoria, $ciudad, $offset, $limit]));
                } else if (($categoria != "0") && ($tipo != "0") && ($ciudad != "0")) {
                    echo json_encode(common::load_model('shop_model', 'getAllBuscador', [$categoria, $tipo, $ciudad, $offset, $limit]));
                } else {
                    echo json_encode(common::load_model('shop_model', 'getAll', [$offset, $limit]));
                }
            } catch (Exception $e) {
                echo json_encode("error");
                exit;
            }
        }

        function details(){
            $id_producto = $_POST['id_producto'];
            // echo json_encode($id_producto);
            // exit;
            $infProducto = common::load_model('shop_model', 'getDetails', $id_producto);
            // echo json_encode($infProducto);
            // exit;
            $imgProducto = common::load_model('shop_model', 'getImgDetails', $id_producto);
            // echo json_encode($imgProducto);
            // exit;

            if (!empty($infProducto) || !empty($imgProducto)) {
                $rdo = array();
                $rdo[0] = $infProducto;
                $rdo[1][] = $imgProducto;
                echo json_encode($rdo);
                exit;
            } else {
                echo json_encode('error');
                exit;
            }
        }

        function count_productos_relacionados(){
            $tipo = $_POST['tipo'];
            $id_producto = $_POST['id_producto'];
            echo json_encode(common::load_model('shop_model', 'getCountProductosRelacionados', [$tipo, $id_producto]));
        }

        function productos_relacionados(){
            $tipo = $_POST['tipo_producto'];
            // echo json_encode($tipo);
            // exit;
            $loaded =  $_POST['loaded'];
            // echo json_encode($loaded);
            // exit;
            $items =  $_POST['items'];
            // echo json_encode($items);
            // exit;
            $id_producto = $_POST['id_producto'];
            // echo json_encode($id_producto);
            // exit;
            echo json_encode(common::load_model('shop_model', 'getProductosRelacionados', [$tipo, $loaded, $items, $id_producto]));
        }

        function update_visitas(){
            $id_producto = $_POST['id_producto'];
            common::load_model('shop_model', 'sumarVisitas', $id_producto);
        }

        function update_rating(){
            $id_producto = $_POST['id_producto'];
            $rating = $_POST['rating'];
            common::load_model('shop_model', 'updateRating', [$id_producto, $rating]);
        }

        function update_visitas_categoria(){
            $id_categoria = $_POST['id_categoria'];
            common::load_model('shop_model', 'updateVisitasCategoria', $id_categoria);
        }

        function update_visitas_tipo(){
            $id_tipo = $_POST['id_tipo'];
            common::load_model('shop_model', 'updateVisitasTipo', $id_tipo);
        }

        function filtro_home(){
            $filtro = "";

            if (isset($_POST['filtro_categoria'])) {
                $filtro = $_POST['filtro_categoria'];
                $filtro_home = "p.categoria = '" . $filtro . "'";
            } else if (isset($_POST['filtro_marca'])) {
                $filtro = $_POST['filtro_marca'];
                $filtro_home = "p.marca = '" . $filtro . "'";
            } else if (isset($_POST['filtro_tipo'])) {
                $filtro = $_POST['filtro_tipo'];
                $filtro_home = "p.tipo = '" . $filtro . "'";
            } else if (isset($_POST['filtro_accesorio'])) {
                $filtro = $_POST['filtro_accesorio'];
                $filtro_home = "p.tipo = '" . $filtro . "'";
            }

            echo json_encode(common::load_model('shop_model', 'getFiltroHome', $filtro_home));
        }

    } // ctrl_home

?>