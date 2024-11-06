-- CREAMOS LA BASE DE DATOS
CREATE DATABASE db_restaurante;

-- USAMOS LA BASE DE DATOS
USE db_restaurante;

-- CREMOS LA TABLA USUARIOS
CREATE TABLE Usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre_completo VARCHAR(200) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('camarero', 'manager') NOT NULL
);

CREATE TABLE Salas (
    id_sala INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    capacidad INT NOT NULL
);

CREATE TABLE Mesas (
    id_mesa INT PRIMARY KEY AUTO_INCREMENT,
    id_sala INT,
    capacidad INT NOT NULL,
    estado ENUM('libre', 'ocupada') DEFAULT 'libre',
    FOREIGN KEY (id_sala) REFERENCES Salas(id_sala)
);

CREATE TABLE Ocupaciones (
    id_ocupacion INT PRIMARY KEY AUTO_INCREMENT,
    id_mesa INT,
    id_usuario INT,
    fecha_ocupacion DATETIME NOT NULL,
    fecha_libera DATETIME,
    FOREIGN KEY (id_mesa) REFERENCES Mesas(id_mesa),
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

-- INSERT TABLA USUARIOS CON CONTRASEÑAS HASHEADAS
INSERT INTO Usuarios (nombre_completo, contraseña, tipo_usuario) VALUES
('Aina Orozco', '$2a$12$zxGWHLfK1Ss0qIh9xD960ONgZ98PO.YAMAO2zYEfQYIF/fl0AWTVG', 'manager'),
('David Alvarez', '$2a$12$zxGWHLfK1Ss0qIh9xD960ONgZ98PO.YAMAO2zYEfQYIF/fl0AWTVG', 'camarero'),
('Deiby Buenaño', '$2a$12$zxGWHLfK1Ss0qIh9xD960ONgZ98PO.YAMAO2zYEfQYIF/fl0AWTVG', 'camarero'),
('Pol Marc Monter', '$2a$12$zxGWHLfK1Ss0qIh9xD960ONgZ98PO.YAMAO2zYEfQYIF/fl0AWTVG', 'manager');

-- INSERT TABLA SALAS
INSERT INTO Salas (nombre, capacidad) VALUES
('Terraza 1', 24),
('Terraza 2', 20),
('Terraza 3', 20),
('Comedor 1', 50),
('Comedor 2', 50),
('Sala Privada 1', 10),
('Sala Privada 2', 10),
('Sala Privada 3', 10),
('Sala Privada 4', 10);

-- INSERT TABLA MESAS
INSERT INTO Mesas (id_sala, numero, capacidad) VALUES
(1, 1, 4),
(1, 2, 4),
(2, 1, 4),
(3, 1, 4),
(4, 1, 6),
(4, 2, 6),
(5, 1, 4),
(6, 1, 2),
(7, 1, 2),
(8, 1, 2);




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
  `estado` VARCHAR(45) NULL,
  `Mesascol` ENUM('libre', 'ocupada') NULL DEFAULT 'libre',
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
