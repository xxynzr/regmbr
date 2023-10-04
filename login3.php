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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    label{display: block};
    .button {
            border: none;
            color: white;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
    }

    .blue {border-radius: 8px; background-color: blue;}
    .button2 {border-radius: 4px;}
    .button3 {border-radius: 8px;}
    .button4 {border-radius: 12px;}
    .button5 {border-radius: 50%;}

    .content {
            max-width: 500px;
            margin: 150px auto;
            border: 2px solid black;
        }
    </style>
</head>
<body class="content">
    <h1>Login</h1>

    <?php if(isset($error))  :  ?>
        <p style="color: red; font-style:italic;">Username atau Password yang anda masukkan salah</p>
    <?php endif; ?>

    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username :</label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">Password :</label>
                <input type="password" name="password" id="password">
            </li>
            <!-- <li>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember ME</label>
            </li> -->
            <li>
                <button class="blue button" type="submit" name="login">Login</button>
            </li>
        </ul>
    </form>
</body>
</html>