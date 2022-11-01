# Contacts App

## Notas 

### Para usar Apache
Importante tener el proyecto en la ruta de xampp/htdocs/ para que se pueda acceder mediante el servidor y no abriendo los ficheros HTML desde el navegador. Si se abren de esta forma los ficheros PHP, estos no serán interpretados y el código PHP se mostrará como cadena de texto.

### CURL
No todos los clientes tienen porque ser navegadores. No podemos fiarnos de que el único que puede añadir contactos es un usuario que tiene el formulario web que generamos aquí, porque se podría, por ejemplo, hacer una petición de tipo POST desde CURL.

Para comprobarlo, copiamos la ruta `http://localhost/contacts-app/add.php` de "Add Contact" en el navegador y desde la consola de Linux, el Content-Type del header de la request a add.php para añadir el data como `clave=valor&clave=valor`, y hacemos:

`$ curl -X POST --header "Content-Type: application/x-www-form-urlencoded" --data "name=pepe&phone_number=637243918" http://localhost/contacts-app/index.php`

Estamos añadiendo un contacto sin usar el navegador.
