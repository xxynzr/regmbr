<?php
session_start();

if( !isset($_SESSION["login"]) ) {
  header("Location: login.php");
  exit;
}

require 'functions.php';

$id = $_GET["id"];

$agt = querry("SELECT * FROM anggota 
                INNER JOIN badan ON badan = badan.kode_badan 
                INNER JOIN jemlok ON jemlok = jemlok.kode_jemlok 
                WHERE id = $id")[0];

if ( isset($_POST["submit"]) ) {

  if( edit($_POST) > 0 ) {
    echo "
        <script>
            alert('Data Berhasil Diubah');
            document.location.href = 'index.php';
        </script>
    ";
  } else {
    echo "
        <script>
          alert('Data Gagal Diubah');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="background.css" rel="stylesheet">
  </head>
  <body>
    <div class="container-sm">
      <h1>Form Pendaftaran Anggota</h1>
      <div class="row justify-content-md-center">
        <!-- <div class="col-md-2">
          left
        </div> -->
        <div class="col-md-6">
          <form class="form-label" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="aims" class="form-label">AIMS</label>
              <input type="number" class="form-control" id="aims" placeholder="Nomer AIMS">
            </div>
          <input type="hidden" name="oldpicture" value="<?= $agt["picture"];?>">
            <ul>
              <li>
                <label for="aims">No AIMS : </label>
                <input type="number" name="aims" id="aims" value="<?= $agt["aims"];?>"/>
              </li>
              <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" required value="<?= $agt["nama"];?>"/>
              </li>
              <li>
              <?php
                $sel_cus = "select Room_Type_Id,Room_Type_Name from room_type ";
                $res_cus = mysqli_query($connection, $sel_cus);
                while ($row = mysqli_fetch_array($res_cus))
                {?>
                <option value="<?php echo $row['Room_Type_Id'];?>"
                <?php if ($room_type_id == $row['Room_Type_Id']) { echo 'selected="selected"';}?>>
                <?php echo $row['Room_Type_Name'];?></option>
                <?php
                } 
                ?>
              </li>
              <li>
                  <label for="badan" >Badan : </label>
                  <select class="long" name="badan" id="badan" value="<?= $agt["kode_badan"];?>">
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
                  <select class="long" name="jemlok" id="jemlok" value="<?= $agt["kode_jemlok"];?>">
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
                <img src="img/<?= $agt ['picture']; ?>" width="40"> <br>
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
        </div>
        <!-- <div class="col-md-2">
          right
        </div> -->
      </div>
    </div>
  </body>
</html>
