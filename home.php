<?php

require "database.php";

session_start();

if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

$contacts = $conn->query("SELECT * FROM contacts WHERE user_id = {$_SESSION['user']['id']};");
// var_dump($contacts);
// die();

require "partials/header.php";

?>

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
            <a href="edit.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2">Edit Contact</a>
            <!-- 
              Usamos un método GET para pedir el script de borrado enviándole el índice del elemento a borrar de BBDD 
              Para ello le pasamos el ID del $contact que está recorriendo el loop en este momento y se añade a la querystring
            -->
            <a href="delete.php?id=<?= $contact["id"] ?>" class="btn btn-danger mb-2">Delete Contact</a>
          </div>
        </div>
      </div>
    <?php endforeach ?>

  </div>
</div>

<?php require "partials/footer.php"; ?>
