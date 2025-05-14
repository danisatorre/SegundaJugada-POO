<?php
    class common {
        public static function load_error() {
            // echo 'hola load_error';
            // exit;
            require_once (VIEW_PATH_INC . 'top_page.html');
            require_once (VIEW_PATH_INC . 'menu.html');
            require_once (VIEW_PATH_INC . 'error404.html');
            require_once (VIEW_PATH_INC . 'footer.html');
        }
        
        public static function load_view($topPage, $view) {
            // echo 'load_view';
            // exit;
            $topPageOriginal = $topPage;
            $topPage = VIEW_PATH_INC . $topPage;
            // echo $topPage;
            // echo $view;
            // echo $topPageOriginal;
            // exit;
            if ((file_exists($topPage)) && (file_exists($view))) {
                // echo 'hola file exists $topPage & $view';
                // exit;
                require_once ($topPage);
                // echo VIEW_PATH_INC . 'header.html';
                // exit;
                // echo VIEW_PATH_INC . 'menu.html';
                // exit;
                require_once (VIEW_PATH_INC . 'menu.html');
                // echo VIEW_PATH_INC . 'menu.html';
                // exit;
                if($topPageOriginal != "top_page_auth.html"){ // no mostrar el buscador en el modulo de auth
                    require_once (VIEW_PATH_INC . 'header.html');
                }
                require_once ($view);
                require_once (VIEW_PATH_INC . 'footer.html');
                // echo 'hola despues require_once';
                // exit;
            }else {
                self::load_error();
            }
        }
        
        public static function load_model($model, $function = null, $args = null) {
            // echo 'hola load_model';
            // exit;
            // echo json_encode('hola load_model common.inc.php');
            // exit;
            $dir = explode('_', $model);
            $path = constant('MODEL_' . strtoupper($dir[0])) .  $model . '.class.singleton.php';
            // echo json_encode($path);
            // exit;
            if (file_exists($path)) {
                // echo json_encode('file exists load_model common.inc');
                // echo json_encode($model);
                // echo json_encode($function);
                // exit;
                // var_dump($path);
                // var_dump(file_exists($path));
                require_once ($path);
                // var_dump(class_exists('shop_bll'));
                // exit;
                if (method_exists($model, $function)) {
                    // echo json_encode('method exists load_model common.inc');
                    // exit;
                    $obj = $model::getInstance();
                    if ($args != null) {
                        return call_user_func(array($obj, $function), $args);
                    }
                    return call_user_func(array($obj, $function));
                }
            }
            throw new Exception();
        }

        public static function generate_token_secure($longitud){
            echo 'hola generate_token_secure';
            exit;
            if ($longitud < 4) {
                $longitud = 4;
            }
            return bin2hex(openssl_random_pseudo_bytes(($longitud - ($longitud % 2)) / 2));
        }

        function friendlyURL_php($url) {
            // echo 'hola friendlyURL_php';
            // exit;
            $link = "";
            if (URL_FRIENDLY) {
                $url = explode("&", str_replace("?", "", $url));
                foreach ($url as $key => $value) {
                    $aux = explode("=", $value);
                    $link .=  $aux[1]."/";
                }
            } else {
                $link = "index.php?" . $url;
            }
            return SITE_PATH . $link;
        }
    } // common
?>