DROP TABLE IF EXISTS likes;

CREATE TABLE `likes` (
  `id_like` INT(11) NOT NULL AUTO_INCREMENT,
  `id_user_like` INT(20) UNSIGNED NOT NULL,
  `id_producto_like` INT(20) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_like`),
  KEY `id_producto_like` (`id_producto_like`),
  KEY `id_user_like` (`id_user_like`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=3000;

ALTER TABLE `likes`
  ADD CONSTRAINT `likes_producto` FOREIGN KEY (`id_producto_like`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `likes_user` FOREIGN KEY (`id_user_like`) REFERENCES `users` (`id_user`);
