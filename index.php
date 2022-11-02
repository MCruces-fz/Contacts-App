<?php

require "database.php";

$contacts = $conn->query("SELECT * FROM contacts;");
// var_dump($contacts);
// die();

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
            <a class="nav-link" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add.php">Add Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
    <!-- Bootstrap Containers https://getbootstrap.com/docs/5.0/layout/containers/ -->
    <div class="container pt-4 p-3">
      <div class="row">
        <!-- Si no hay contactos se muestra un mensaje -->
        <?php if ($contacts->rowCount() == 0): ?>
          <div class="col-md-4 mx-auto">
            <div class="card card-body text-center">
              <p>No contacts saved yet</p>
              <a href="add.php">Add One!</a>
            </div>
          </div>
        <?php endif ?>
        <!-- Ahora se edita el DIV de HTML y se pone un foreach de PHP para que genere tantos como hay en la lista de diccionarios. -->
        <?php foreach ($contacts as $contact): ?>
          <div class="col-md-4 mb-3">
            <div class="card text-center">
              <div class="card-body">
                <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3>
                <p class="m-2"><?= $contact["phone_number"] ?></p>
                <a href="#" class="btn btn-secondary mb-2">Edit Contact</a>
                <a href="#" class="btn btn-danger mb-2">Delete Contact</a>
              </div>
            </div>
          </div>
        <?php endforeach ?>

      </div>
    </div>
  </main>

</body>
</html>
