-- Primero que nada gestionamos los usuarios que accederan al servidor y a la base de datos.


-- Creamos un usuario técnico para acceder al mysql desde php
CREATE USER 'club_padel'@'localhost' IDENTIFIED BY 'PadelSecure123!';

-- Verificmos en el diccionario que el usuario haya sido creado
SELECT * FROM mysql.user;


-- Concedemos permisos de consultar, insertar, actualizar y seleccionar al usuario que hemos creado
GRANT SELECT, INSERT, UPDATE, DELETE ON padel.* TO 'club_padel'@'localhost';

-- Ordenamos la aplicación de los privilegios, de lo contrario quedan en una tabla temporal
FLUSH PRIVILEGES;

-- Verificamos que los privilegios hayan sido aplicados al usuario
SHOW GRANTS FOR 'club_padel'@'localhost';

SELECT * FROM mysql.db where user = 'club_padel';

-- Creamos la base de datos padel, sobre la cual vamos a trabajar

CREATE DATABASE padel;

-- Verificamos que la base de datos haya sido creada

SHOW DATABASES;

-- activamos la base de datos para realizar cambios sobre ella

USE padel;

-- creamos las tablas requeridas para nuestra aplicación

CREATE TABLE USUARIO (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    pass VARCHAR(255), 
    tipo ENUM('0','1') NOT NULL
);

-- Añadir constraint UNIQUE al campo nombre:
ALTER TABLE USUARIO ADD CONSTRAINT unique_nombre UNIQUE (nombre);

DESCRIBE USUARIO;

SELECT * FROM USUARIO;


CREATE TABLE PISTA (
    id_pista INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255)
);

CREATE TABLE RESERVA (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    usuario INT,
    pista INT,
    turno ENUM('Mañana', 'Tarde', 'Noche') NOT NULL,
    FOREIGN KEY (usuario) REFERENCES USUARIO(id_usuario),
    FOREIGN KEY (pista) REFERENCES PISTA(id_pista)
);

INSERT INTO USUARIO (nombre, pass, tipo) VALUES (
    'test', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    '1'
);





