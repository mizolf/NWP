CREATE DATABASE lv2;
USE lv2;

CREATE TABLE osobe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(50),
    prezime VARCHAR(50),
    email VARCHAR(100)
);

INSERT INTO osobe (ime, prezime, email) VALUES
('Marko', 'Marković', 'marko@example.com'),
('Ana', 'Anić', 'ana@example.com'),
('Petar', 'Petrović', 'petar@example.com');