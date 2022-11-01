# Contacts App

## Notas 

### Para usar Apache
Importante tener el proyecto en la ruta de xampp/htdocs/ para que se pueda acceder mediante el servidor y no abriendo los ficheros HTML desde el navegador. Si se abren de esta forma los ficheros PHP, estos no serán interpretados y el código PHP se mostrará como cadena de texto.

### CURL
No todos los clientes tienen porque ser navegadores. No podemos fiarnos de que el único que puede añadir contactos es un usuario que tiene el formulario web que generamos aquí, porque se podría, por ejemplo, hacer una petición de tipo POST desde CURL.

Para comprobarlo, copiamos la ruta `http://localhost/contacts-app/add.php` de "Add Contact" en el navegador y desde la consola de Linux, el Content-Type del header de la request a add.php para añadir el data como `clave=valor&clave=valor`, y hacemos:

`$ curl -X POST --header "Content-Type: application/x-www-form-urlencoded" --data "name=pepe&phone_number=637243918" http://localhost/contacts-app/index.php`

Estamos añadiendo un contacto sin usar el navegador.

### MySQL

Para iniciar este servicio abrimos la consola e iniciamos el cliente mysql de la siguiente forma

`$ mysql --user root -p`

Esto es `--user root` que como usuario seremos root y `-p` que nos pida la contraseña (que por defeceto está vacía, así que le damos enter sin más).

Con la sentencia

`SHOW DATABASES;`

nos muestra las bases de datos existentes. Con la sentencia

`DROP DATABASE <database_name>;`

borramos una base de datos existente y con 

`CREATE DATABASE <database_name>;`

la creamos. Para utilizarla se utiliza la sentencia

`USE <database_name>;`

Para crear una tabla (una vez lanzada la sentencia `USE <database_name>;`) se lanza

`CREATE TABLE <table_name> (field_1 FIELD_TYPE_1, field_2 FIELD_TYPE_2, ...);`

y con la sentencia

`SHOW TABLES;`

debemos ver el nombre de la tabla creada. Con

`DESCRIBE <table_name>;`

vemos los campos de la tabla con sus descripciones.

Por ejemplo para crear nuestra tabla de contactos haremos

`CREATE TABLE contacts (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), phone_number VARCHAR(255));`

Donde tanto el nombre como el número de teléfono son strings de MySQL, y además tenemos un campo ID para poder diferenciar todos los contactos incluso si tienen el mismo nombre.
Este ID entero se incrementa automáticamente (`AUTO_INCREMENT`) cada vez que se crea un registro. Para poder buscar un contacto de forma inmediata sin tenerque recorrer toda la tabla lo convertimos en clave primaria con `PRIMARY KEY` para que lo genere de forma automática. También debemos tener la clave primaria que nos servirá para asociar los contactos a un usuario y que cada usuario tenga sus propios contactos. Con esto tenemos
```
+--------------+--------------+------+-----+---------+----------------+
| Field        | Type         | Null | Key | Default | Extra          |
+--------------+--------------+------+-----+---------+----------------+
| id           | int(11)      | NO   | PRI | NULL    | auto_increment |
| name         | varchar(255) | YES  |     | NULL    |                |
| phone_number | varchar(255) | YES  |     | NULL    |                |
+--------------+--------------+------+-----+---------+----------------+
``` 

Para meter información en esta tabla hacemos

`INSERT INTO contacts (name, phone_number) VALUES ("Pepe", "9863332050");`

Para actualizar esta es la sentencia

`UPDATE contacts SET name = "Nate" WHERE name = "Pepe";`

Para borrar es esta sentencia

`DELETE FROM contacts WHERE name = "Nate";`

Para salir se typea `exit;`.


