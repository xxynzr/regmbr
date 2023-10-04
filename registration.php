<?php

require 'functions.php';

if( isset($_POST["register"])) {

   if( registration($_POST) > 0 ) {
       echo "<script>
               alert('User Berhasil Ditambah');
            </script>";
   } else {
       echo mysqli_error($conn);
   }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registration Page</title>
   <style>
       label {display: block;}

       .content {
            max-width: 500px;
            margin: 150px auto;
            border: 2px solid #4CAF50;
        }
   </style>
</head>
<body class="content">
   <h1>Lembar Registrasi</h1>

   <form action="" method="post">
       <ul>
           <li>
               <label for="username">Username : </label>
               <input type="text" name="username" id="username">
           </li>
           <li>
               <label for="password">Password : </label>
               <input type="password" name="password" id="password">
           </li>
           <li>
               <label for="password2">Konfirmasi Password : </label>
               <input type="password" name="password2" id="password2">
           </li>
           <li>
               <button type="submit" name="register">Daftar</button>
           </li>
       </ul>
   </form>
</body>
</html>