<?php

require "database.php";

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

    header("Location: index.php");
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--Tema oscuro de Bootstrap https://cdnjs.com/libraries/bootswatch -> Version más nueva -> coipar el darkly -->
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.2/darkly/bootstrap.min.css" 
    integrity="sha512-8RiGzgobZQmqqqJYja5KJzl9RHkThtwqP1wkqvcbbbHNeMXJjTaBOR+6OeuoxHhuDN5h/VlgVEjD7mJu6KNQXA==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer"
  />
  <!--Tema oscuro de Bootstrap https://www.bootstrapcdn.com/ -> Javascript Bundle -> HTML -->
  <!-- Poner el "defer" para que no cargue el script antes que el HTML -->
  <script 
    defer  
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" 
    crossorigin="anonymous"
  ></script>

  <!-- Linkeamos el CSS de contenido estático -->
  <link rel="stylesheet" href="./static/css/index.css" />

  <title>Contacts App</title>
</head>
<body>

  <!-- 
    Todo el NAV se copia del repo de Sarosi 
    O bien del https://getbootstrap.com/docs/5.0/components/navbar/
  -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand font-weight-bold" href="#">
        <img class="mr-2" src="./static/img/logo.png" />
        ContactsApp
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add.php">Add Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
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
  </main>

</body>
</html>
