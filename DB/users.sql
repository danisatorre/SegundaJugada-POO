-- USUARIOS

DROP TABLE IF EXISTS users;

CREATE TABLE `users`(
    `id_user` int(20) UNSIGNED NOT NULL,
    `username` varchar(50) NOT NULL,
    `pwd` varchar(50) NOT NULL,
    `email` varchar(50) NOT NULL,
    `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users`(`id_user`, `username`, `pwd`, `email`, `avatar`) VALUES
(1, 'user1', 'user1pwd', 'user1@gmail.com', 'img1.jpg'),
(2, 'user2', 'user2pwd', 'user2@gmail.com', 'img2.jpg'),
(3, 'user3', 'user3pwd', 'user3@gmail.com', 'img3.jpg'),
(4, 'user4', 'user4pwd', 'user4@gmail.com', 'img4.jpg'),
(5, 'user5', 'user5pwd', 'user5@gmail.com', 'img5.jpg');

-- FAVORITOS

DROP TABLE IF EXISTS favoritos;

CREATE TABLE `favoritos`(
    `id_fav` int(20) UNSIGNED NOT NULL,
    `user_fav` int(20) UNSIGNED NOT NULL,
    `producto_fav` int(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `favoritos`(`id_fav`, `user_fav`, `producto_fav`) VALUES
(1, 1, 1),
(2, 4, 2),
(3, 2, 3),
(4, 3, 4),
(5, 1, 5);

-- COMPRAS

DROP TABLE IF EXISTS compras;

CREATE TABLE `compras`(
    `id_compra` int(20) UNSIGNED NOT NULL,
    `user_compra` int(20) UNSIGNED NOT NULL,
    `producto_compra` int(20) UNSIGNED NOT NULL,
    `fecha_compra` varchar(10) NOT NULL,
    `unidades` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO `compras`(`id_compra`, `user_compra`, `producto_compra`, `fecha_compra`, `unidades`) VALUES
(1, 1, 1, '01/01/2021', 1),
(2, 5, 2, '01/01/2021', 1),
(3, 2, 3, '01/01/2021', 1),
(4, 3, 4, '01/01/2021', 1),
(5, 5, 5, '01/01/2021', 1);

-- CARRITO

DROP TABLE IF EXISTS carrito;

CREATE TABLE `carrito`(
    `id_carrito` int(20) UNSIGNED NOT NULL,
    `user_carrito` int(20) UNSIGNED NOT NULL,
    `producto_carrito` int(20) UNSIGNED NOT NULL,
    `cantidad_carrito` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `carrito` (`id_carrito`, `user_carrito`, `producto_carrito`, `cantidad_carrito`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 3, 3, 4),
(4, 4, 4, 2),
(5, 5, 5, 1);

-- PAGOS

DROP TABLE IF EXISTS pagos;

CREATE TABLE `pagos`(
    `id_pago` int(20) UNSIGNED NOT NULL,
    `metodo_pago` int(20) UNSIGNED NOT NULL,
    `producto_pago` int(20) UNSIGNED NOT NULL,
    `user_pago` int(20) UNSIGNED NOT NULL,
    `fecha_pago` varchar(10) NOT NULL,
    `coste` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pagos` (`id_pago`, `metodo_pago`, `producto_pago`, `user_pago`, `fecha_pago`, `coste`) VALUES
(1, 1, 1, 1, '12/12/2024', 10),
(2, 2, 2, 2, '12/12/2024', 20),
(3, 3, 3, 3, '12/12/2024', 30),
(4, 4, 4, 4, '12/12/2024', 40),
(5, 5, 5, 5, '12/12/2024', 50);

-- CHAT

DROP TABLE IF EXISTS chats;

CREATE TABLE `chats`(
    `id_chat` int(20) UNSIGNED NOT NULL,
    `cliente_chat` int(20) UNSIGNED NOT NULL,
    `vendedor_chat` int(20) UNSIGNED NOT NULL,
    `producto_chat` int(20) UNSIGNED NOT NULL,
    `mensaje` varchar(255) NOT NULL,
    `fecha_msg` varchar(10) NOT NULL,
    `hora_msg` varchar(5) NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `chats` (`id_chat`, `cliente_chat`, `vendedor_chat`, `producto_chat`, `mensaje`, `fecha_msg`, `hora_msg`) VALUES
(1, 1, 5, 1, 'mensaje1', '03/02/2025', '12:38'),
(2, 2, 3, 2, 'mensaje2', '03/02/2025', '12:38'),
(3, 3, 4, 3, 'mensaje3', '01/02/2025', '12:38'),
(4, 4, 2, 4, 'mensaje4', '09/01/2025', '12:38'),
(5, 5, 1, 5, 'mensaje5', '12/11/2024', '12:38');

-- ALTER TABLES

-- PRIMARY KEYS

-- USERS

ALTER TABLE `users`
    ADD PRIMARY KEY (`id_user`);

-- FAVORITOS

ALTER TABLE `favoritos`
    ADD PRIMARY KEY (`id_fav`);

-- COMPRAS

ALTER TABLE `compras`
    ADD PRIMARY KEY (`id_compra`);

-- CARRITO

ALTER TABLE `carrito`
    ADD PRIMARY KEY (`id_carrito`);

-- PAGOS

ALTER TABLE `pagos`
    ADD PRIMARY KEY (`id_pago`);

-- CHATS

ALTER TABLE `chats`
    ADD PRIMARY KEY (`id_chat`);

--
-- ID's AUTOINCREMENTALES
--

-- USERS

ALTER TABLE `users`
    MODIFY `id_user` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

-- FAVORITOS

ALTER TABLE `favoritos`
    MODIFY `id_fav` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

-- COMPRAS

ALTER TABLE `compras`
    MODIFY `id_compra` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400;

-- CARRITO

ALTER TABLE `carrito`
    MODIFY `id_carrito` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500;

-- PAGOS

ALTER TABLE `pagos`
    MODIFY `id_pago` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1400;

-- CHATS

ALTER TABLE `chats`
    MODIFY `id_chat` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1600;

--
-- CLAVES AJENAS
--

-- FAVORITOS

ALTER TABLE `favoritos`
    ADD CONSTRAINT `FK_user_fav` FOREIGN KEY (`user_fav`) REFERENCES `users` (`id_user`),
    ADD CONSTRAINT `FK_producto_fav` FOREIGN KEY (`producto_fav`) REFERENCES `productos` (`id_producto`);

-- COMPRAS

ALTER TABLE `compras`
    ADD CONSTRAINT `FK_user_compra` FOREIGN KEY (`user_compra`) REFERENCES `users` (`id_user`),
    ADD CONSTRAINT `FK_producto_compra` FOREIGN KEY (`producto_compra`) REFERENCES `productos` (`id_producto`);

-- CARRITO

ALTER TABLE `carrito`
    ADD CONSTRAINT `FK_user_carrito` FOREIGN KEY (`user_carrito`) REFERENCES `users` (`id_user`),
    ADD CONSTRAINT `FK_producto_carrito` FOREIGN KEY (`producto_carrito`) REFERENCES `productos` (`id_producto`);

-- PAGOS

ALTER TABLE `pagos`
    ADD CONSTRAINT `FK_metodo_pago` FOREIGN KEY (`metodo_pago`) REFERENCES `metodos_pago` (`id_metodo`),
    ADD CONSTRAINT `FK_producto_pago` FOREIGN KEY (`producto_pago`) REFERENCES `productos` (`id_producto`),
    ADD CONSTRAINT `FK_user_pago` FOREIGN KEY (`user_pago`) REFERENCES `users` (`id_user`);

-- CHATS

ALTER TABLE `chats`
    ADD CONSTRAINT `FK_cliente_chat` FOREIGN KEY (`cliente_chat`) REFERENCES `users` (`id_user`),
    ADD CONSTRAINT `FK_vendedor_chat` FOREIGN KEY (`vendedor_chat`) REFERENCES `users` (`id_user`),
    ADD CONSTRAINT `FK_producto_chat` FOREIGN KEY (`producto_chat`) REFERENCES `productos` (`id_producto`);