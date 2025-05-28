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

		public function select_load_likes_user($db, $username){
			$sql = "SELECT l.id_producto_like
			FROM likes l
			WHERE l.id_user_like = (SELECT u.id_user
							FROM users u
							WHERE u.username = '$username')";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_load_likes_user_google($db, $username){
			$sql = "SELECT l.id_producto_like
			FROM likes l
			WHERE l.id_user_like_google = (SELECT u.uid
							FROM google_users u
							WHERE u.username = '$username')";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_load_likes_user_github($db, $username){
			$sql = "SELECT l.id_producto_like
			FROM likes l
			WHERE l.id_user_like_github = (SELECT u.uid
							FROM github_users u
							WHERE u.username = '$username')";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_likes($db, $id_producto, $username){
			$sql = "SELECT l.id_producto_like
			FROM likes l
			WHERE l.id_user_like = (SELECT u.id_user
							FROM users u
							WHERE u.username = '$username')
			AND l.id_producto_like = '$id_producto'";

			// echo json_encode($sql);
			// exit;

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_likes_google($db, $id_producto, $username){
			$sql = "SELECT l.id_producto_like
			FROM likes l
			WHERE l.id_user_like_google = (SELECT u.uid
							FROM google_users u
							WHERE u.username = '$username')
			AND l.id_producto_like = '$id_producto'";

			// echo json_encode($sql);
			// exit;

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_likes_github($db, $id_producto, $username){
			$sql = "SELECT l.id_producto_like
			FROM likes l
			WHERE l.id_user_like_github = (SELECT u.uid
							FROM github_users u
							WHERE u.username = '$username')
			AND l.id_producto_like = '$id_producto'";

			// echo json_encode($sql);
			// exit;

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function set_like_user($db, $id_producto, $username){
			$sql = "INSERT INTO likes (id_user_like, id_producto_like) VALUES ((SELECT u.id_user FROM users u WHERE u.username = '$username'), '$id_producto');";

			$stmt = $db -> ejecutar($sql);
		}

		public function set_like_user_google($db, $id_producto, $username){
			$sql = "INSERT INTO likes (id_user_like_google, id_producto_like) VALUES ((SELECT u.uid FROM google_users u WHERE u.username = '$username'), '$id_producto');";

			$stmt = $db -> ejecutar($sql);
		}

		public function set_like_user_github($db, $id_producto, $username){
			$sql = "INSERT INTO likes (id_user_like_github, id_producto_like) VALUES ((SELECT u.uid FROM github_users u WHERE u.username = '$username'), '$id_producto');";

			$stmt = $db -> ejecutar($sql);
		}

		public function set_like_producto($db, $id_producto){
			$sql = "UPDATE productos p
			SET p.likes = p.likes +1
			WHERE p.id_producto = $id_producto";

			$stmt = $db -> ejecutar($sql);
		}

		public function set_dislike_user($db, $id_producto, $username){
			$sql = "DELETE l FROM likes l
			JOIN users u ON l.id_user_like = u.id_user
			WHERE l.id_producto_like = '$id_producto'
			AND u.username = '$username';";

			$stmt = $db -> ejecutar($sql);
		}

		public function set_dislike_user_google($db, $id_producto, $username){
			$sql = "DELETE l FROM likes l
			JOIN google_users u ON l.id_user_like_google = u.uid
			WHERE l.id_producto_like = '$id_producto'
			AND u.username = '$username';";

			$stmt = $db -> ejecutar($sql);
		}

		public function set_dislike_user_github($db, $id_producto, $username){
			$sql = "DELETE l FROM likes l
			JOIN github_users u ON l.id_user_like_github = u.uid
			WHERE l.id_producto_like = '$id_producto'
			AND u.username = '$username';";

			$stmt = $db -> ejecutar($sql);
		}

		public function set_dislike_producto($db, $id_producto){
			$sql = "UPDATE productos p
			SET p.likes = p.likes -1
			WHERE p.id_producto = $id_producto";

			$stmt = $db -> ejecutar($sql);
		}

		public function select_categoria_buscador($db, $categoria, $offset, $limit){
			$sql = "SELECT *
			FROM productos p
			LEFT JOIN marcas m ON p.marca = m.id_marca
			LEFT JOIN teams t ON p.equipo = t.id_team
			LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
			LEFT JOIN categorias c ON p.categoria = c.id_categoria
			WHERE c.id_categoria = '$categoria'
			LIMIT $offset, $limit";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_tipo_buscador($db, $tipo, $offset, $limit){
			$sql = "SELECT *
			FROM productos p
			LEFT JOIN marcas m ON p.marca = m.id_marca
			LEFT JOIN teams t ON p.equipo = t.id_team
			LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
			LEFT JOIN categorias c ON p.categoria = c.id_categoria
			WHERE ti.id_tipo = '$tipo'
			LIMIT $offset, $limit";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_ciudad_buscador($db, $ciudad, $offset, $limit){
			$sql = "SELECT *
			FROM productos p
			LEFT JOIN marcas m ON p.marca = m.id_marca
			LEFT JOIN teams t ON p.equipo = t.id_team
			LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
			LEFT JOIN categorias c ON p.categoria = c.id_categoria
			WHERE p.ciudad = '$ciudad'
			LIMIT $offset, $limit";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_categoria_tipo_buscador($db, $categoria, $tipo, $offset, $limit){
			$sql = "SELECT *
			FROM productos p
			LEFT JOIN marcas m ON p.marca = m.id_marca
			LEFT JOIN teams t ON p.equipo = t.id_team
			LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
			LEFT JOIN categorias c ON p.categoria = c.id_categoria
			WHERE c.id_categoria = '$categoria'
			AND ti.id_tipo = '$tipo'
			LIMIT $offset, $limit";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_tipo_ciudad_buscador($db, $tipo, $ciudad, $offset, $limit){
			$sql = "SELECT *
			FROM productos p
			LEFT JOIN marcas m ON p.marca = m.id_marca
			LEFT JOIN teams t ON p.equipo = t.id_team
			LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
			LEFT JOIN categorias c ON p.categoria = c.id_categoria
			WHERE p.ciudad = '$ciudad'
			AND ti.id_tipo = '$tipo'
			LIMIT $offset, $limit";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_categoria_ciudad_buscador($db, $categoria, $ciudad, $offset, $limit){
			$sql = "SELECT *
			FROM productos p
			LEFT JOIN marcas m ON p.marca = m.id_marca
			LEFT JOIN teams t ON p.equipo = t.id_team
			LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
			LEFT JOIN categorias c ON p.categoria = c.id_categoria
			WHERE p.ciudad = '$ciudad'
			AND c.id_categoria = '$categoria'
			LIMIT $offset, $limit";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_get_all_buscador($db, $categoria, $tipo, $ciudad, $offset, $limit){
			$sql = "SELECT *
			FROM productos p
			LEFT JOIN marcas m ON p.marca = m.id_marca
			LEFT JOIN teams t ON p.equipo = t.id_team
			LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
			LEFT JOIN categorias c ON p.categoria = c.id_categoria
			WHERE p.ciudad = '$ciudad'
			AND c.id_categoria = '$categoria'
			AND ti.id_tipo = '$tipo'
			LIMIT $offset, $limit";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_details($db, $id_producto){
			// echo json_encode($id_producto);
			// exit;
			$sql="SELECT *
			FROM productos p
			LEFT JOIN marcas m ON p.marca = m.id_marca
			LEFT JOIN teams t ON p.equipo = t.id_team
			LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
			LEFT JOIN categorias c ON p.categoria = c.id_categoria
			LEFT JOIN users u ON p.id_vendedor = u.id_user
			WHERE p.id_producto = $id_producto";

			// echo json_encode($sql);
			// exit;

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_img_details($db, $id_producto){
			$sql="SELECT pi.pimage_producto, pi.pimage_route
				FROM producto_img pi
				WHERE pi.pimage_producto = '$id_producto'";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_count_productos_relacionados($db, $tipo, $id_producto){
			$sql = "SELECT COUNT(*) contador
			FROM productos p 
			WHERE p.tipo = '$tipo'
			AND p.id_producto <> $id_producto";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function select_productos_relacionados($db, $tipo, $loaded, $items, $id_producto){
			$sql = "SELECT * 
				FROM productos p
				LEFT JOIN marcas m ON p.marca = m.id_marca
				LEFT JOIN teams t ON p.equipo = t.id_team
				LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
				LEFT JOIN categorias c ON p.categoria = c.id_categoria
				WHERE p.tipo = '$tipo'
				AND p.id_producto <> $id_producto
				LIMIT $loaded, $items";
			
			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

		public function sumar_visitas($db, $id_producto){
			$sql = "UPDATE productos p
			SET p.visitas = p.visitas + 1
			WHERE id_producto = $id_producto";

			$stmt = $db -> ejecutar($sql);
		}

		public function update_rating($db, $id_producto, $rating){
			$sql = "UPDATE productos p
			SET p.rating = $rating
			WHERE id_producto = $id_producto";

			$stmt = $db -> ejecutar($sql);
		}

		public function update_visitas_categoria($db, $id_categoria){
			$sql = "UPDATE categorias c
			SET c.visitas_cat = c.visitas_cat + 1
			WHERE id_categoria = $id_categoria";

			$stmt = $db -> ejecutar($sql);
		}

		public function update_visitas_tipo($db, $id_tipo){
			$sql = "UPDATE tipo t
			SET t.visitas_tipo = t.visitas_tipo + 1
			WHERE id_tipo = $id_tipo";

			$stmt = $db -> ejecutar($sql);
		}
		
		public function filtro_home($db, $filtro_home){
			$sql = "SELECT *
			FROM productos p
			LEFT JOIN marcas m ON p.marca = m.id_marca
			LEFT JOIN teams t ON p.equipo = t.id_team
			LEFT JOIN tipo ti ON p.tipo = ti.id_tipo
			LEFT JOIN categorias c ON p.categoria = c.id_categoria
			WHERE $filtro_home";

			$stmt = $db -> ejecutar($sql);
            return $db -> listar($stmt);
		}

    } // shop_dao

?>