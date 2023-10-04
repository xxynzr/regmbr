<?php
session_start();

if( !isset($_SESSION["login"]) ) {
  header("Location: login.php");
  exit;
}

require 'functions.php';

$totaldataperpage = 2;
$totaldata = count(querry("SELECT * FROM anggota"));
$totalpage = ceil($totaldata / $totaldataperpage);
$activepage = (isset($_GET["page"]) ) ? $_GET["page"] : 1;
$truedata = ($totaldataperpage * $activepage) - $totaldataperpage;

$anggota = querry("SELECT * FROM anggota LIMIT $truedata, $totaldataperpage");

if(isset($_POST["search"]) ) {
  $anggota = search($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Pendaftaran Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
    <div class="container" style="width: 50rem;">
      <div>
        <a class="btn btn-danger btn-sm " href="logout.php">Logout</a>
        </div>
      <br>
      <form class="col-sm" action="" method="post">
        <div class="input-group">
          <a class="btn btn-primary btn-sm" href="add.php">Tambah Anggota</a>
          <input class="form-control" type="text" name="keyword" placeholder="Cari Anggota" aria-label="Cari Anggota" autofocus autocomplete="off">
          <button class="btn btn-primary" type="submit" id="search" name="search">Cari</button>
        </div>
      </form>
      <br>
      <table class="card-body">
        <tr>
          <th>AIMS</th>
          <th>Nama</th>
          <th>Badan</th>
          <th>Jema'at Lokal</th>
          <th>Foto</th>
          <th>#</th>
        </tr>

        <?php $i = 1; ?>
        <?php foreach($anggota as $row) : ?>

        <tr>        
          <td><?= $row["aims"];?></td>
          <td><?= $row["nama"];?> </td>
          <td><?= $row["badan"];?></td>
          <td><?= $row["jemlok"];?></td>
          <td><img src="img/<?= $row["picture"];?>" alt="" width="70px"></td>
          <td>
            <a href="edit.php?id=<?= $row["id"];?>">Edit</a> |
            <a href="delete.php?id=<?= $row["id"];?>" onclick="return confirm('Yakin ?')";>Delete</a>
          </td>
        </tr>

        <?php $i++; ?>
        <?php endforeach; ?>

      </table>
        <?php if( $activepage > 1) :?>
          <a href="?page=<?= $activepage - 1; ?>">Previous</a>
        <?php endif?>
          
          <?php for($i = 1; $i <= $totalpage; $i++) :?>
            <?php if( $i == $activepage):?>
              <a href="?page=<?=$i; ?>"><?=$i;?></a>
            <?php else:?>
              <a href="?page=<?=$i; ?>"><?=$i;?></a>
            <?php endif;?>
          <?php endfor;?>

        <?php if( $activepage < $totalpage) :?>
          <a href="?page=<?= $activepage + 1; ?>">Next</a>
        <?php endif?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </div>
  </body>
</html>
