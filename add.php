<?php
session_start();

if( !isset($_SESSION["login"]) ) {
  header("Location: login.php");
  exit;
}

require 'functions.php';

if ( isset($_POST["submit"]) ) {

  if( add($_POST) > 0 ) {
    echo "
        <script>
            alert('Data Berhasil Ditambah');
            document.location.href = 'index.php';
        </script>
    ";
  } else {
    echo "
        <script>
          alert('Data Gagal Ditambah');
          document.location.href = 'index.php';
        </script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pendaftaran Anggota</title>
    <style>
        label{display: block};
        .dropbtn {
            background-color: #3498DB;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover, .dropbtn:focus {
            background-color: #2980B9;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .long {
            min-width: 30px;
        }

        .dropdown a:hover {background-color: #ddd;}

        .show {display: block;}

        .content {
            max-width: 500px;
            margin: 150px auto;
            border: 2px solid #4CAF50;
        }
    </style>
  </head>
  <body class="content">
    <h1>Form Pendaftaran Anggota</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <ul>
        <li>
          <label for="aims">No AIMS : </label>
          <input type="number" name="aims" id="aims" />
        </li>
        <li>
          <label for="nama">Nama : </label>
          <input type="text" name="nama" id="nama" required />
        </li>
        <li>
            <label for="badan" >Badan : </label>
            <select class="long" name="badan" id="badan" >
                <option value="">--Pilih--</option>
                <option value="A">Anshar</option>
                <option value="B">Abna</option>
                <option value="G">Banath</option>
                <option value="K">Khuddam</option>
                <option value="L">Lajnah</option>
                <option value="N">Nasirat</option>
                <option value="T">Athfal</option>
            </select>
        </li>
        <li>
            <label for="jemlok" >Jema'at Lokal : </label>
            <select class="long" name="jemlok" id="jemlok" >
                <option value="">--Pilih--</option>
                <option value="MKZ">Markaz</option>
                <option value="BGR">Bogor</option>
                <option value="CJR">Cianjur</option>
                <option value="TSN">Tugu Selatan</option>
                <option value="CSL">Cisalada</option>
                <option value="SDB">Sindangbarang</option>
            </select>
        </li>
        <li>
          <label for="picture">Gambar : </label>
          <input type="file" name="picture" id="picture" />
        </li>
        <li>
          <button type="submit" name="submit">Submit</button>
        </li>
        <li>
          <a href="index.php">Back</a>
        </li>
      </ul>
    </form>
  </body>
</html>
