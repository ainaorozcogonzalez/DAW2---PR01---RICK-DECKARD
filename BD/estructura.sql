CREATE SCHEMA `db_restaurante` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE db_restaurante;

CREATE TABLE `db_restaurante`.`usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `nombre_completo` VARCHAR(200) NOT NULL,
  `contraseña` VARCHAR(255) NOT NULL,
  `tipo_usuario` ENUM('camarero', 'manager') NOT NULL,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


CREATE TABLE `db_restaurante`.`salas` (
  `id_sala` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `capacidad` INT NOT NULL,
  PRIMARY KEY (`id_sala`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;



CREATE TABLE `db_restaurante`.`mesas` (
  `id_mesa` INT NOT NULL AUTO_INCREMENT,
  `capacidad` INT NOT NULL,
  `estado` ENUM('libre', 'ocupada') NULL DEFAULT 'libre',
  `id_sala` INT NULL,
  PRIMARY KEY (`id_mesa`),
  INDEX `id_sala_idx` (`id_sala` ASC) VISIBLE,
  CONSTRAINT `id_sala`
    FOREIGN KEY (`id_sala`)
    REFERENCES `db_restaurante`.`salas` (`id_sala`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


CREATE TABLE `db_restaurante`.`ocupaciones` (
  `id_ocupacion` INT NOT NULL AUTO_INCREMENT,
  `id_mesa` INT NULL,
  `id_usuario` INT NULL,
  `sillas` INT NULL,
  `fecha_ocupacion` DATETIME NOT NULL,
  `fecha_libera` DATETIME NULL,
  PRIMARY KEY (`id_ocupacion`),
  INDEX `id_mesa_idx` (`id_mesa` ASC) VISIBLE,
  INDEX `id_usuario_idx` (`id_usuario` ASC) VISIBLE,
  CONSTRAINT `id_mesa`
    FOREIGN KEY (`id_mesa`)
    REFERENCES `db_restaurante`.`mesas` (`id_mesa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `id_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `db_restaurante`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- INSERT TABLA USUARIOS CON CONTRASEÑAS HASHEADAS
INSERT INTO Usuarios (nombre_completo, contraseña, tipo_usuario) VALUES
('Aina Orozco', '$2a$12$zxGWHLfK1Ss0qIh9xD960ONgZ98PO.YAMAO2zYEfQYIF/fl0AWTVG', 'manager'),
('David Alvarez', '$2a$12$zxGWHLfK1Ss0qIh9xD960ONgZ98PO.YAMAO2zYEfQYIF/fl0AWTVG', 'camarero'),
('Deiby Buenano', '$2a$12$zxGWHLfK1Ss0qIh9xD960ONgZ98PO.YAMAO2zYEfQYIF/fl0AWTVG', 'camarero'),
('Pol Marc Monter', '$2a$12$zxGWHLfK1Ss0qIh9xD960ONgZ98PO.YAMAO2zYEfQYIF/fl0AWTVG', 'manager');

-- INSERT TABLA SALAS
INSERT INTO Salas (nombre, capacidad) VALUES
('Terraza 1', 24),
('Terraza 2', 54),
('Terraza 3', 36),
('Comedor 1', 54),
('Comedor 2', 24),
('Sala Privada 1', 36),
('Sala Privada 2', 24),
('Sala Privada 3', 54),
('Sala Privada 4', 6);

-- INSERT TABLA MESAS
INSERT INTO Mesas (id_sala, capacidad) VALUES
(1, 6),
(1, 6),
(1, 6),
(1, 6),
(2, 6),
(2, 6),
(2, 6),
(2, 6),
(2, 6),
(2, 6),
(2, 6),
(2, 6),
(2, 6),
(3, 6),
(3, 6),
(3, 6),
(3, 6),
(3, 6),
(3, 6),
(4, 6),
(4, 6),
(4, 6),
(4, 6),
(4, 6),
(4, 6),
(4, 6),
(4, 6),
(4, 6),
(5, 6),
(5, 6),
(5, 6),
(5, 6),
(6, 6),
(6, 6),
(6, 6),
(6, 6),
(6, 6),
(6, 6),
(7, 6),
(7, 6),
(7, 6),
(7, 6),
(8, 6),
(8, 6),
(8, 6),
(8, 6),
(8, 6),
(8, 6),
(8, 6),
(8, 6),
(8, 6),
(9, 6);