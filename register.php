<?php

require "database.php";

$name = null;
$email = null;
$password = null;

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  
  if (empty($name) || empty($email) || empty($password)) {
    $error = "Please fill all fields.";
  } elseif (!str_contains($email, "@")) {
    $error = "Email cormat is incorrect.";
  } else {
    $statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $statement->bindParam(":email", $email);
    $statement->execute();

    if ($statement->rowCount() > 0) {
      $error = "This email already exists";
    } else {
      $conn
        ->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password);")
        ->execute([
          ":name" => $name,
          ":email" => $email,
          ":password" => password_hash($password, PASSWORD_BCRYPT)
        ]);
      header("Location: home.php");
    }
  }
}

require "partials/header.php";

?>
<!-- Se copia del repo de Sarosi -->
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Register</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <!-- Se añade el método POST porque es para enviar info -->
          <form method="POST" action="register.php">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">User name</label>

              <div class="col-md-6">
                <input value="<?= $user ?>" id="name" type="text" class="form-control" name="name" autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

              <div class="col-md-6">
                <input value="<?= $email ?>" id="email" type="email" class="form-control" name="email" autocomplete="email" autofocus> 
              </div>
            </div>

            <div class="mb-3 row">
              <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

              <div class="col-md-6">
                <input value="<?= $password ?>" id="password" type="password" class="form-control" name="password" autocomplete="password" autofocus> 
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
