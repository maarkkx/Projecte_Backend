DROP DATABASE IF EXISTS pjf_mark_gras;

CREATE DATABASE pjf_mark_gras;
USE pjf_mark_gras;

CREATE TABLE IF NOT EXISTS users (
    user VARCHAR(20) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    admin ENUM('0','1') DEFAULT '0'
);

CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(20),
    titol TINYTEXT,
    cos TEXT,
    INDEX idx_id (id),
    FOREIGN KEY (user) REFERENCES users(user)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

INSERT INTO users (user, nombre, apellido, correo, password, admin)
VALUES 
('admin01', 'Mark', 'Gras', 'm.gras@sapalomera.cat', 'admin123', '1'),
('Mason', 'Alvaro', 'Mason', 'a.masedo@sapalomera.cat', 'MasonesSI', '0'),
('user02', 'Victor', 'Extremo', 'v.extremera@sapalomera.cat', 'VictorHola', '0'),
('user03', 'Samuel', 'Cañas', 's.cañadas@sapalomera.cat', 'samuBobo', '0');
