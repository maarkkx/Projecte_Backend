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
--Contrasenya = "mark"
('admin01', 'Mark', 'Gras', 'm.gras@sapalomera.cat', '6201eb4dccc956cc4fa3a78dca0c2888177ec52efd48f125df214f046eb43138', '1');

INSERT INTO articles (user, titol, cos) VALUES
('admin01', 'Poción', 'Restaura 20 PS al Pokémon objetivo. Ideal para los primeros combates.'),
('admin01', 'Superpoción', 'Cura 50 PS y es más eficiente durante travesías largas o combates duros.'),
('admin01', 'Hiperpoción', 'Restaura 120 PS. Uso común en gimnasios con Pokémon de nivel alto.'),
('admin01', 'Restaurar Todo', 'Cura todos los PS y elimina cambios de estado. Uno de los objetos más valiosos.'),
('admin01', 'Antídoto', 'Cura el estado de envenenamiento. Muy útil en cuevas y bosques.'),
('admin01', 'Despertar', 'Elimina el estado de sueño inmediatamente.'),
('admin01', 'Revivir', 'Revive a un Pokémon debilitado con la mitad de sus PS.'),
('admin01', 'Máximo Revivir', 'Revive a un Pokémon debilitado y restaura todos sus PS.'),
('admin01', 'Piedra Trueno', 'Objeto evolutivo que permite evolucionar a ciertos Pokémon de tipo Eléctrico.'),
('admin01', 'Piedra Fuego', 'Objeto evolutivo para Pokémon como Growlithe o Eevee.'),
('admin01', 'Piedra Agua', 'Evoluciona a varios Pokémon acuáticos, como Poliwhirl o Eevee.'),
('admin01', 'Piedra Hoja', 'Evoluciona Pokémon de tipo Planta.'),
('admin01', 'MT 13 – Rayo Hielo', 'Una MT que enseña un ataque de hielo muy potente y que puede congelar al rival.'),
('admin01', 'MT 26 – Terremoto', 'Ataque físico muy fuerte de tipo Tierra. Una de las MT más populares.'),
('admin01', 'Caramelo Raro', 'Aumenta el nivel de un Pokémon en 1. Muy valioso para entrenamiento rápido.'),
('admin01', 'Cuerda Huida', 'Permite escapar inmediatamente de cuevas y mazmorras.'),
('admin01', 'Repelente', 'Evita encuentros con Pokémon salvajes de nivel inferior al del primero del equipo.'),
('admin01', 'Bici', 'Permite desplazarse a mayor velocidad por diversas rutas.'),
('admin01', 'Superball', 'Poké Ball mejorada con mayores probabilidades de captura.'),
('admin01', 'Ultraball', 'Poké Ball avanzada que ofrece un ratio de captura excelente.');