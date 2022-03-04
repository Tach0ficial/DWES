CREATE TABLE IF NOT EXISTS `contactos_contactos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` varchar(10) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT pk_contactos PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `contactos_usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
	CONSTRAINT pk_usuarios PRIMARY KEY (`id`)
);

INSERT INTO `contactos_contactos` (`nombre`, `telefono`, `email`, `created_at`, `updated_at`) VALUES
	('jesus', '678016370', 'jesus20.11@hotmail.es', '2022-02-02 21:47:52', '2022-02-02 21:47:53');
	
INSERT INTO `contactos_usuarios` (`id`, `usuario`, `password`) VALUES (1, 'admin', 'admin');

CREATE TRIGGER `update_updated_at` BEFORE UPDATE ON `contactos_contactos` FOR EACH ROW SET NEW.updated_at = CURRENT_TIMESTAMP;

