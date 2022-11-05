<?php

$host = "127.0.0.1"; # o localhost
$database = "contacts_app"; # El mismo nombre que la base de datos MySQL
$dbuser = "root";
$dbpass = "";

try {
  $conn = new PDO("mysql:host=$host;dbname=$database", $dbuser, $dbpass);
  // foreach ($conn->query("SHOW DATABASES") as $row) {
  //   print_r($row); # Imprime el array como string
  // }
  // die();
} catch (PDOException $e){
  die("PDO Connection Error: " . $e->getMessage());
}
