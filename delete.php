<?php 

require "database.php";

session_start();

if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

# En $_GET no hay contenido como tal, pero se puede enviar a través de la querystring
$id = $_GET["id"];

$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1;");
# Esto es una alternativa a bindParam. Así se pueden meter varios en lugar de hacer de uno en uno
$statement->execute([":id" => $id]);

if ($statement->rowCount() == 0): 
  http_response_code(404);
  require "partials/header.php";
?>

<div>
  <h1>
    HTTP 404 NOT FOUND
  </h1>
  <hr>
  <p>
    The <strong>ID <?= $id ?></strong> you're trying to delete doesn't exist in our BBDD. 
  </p>
  <p>
    Please, try again.
  </p>
</div>

<?php
  require "partials/footer.php";
  return;
endif;

$contact = $statement->fetch(PDO::FETCH_ASSOC);

if ($contact["user_id"] !== $_SESSION["user"]["id"]) {
  http_response_code(403);
  echo("HTTP 403 UNAUTHORIZED");
  return;
}

$conn->prepare("DELETE FROM contacts WHERE id = :id;")->execute([":id" => $id]);

header("Location: home.php");

