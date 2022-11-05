<?php

require "database.php";

session_start();

if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

$id = $_GET["id"];

/*
Lo limitamos a 1 para que en lugar de darnos un array de un contacto 
[["name" => "Pepe"]]
nos da directamente el contacto en un diccionario
["name" => "Pepe"]
*/
$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1;");
$statement->execute([":id" => $id]);

if ($statement->rowCount() == 0): 
  http_response_code(404);
?>

<html lang="en">
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
      The ID <?= $id ?> you're trying to edit doesn't exist in our BBDD. 
    </p>
    <p>
      Please, try again.
    </p>
  </div>
</body>
</html>

<?php
  return;
endif;

/*
Le pedimos que nos devuelva las filas que queremos a la clase de tipo PDO en un 
formato asociativo (un array o algo que entendamos).
Como limitamos a 1 contacto, ya nos ahorramos acceder con el índice [0] del array.
*/
$contact = $statement->fetch(PDO::FETCH_ASSOC);
$name = $contact["name"];
$phoneNumber = $contact["phone_number"];

if ($contact["user_id"] !== $_SESSION["user"]["id"]) {
  http_response_code(403);
  echo("HTTP 403 UNAUTHORIZED");
  return;
}

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = $_POST["name"];
  $phoneNumber = $_POST["phone_number"];

  if (empty($name) || empty($phoneNumber)) {
    $error = "Please, fill all the fields.";
  } else if (strlen($phoneNumber) < 9) {
    $error = "Phone number must be at leaset 9 characters.";
  } else {

    $statement = $conn->prepare("UPDATE contacts SET name = :name, phone_number = :phone_number WHERE id = :id;");
    $statement->execute([
      ":id" => $id,
      ":name" => $name,
      ":phone_number" => $phoneNumber
    ]);

    header("Location: home.php");
  }
}

require "partials/header.php";

?>

<!-- Se copia del repo de Sarosi -->
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Contact</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <!-- Se envía de nuevo el ID del contacto para que al recargar la página de edit.php con el POST lo tengamos de nuevo para editarlo -->
          <form method="POST" action="edit.php?id=<?= $id ?>">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input value="<?= $name ?>" id="name" type="text" class="form-control" name="name" autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

              <div class="col-md-6">
                <input value="<?= $phoneNumber ?>" id="phone_number" type="tel" class="form-control" name="phone_number" autocomplete="phone_number" autofocus> 
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require "partials/footer.php"; ?>
