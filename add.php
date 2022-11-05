<?php

require "database.php";

session_start();

if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

$error = null;

// SUPERGLOBAL VARIABLE
/*
Esta variable contiene información sobre la petición HTTP que nos mandan
con var_dum(_SERVER) se puede ver la información que contiene.
*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = $_POST["name"];
  $phoneNumber = $_POST["phone_number"];

  if (empty($name) || empty($phoneNumber)) {
    $error = "Please, fill all the fields.";
  } else if (strlen($phoneNumber) < 9) {
    $error = "Phone number must be at leaset 9 characters.";
  } else {

    # Safamos de las inyecciones SQL
    $statement = $conn->prepare("INSERT INTO contacts (name, phone_number, user_id) VALUES (:name, :phone_number, :user_id);");
    $statement->bindParam(":name", $name);
    $statement->bindParam(":phone_number", $phoneNumber);
    $statement->bindParam(":user_id", $_SESSION["user"]["id"]);
    $statement->execute();

    # Pedimos que nos redireccione a home.php
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
          <!-- Se añade el método POST porque es para enviar info -->
          <form method="POST" action="add.php">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

              <div class="col-md-6">
                <input id="phone_number" type="tel" class="form-control" name="phone_number" autocomplete="phone_number" autofocus> 
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
