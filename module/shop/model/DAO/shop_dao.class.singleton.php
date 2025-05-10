<?php

    class shop_dao{
        
        static $_instance;

        private function __construct(){
            
        }

        public static function getInstance(){
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        } // getInstance

        public function select_all($db, $offset, $limit){
            $sql= "SELECT * FROM productos ORDER BY nom_prod DESC LIMIT $offset, $limit";
            
            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_filtrar($db, $filtro, $offset, $limit){
            $sql = "SELECT *
			FROM productos p
			LEFT JOIN marcas m ON p.marca = m.id_marca
			LEFT JOIN teams t ON p.equipo = t.id_team
			LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
			LEFT JOIN categorias c ON p.categoria = c.id_categoria";
			
			$primeraCondicion = true;
			$primeraCondicionOredrBy = true;
			$orderby = "";

				for ($i=0; $i < count($filtro); $i++){
					if ($filtro[$i][0] == 'equipo' && is_array($filtro[$i][1])) {
						if ($primeraCondicion) {
							$sql .= " WHERE (";
							$primeraCondicion = false;
						} else {
							$sql .= " AND (";
						}
						for ($j = 0; $j < count($filtro[$i][1]); $j++) {
							if ($j > 0) {
								$sql .= " OR ";
							}
							$sql .= "p.equipo = '" . $filtro[$i][1][$j] . "'";
						}
						$sql .= ")";
					}else if($filtro[$i][0] == 'precio'){
						if($filtro[$i][1] == "menmay"){
							$orderby = " ORDER BY p.precio ASC";
						}else if($filtro[$i][1] == "maymen"){
							$orderby = " ORDER BY p.precio DESC";
						}
					}else if($filtro[$i][0] == 'visitas'){
						if($filtro[$i][1] == "menmay"){
							$orderby = " ORDER BY p.visitas ASC";
						}else if($filtro[$i][1] == "maymen"){
							$orderby = " ORDER BY p.visitas DESC";
						}
					}else {
						if($primeraCondicion){
							$sql .= " WHERE p." . $filtro[$i][0] . " = '" . $filtro[$i][1] . "'";
                			$primeraCondicion = false;
						}else{
							$sql .= " AND p." . $filtro[$i][0] . " = '" . $filtro[$i][1] . "'";
						}
					} // end if-else
				} // end for

			$sql .= $orderby; // añadir el 'ORDER BY' siempre al final de la consulta
			$sql .= " LIMIT $offset, $limit"; // añadir la paginacion

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_equipos($db){
            $sql ="SELECT * FROM teams";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_count_productos_filtros($db, $filtro){
            $sql = "SELECT COUNT(*) contador
			FROM productos p
			LEFT JOIN marcas m ON p.marca = m.id_marca
			LEFT JOIN teams t ON p.equipo = t.id_team
			LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
			LEFT JOIN categorias c ON p.categoria = c.id_categoria";
			
			$primeraCondicion = true;
			$primeraCondicionOredrBy = true;
			$orderby = "";

				for ($i=0; $i < count($filtro); $i++){
					if ($filtro[$i][0] == 'equipo' && is_array($filtro[$i][1])) {
						if ($primeraCondicion) {
							$sql .= " WHERE (";
							$primeraCondicion = false;
						} else {
							$sql .= " AND (";
						}
						for ($j = 0; $j < count($filtro[$i][1]); $j++) {
							if ($j > 0) {
								$sql .= " OR ";
							}
							$sql .= "p.equipo = '" . $filtro[$i][1][$j] . "'";
						}
						$sql .= ")";
					}else if($filtro[$i][0] == 'precio'){
						if($filtro[$i][1] == "menmay"){
							$orderby = " ORDER BY p.precio ASC";
						}else if($filtro[$i][1] == "maymen"){
							$orderby = " ORDER BY p.precio DESC";
						}
					}else if($filtro[$i][0] == 'visitas'){
						if($filtro[$i][1] == "menmay"){
							$orderby = " ORDER BY p.visitas ASC";
						}else if($filtro[$i][1] == "maymen"){
							$orderby = " ORDER BY p.visitas DESC";
						}
					}else {
						if($primeraCondicion){
							$sql .= " WHERE p." . $filtro[$i][0] . " = '" . $filtro[$i][1] . "'";
                			$primeraCondicion = false;
						}else{
							$sql .= " AND p." . $filtro[$i][0] . " = '" . $filtro[$i][1] . "'";
						}
					} // end if-else
				} // end for

			$sql .= $orderby; // añadir el 'ORDER BY' siempre al final de la consulta

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_count_buscador($db, $ciudad, $tipo, $categoria){
            $sql = "SELECT COUNT(*) contador
			FROM productos p
			LEFT JOIN marcas m ON p.marca = m.id_marca
			LEFT JOIN teams t ON p.equipo = t.id_team
			LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
			LEFT JOIN categorias c ON p.categoria = c.id_categoria";

			$primeraCondicion = true;

			if($categoria != 0){
				if($primeraCondicion){
					$sql .= " WHERE c.id_categoria = '$categoria'";
					$primeraCondicion = false;
				}else{
					$sql .= " AND c.id_categoria = '$categoria'";
				}
			}

			if($tipo != 0){
				if($primeraCondicion){
					$sql .= " WHERE ti.id_tipo = '$tipo'";
					$primeraCondicion = false;
				}else{
					$sql .= " AND ti.id_tipo = '$tipo'";
				}
			}

			if($ciudad != 0){
				if($primeraCondicion){
					$sql .= " WHERE p.ciudad = '$ciudad'";
					$primeraCondicion = false;
				}else{
					$sql .= " AND p.ciudad = '$ciudad'";
				}
			}

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

        public function select_count_all($db){
            $sql= "SELECT COUNT(*) contador FROM productos ORDER BY nom_prod DESC";

            $stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
        }

    } // shop_dao

?>