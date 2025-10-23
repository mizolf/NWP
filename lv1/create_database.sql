CREATE DATABASE radovi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE radovi;

CREATE TABLE diplomski_radovi (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    naziv_rada VARCHAR(255),
    tekst_rada TEXT,
    link_rada VARCHAR(255),
    oib_tvrtke VARCHAR(20)
);