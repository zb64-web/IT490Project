CREATE DATABASE starterdb;
USE starterdb;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password_hash) VALUES ('Ally', PASSWORD('password1'));
