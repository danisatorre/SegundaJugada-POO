<?php

    // ACTIVIDAD DEL USUARIO
    if(isset($_SESSION['tiempo'])){
        $_SESSION['tiempo'] = time(); // devuelve la fecha actual
    }

    class ctrl_search{

        function categoria(){
            echo json_encode(common::load_model('search_model', 'getCategorias'));
        }

        function tipo(){
            // echo json_encode('hola tipo ctrl_search.class.php');
            // exit;
            echo json_encode(common::load_model('search_model', 'getTipos'));
        }

        function autocompletar(){
            $tipo_producto = $_POST['tipo_producto'];
            // echo json_encode($tipo_producto);
            // exit;
            $categoria_producto = $_POST['categoria_producto'];
            // echo json_encode($categoria_producto);
            // return false;
            $completar = $_POST['completar'];
            // echo json_encode($completar);
            // exit;
            // echo json_encode('hola autocompletar ctrl_search.class.php');
            // return false;
            
            try {
                if ($tipo_producto !== '0' && $categoria_producto === '0') {
                    $select_autocompletar = common::load_model('search_model', 'getCiudadTipo', [$completar, $tipo_producto]);
                } else if ($tipo_producto !== '0' && $categoria_producto !== '0') {
                    $select_autocompletar = common::load_model('search_model', 'getCiudadTipoCategoria', [$completar, $tipo_producto, $categoria_producto]);
                } else if ($tipo_producto === '0' && $categoria_producto !== '0') {
                    $select_autocompletar = common::load_model('search_model', 'getCiudadCategoria', [$completar, $categoria_producto]);
                } else {
                    $select_autocompletar = common::load_model('search_model', 'getCiudad', $completar);
                }
            } catch (Exception $e) {
                echo json_encode("error");
                exit;
            }

            if(!empty($select_autocompletar)){
                echo json_encode($select_autocompletar);
            }else{
                echo json_encode('error');
            }
        }

    } // ctrl_search

?>