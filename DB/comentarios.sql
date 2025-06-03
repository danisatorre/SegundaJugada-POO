CREATE TABLE comentarios (
  id_comentario INT UNSIGNED NOT NULL AUTO_INCREMENT,
  
  id_user_local INT UNSIGNED DEFAULT NULL,
  id_user_google VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci DEFAULT NULL,
  id_user_github VARCHAR(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci DEFAULT NULL,

  id_producto_comentario INT(20) UNSIGNED NOT NULL,

  comentario VARCHAR(250) NOT NULL,

  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (id_comentario),

  CONSTRAINT fk_comentarios_local FOREIGN KEY (id_user_local)
    REFERENCES users(id_user) 
    ON DELETE SET NULL ON UPDATE CASCADE,

  CONSTRAINT fk_comentarios_google FOREIGN KEY (id_user_google)
    REFERENCES google_users(uid)
    ON DELETE SET NULL ON UPDATE CASCADE,

  CONSTRAINT fk_comentarios_github FOREIGN KEY (id_user_github)
    REFERENCES github_users(uid)
    ON DELETE SET NULL ON UPDATE CASCADE,

  CONSTRAINT fk_comentarios_producto FOREIGN KEY (id_producto_comentario)
    REFERENCES productos(id_producto)
    ON DELETE CASCADE ON UPDATE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;