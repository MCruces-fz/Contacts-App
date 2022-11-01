/*
Para lanzar este fichero entrar en mysql
`$ mysql --user root -p`
y typear la sentencia
`> SOURCE setup.sql`
*/

DROP DATABASE IF EXISTS contacts_app;

CREATE DATABASE contacts_app;

USE contacts_app;

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    phone_number VARCHAR(255)
);

INSERT INTO contacts (name, phone_number) VALUES ("Pepe", "986230978");
