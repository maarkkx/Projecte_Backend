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
('admin01', 'Potion', 'Restores 20 HP to the target Pokémon. Ideal for early battles.'),
('admin01', 'Super Potion', 'Restores 50 HP and is useful during long journeys or tough battles.'),
('admin01', 'Hyper Potion', 'Restores 120 HP. Commonly used in gyms with high-level Pokémon.'),
('admin01', 'Full Restore', 'Fully restores HP and cures all status conditions. One of the most valuable items.'),
('admin01', 'Antidote', 'Cures the poisoned status condition. Very useful in caves and forests.'),
('admin01', 'Awakening', 'Immediately cures the sleep status.'),
('admin01', 'Revive', 'Revives a fainted Pokémon with half of its max HP.'),
('admin01', 'Max Revive', 'Revives a fainted Pokémon and fully restores its HP.'),
('admin01', 'Thunder Stone', 'Evolutionary item that allows certain Electric-type Pokémon to evolve.'),
('admin01', 'Fire Stone', 'Evolutionary item for Pokémon such as Growlithe or Eevee.'),
('admin01', 'Water Stone', 'Evolves several Water-type Pokémon such as Poliwhirl or Eevee.'),
('admin01', 'Leaf Stone', 'Evolves certain Grass-type Pokémon.'),
('admin01', 'TM13 – Ice Beam', 'A TM that teaches a powerful Ice-type attack that may freeze the foe.'),
('admin01', 'TM26 – Earthquake', 'A very strong Ground-type physical move. One of the most popular TMs.'),
('admin01', 'Rare Candy', 'Increases a Pokémon’s level by 1. Very valuable for fast training.'),
('admin01', 'Escape Rope', 'Allows you to immediately leave caves and dungeons.'),
('admin01', 'Repel', 'Prevents encounters with wild Pokémon weaker than the first in your party.'),
('admin01', 'Bicycle', 'Allows faster travel across various routes.'),
('admin01', 'Great Ball', 'An improved Poké Ball with a higher catch rate.'),
('admin01', 'Ultra Ball', 'An advanced Poké Ball offering an excellent catch rate.');