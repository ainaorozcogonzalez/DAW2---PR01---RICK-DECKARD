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
    numero INT NOT NULL,
    capacidad INT NOT NULL,
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

-- INSERT TABLA USUARIOS
INSERT INTO Usuarios (nombre_completo, contraseña, tipo_usuario) VALUES
('Aina Orozco', 'qweQWE123', 'manager'),
('David Alvarez', 'qweQWE123', 'camarero'),
('Deiby Buenaño', 'qweQWE123', 'camarero'),
('Pol Marc Monter', 'qweQWE123', 'manager');

-- INSERT TABLA SALAS
INSERT INTO Salas (nombre, capacidad) VALUES
('Terraza 1', 20),
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