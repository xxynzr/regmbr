<?php
session_start();

if( !isset($_SESSION["login"]) ) {
  header("Location: login.php");
  exit;
}

require 'functions.php';

$totaldataperpage = 3;
$totaldata = count(querry("SELECT * FROM anggota"));
$totalpage = ceil($totaldata / $totaldataperpage);
$activepage = (isset($_GET["page"]) ) ? $_GET["page"] : 1;
$truedata = ($totaldataperpage * $activepage) - $totaldataperpage;

$anggota = querry("SELECT * FROM anggota INNER JOIN badan ON badan = badan.kode_badan INNER JOIN jemlok ON jemlok = jemlok.kode_jemlok LIMIT $truedata, $totaldataperpage");


if(isset($_POST["search"]) ) {
  $anggota = search($_POST["keyword"]);
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="background.css" rel="stylesheet">
  </head>
  <body>
    <div class="container-sm">
      
      <!-- Logout -->
      <div class="d-md-flex justify-content-md-end mb-3">
        <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
      </div>
      <!-- //Logout -->

      <form action="" method="post">
        <div class="row">
          <!-- Add -->
          <div class="col">
            <a class="btn btn-primary btn-sm" href="add.php">Tambah Anggota</a>
          </div>
          <!-- //Add -->

          <!-- Search -->
          <div class="col input-group input-group-sm mb-2">
            <input type="text" name="keyword" class="form-control" placeholder="Cari Anggota" aria-label="Cari Anggota" autofocus>
            <button class="btn btn-primary btn-sm" type="submit" id="search" name="search">Cari</button>
          </div>
          <!-- //Search -->
        </div>
      </form>
      
      
      <div class="card">
        <!-- Tabel -->
        <div class="table-responsive">
          <table class="table table-bordered text-center">

            <thead>
              <tr>
                <th colspan="6">ANGGOTA</th>
              </tr>
              <tr>
                <th>AIMS</th>
                <th>Nama</th>
                <th>Badan</th>
                <th>Jema'at Lokal</th>
                <th>Foto</th>
                <th>#</th>
              </tr>
            </thead>          

            <tbody>
              
              <?php $i = 1; ?>
              <?php foreach($anggota as $row) : ?>
              <tr>
                <td><?= $row["aims"];?></td>
                <td><?= $row["nama"];?> </td>
                <td><?= $row["nama_badan"];?></td>
                <td><?= $row["nama_jemlok"];?></td>
                <td><img src="img/<?= $row["picture"];?>" alt="" width="70px"></td>
                <td>
                  <a href="edit.php?id=<?= $row["id"];?>">Edit</a> |
                  <a href="delete.php?id=<?= $row["id"];?>" onclick="return confirm('Yakin ?')";>Delete</a>
                </td>
              </tr>
              <?php $i++; ?>
              <?php endforeach; ?>

            </tbody>
          </table>
          <!-- //Table -->

          <nav aria-label="Page">
            <ul class="pagination justify-content-center">
              <?php if( $activepage > 1) :?>
                <li class="page-item">
                  <a class="page-link" href="?page=<?= $activepage - 1; ?>">Previous</a>
                </li>
                <?php else:?>
                  <li class="page-item disabled">
                  <a class="page-link" href="?page=<?= $activepage - 1; ?>">Previous</a>
                </li>
              <?php endif?>


              <?php for($i = 1; $i <= $totalpage; $i++) :?>
                <?php if( $i == $activepage):?>
                  <li class="page-item">
                    <a class="page-link active" href="?page=<?=$i; ?>"><?=$i;?></a>
                  </li>
                <?php else:?>
                  <li class="page-item">
                    <a class="page-link" href="?page=<?=$i; ?>"><?=$i;?></a>
                  </li>
                <?php endif;?>
              <?php endfor;?>

              <?php if( $activepage < $totalpage) :?>
                <li class="page-item">
                  <a class="page-link" href="?page=<?= $activepage + 1; ?>">Next</a>
                </li>
              <?php else:?>
                <li class="page-item disabled">
                  <a class="page-link" href="?page=<?= $activepage - 1; ?>">Next</a>
                </li>
              <?php endif?>
            </ul>
          </nav>
          

        </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>