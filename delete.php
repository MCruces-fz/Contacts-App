<?php 

require "database.php";

# En $_GET no hay contenido como tal, pero se puede enviar a través de la querystring
$id = $_GET["id"];

$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id");
# Esto es una alternativa a bindParam. Así se pueden meter varios en lugar de hacer de uno en uno
$statement->execute([":id" => $id]);

if ($statement->rowCount() == 0) {
  http_response_code(404);

?>

<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error</title>
  <style type=text/css>
    h1 {
      font: 50px Times;
    }
  </style>
</head>
<body>
  <div>
    <h1>
      HTTP 404 NOT FOUND
    </h1>
    <p>
      The ID <?= $id ?> you're trying to delete doesn't exist in our BBDD. 
    </p>
    <p>
      Please, try again.
    </p>
  </div>
  
</body>
</html>

<?php
  return;
}

$conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

header("Location: index.php");

?>
