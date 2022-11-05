<?php 

require "database.php";

# En $_GET no hay contenido como tal, pero se puede enviar a través de la querystring
$id = $_GET["id"];

$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id")->execute([":id" => $id]);

if ($statement->rowCount() == 0) {
  http_response_code(404);
  echo("HTTP 404 NOT FOUND");
  return;
}

$statement = $conn->prepare("DELETE FROM contacts WHERE id = :id");
# Esto es una alternativa a bindParam. Así se pueden meter varios en lugar de hacer de uno en uno
$statement->execute([":id" => $id]);

header("Location: index.php");

?>
