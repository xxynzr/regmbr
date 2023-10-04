<?php
session_start();

//Check Cookie
// if( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
//     $id = $_COOKIE['id'];
//     $key = $_COOKIE['key'];


//     $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
//     $row = mysqli_fetch_assoc($result);

//     if( $key === hash('sha256', $row['username']) ) {
//         $_SESSION['login'] = true;
//     }
// }

if( isset($_SESSION["login"]) ) {
    header("Location: index.php");
    exit;
}

require 'functions.php';

if( isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' ");

    if( mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);
        if( password_verify($password, $row["password"]) ) {

            $_SESSION["login"] = true;

            //RememberME
            if( isset($_POST['remember']) ) {
                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['username']), time()+60);
            }

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="background.css" rel="stylesheet">
  </head>

  <body>
    <form class="form-signin" method="post">
      <h1 class="h3 mb-3 font-weight-normal text-center">LOGIN</h1>
      <?php if(isset($error)):?>
        <p style="color: red; font-size:small; font-style:italic;">Username atau Password yang anda masukkan salah</p>
      <?php endif;?>
      <div class="text-sm">
        <label for="username" class="sr-only">Username</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
      </div>
      <label class="fs-6" for="password" class="sr-only">Password</label>
      <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
      <div class="d-grid col-4 mx-auto">
          <button name="login" class="btn-center btn btn-md btn-primary btn-block" type="submit">Login</button>
      </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
