<?php
    // echo 'hola ctrl_shop.class.php';
    // exit;
    $path = $_SERVER['DOCUMENT_ROOT'] . '/SegundaJugada-POO';
    // ACTIVIDAD DEL USUARIO
    if(isset($_SESSION['tiempo'])){
        $_SESSION['tiempo'] = time(); // devuelve la fecha actual
    }

    class ctrl_shop{

        static $_instance;

		function __construct() {
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
        
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

            $productos = common::load_model('shop_model', 'getAll', [$offset, $limit]);

            foreach ($productos as &$producto){
                $id_producto = $producto['id_producto'];
                $imagenes = common::load_model('shop_model', 'getImgDetails', $id_producto);
                $producto['imagenes'] = array();
                foreach($imagenes as $img){
                    $producto['imagenes'][] = $img['pimage_route'];
                }
            }

            echo json_encode($productos);
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

            $productos = common::load_model('shop_model', 'getFiltrar', [$filtro, $offset, $limit]);

            foreach($productos as &$producto){
                $id_producto = $producto['id_producto'];
                $imagenes = common::load_model('shop_model', 'getImgDetails', $id_producto);
                $producto['imagenes'] = array();
                foreach($imagenes as $img){
                    $producto['imagenes'][] = $img['pimage_route'];
                }
            }

            echo json_encode($productos);
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
            $token = middleware::decode_token($tokenNormal);
            $username = $token['username'];
            $provider = $token['provider'];
            // echo json_encode($username);
            // exit;
            echo json_encode(common::load_model('shop_model', 'getLoadLikesUser', [$username, $provider]));
        }

        function ctrl_likes(){
            $id_producto = $_POST['id_producto'];
            $tokenNormal = $_POST['token'];
            $token = middleware::decode_token($tokenNormal);
            $username = $token['username'];
            $provider = $token['provider'];
            // echo json_encode($username);
            // exit;
            
            $likes = common::load_model('shop_model', 'getLikes', [$id_producto, $username, $provider]);

            // echo json_encode($likes);
            // exit;

            if (empty($likes)) {
                $select_ctrl_likes = common::load_model('shop_model', 'like', [$id_producto, $username, $provider]);
                $update_ctrl_likes = common::load_model('shop_model', 'sumar_like', $id_producto);
                echo json_encode('0');
                exit;
            } else {
                $select_ctrl_likes = common::load_model('shop_model', 'dislike', [$id_producto, $username, $provider]);
                $update_ctrl_likes = common::load_model('shop_model', 'restar_like', $id_producto);
                echo json_encode('1');
                exit;
            }
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
                    $productos = common::load_model('shop_model', 'getCategoriaBuscador', [$categoria, $offset, $limit]);
                } else if (($categoria == "0") && ($tipo != "0") && ($ciudad == "0")) {
                    $productos = common::load_model('shop_model', 'getTipoBuscador', [$tipo, $offset, $limit]);
                } else if (($categoria == "0") && ($tipo == "0") && ($ciudad != "0")) {
                    $productos = common::load_model('shop_model', 'getCiudadBuscador', [$ciudad, $offset, $limit]);
                } else if (($categoria != "0") && ($tipo != "0") && ($ciudad == "0")) {
                    $productos = common::load_model('shop_model', 'getCategoriaTipoBuscador', [$categoria, $tipo, $offset, $limit]);
                } else if (($categoria == "0") && ($tipo != "0") && ($ciudad != "0")) {
                    $productos = common::load_model('shop_model', 'getTipoCiudadBuscador', [$tipo, $ciudad, $offset, $limit]);
                } else if (($categoria != "0") && ($tipo == "0") && ($ciudad != "0")) {
                    $productos = common::load_model('shop_model', 'getCategoriaCiudadBuscador', [$categoria, $ciudad, $offset, $limit]);
                } else if (($categoria != "0") && ($tipo != "0") && ($ciudad != "0")) {
                    $productos = common::load_model('shop_model', 'getAllBuscador', [$categoria, $tipo, $ciudad, $offset, $limit]);
                } else {
                    $productos = common::load_model('shop_model', 'getAll', [$offset, $limit]);
                }

                foreach($productos as &$producto){
                    $id_producto = $producto['id_producto'];
                    $imagenes = common::load_model('shop_model', 'getImgDetails', $id_producto);
                    $producto['imagenes'] = array();
                    foreach($imagenes as $img){
                        $producto['imagenes'][] = $img['pimage_route'];
                    }
                }
                
                echo json_encode($productos);
            } catch (Exception $e) {
                echo json_encode("error");
                exit;
            }
        }

        function details(){
            $id_producto = $_POST['id_producto'];
            $token = $_POST['token'];
            // echo json_encode($id_producto);
            // exit;
            $infProducto = common::load_model('shop_model', 'getDetails', $id_producto);
            // echo json_encode($infProducto);
            // exit;
            $imgProducto = common::load_model('shop_model', 'getImgDetails', $id_producto);
            // echo json_encode($imgProducto);
            // exit;

            if($token != "noToken"){
                $tokenDec = middleware::decode_token($token);
                if($tokenDec['provider'] == "local"){
                    $tokenDec = common::load_model('auth_model', 'getDataUser', $tokenDec['username']);
                }else if($tokenDec['provider'] == "google"){
                    $tokenDec = common::load_model('auth_model', 'getDataUserGoogle', $tokenDec['username']);
                }else if($tokenDec['provider'] == "github"){
                    $tokenDec = common::load_model('auth_model', 'getDataUserGithub', $tokenDec['username']);
                }
            }else{
                $tokenDec = "noToken";
            }

            $comentarios = common::load_model('shop_model', 'getComentarios', $id_producto);

            if (!empty($infProducto) || !empty($imgProducto)) {
                $rdo = array();
                $rdo[0] = $infProducto; // detalles del producto
                $rdo[1][] = $imgProducto; // imagenes del producto
                $rdo[2][] = $tokenDec; // información del usuario logeado
                $rdo[3][] = $comentarios; // comentarios del producto
                echo json_encode($rdo);
                exit;
            } else {
                echo json_encode('error');
                exit;
            }
        }

        function send_comentario(){
            $id_producto = $_POST['id_producto'];
            $token = $_POST['token'];
            $comentario = $_POST['comentario'];
            // echo json_encode($comentario);
            // exit;

            $tokenDec = middleware::decode_token($token);
            if($tokenDec['provider'] == "local"){
                $dataUser = common::load_model('auth_model', 'getDataUser', $tokenDec['username']);
                $userID = $dataUser[0]['id_user'];
                // echo json_encode($userID);
                // exit;
            }else if($tokenDec['provider'] == "google"){
                $dataUser = common::load_model('auth_model', 'getDataUserGoogle', $tokenDec['username']);
                $userID = $dataUser[0]['uid'];
            }else if($tokenDec['provider'] == "github"){
                $dataUser = common::load_model('auth_model', 'getDataUserGithub', $tokenDec['username']);
                $userID = $dataUser[0]['uid'];
            }

            common::load_model('shop_model', 'sendComentario', [$id_producto, $userID, $tokenDec['provider'], $comentario]);
            echo json_encode('ok');
            exit;
        }

        function delete_comentario(){
            $id_comentario = $_POST['id_comentario'];

            $delete = common::load_model('shop_model', 'deleteComentario', $id_comentario);

            if($delete == "ok"){
                echo json_encode("ok");
                exit;
            }else{
                echo json_encode("error");
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

            $productos = common::load_model('shop_model', 'getFiltroHome', $filtro_home);

            foreach ($productos as &$producto){
                $id_producto = $producto['id_producto'];
                $imagenes = common::load_model('shop_model', 'getImgDetails', $id_producto);
                $producto['imagenes'] = array();
                foreach($imagenes as $img){
                    $producto['imagenes'][] = $img['pimage_route'];
                }
            }

            echo json_encode($productos);

        }

    } // ctrl_home

?>