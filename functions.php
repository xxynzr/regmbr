<?php
$conn = mysqli_connect("localhost", "root", "", "pendaftaran-anggota");

function querry($querry) {
    global $conn;
    $result = mysqli_query($conn, $querry);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    };
    return $rows;
}

function add($data) {
    global $conn;

    $aims = htmlspecialchars($data["aims"]);
    $nama = htmlspecialchars($data["nama"]);
    $badan = htmlspecialchars($data["badan"]);
    $jemlok = htmlspecialchars($data["jemlok"]);

    $picture = upload();
    if(!$picture){
        return false;
    }

    $query = "INSERT INTO anggota 
                VALUES
                ('$aims', '$nama', '$badan', '$jemlok', '$picture', '')  
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload() {
    $nameFile = $_FILES['picture']['name'];
    $sizeFile = $_FILES['picture']['size'];
    $error = $_FILES['picture']['error'];
    $tmpName = $_FILES['picture']['tmp_name'];

    if( $error === 4 ) {
        echo "<script>
                alert('Upload foto terlebih dahulu');
              </script>";
        return false;
    }

    $extentionGambarValid = ['jpg', 'jpeg', 'png'];
    $extentionGambar = explode('.',$nameFile);
    $extentionGambar = strtolower(end($extentionGambar));
    
    if( !in_array($extentionGambar, $extentionGambarValid)) {
        echo "<script>
                alert('Format gambar tidak sesuai');
              </script>";
        return false;
    }

    if( $sizeFile > 1000000) {
        echo "<script>
                alert('Ukuran foto terlalu besar');
              </script>";
        return false;
    } 

    $newnameFile = uniqid();
    $newnameFile .= '.';
    $newnameFile .= $extentionGambar;

    move_uploaded_file($tmpName, 'img/' . $newnameFile);

    return $newnameFile;
}

function delete($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM anggota WHERE id = $id");
  
    return mysqli_affected_rows($conn);
}

function edit($data) {
    global $conn;
    $id = $data(["id"]);
    $aims = htmlspecialchars($data["aims"]);
    $nama = htmlspecialchars($data["nama"]);
    $badan = htmlspecialchars($data["badan"]);
    $jemlok = htmlspecialchars($data["jemlok"]);

    $oldpicture = htmlspecialchars($data["oldpicture"]);
    if( $_FILES['picture']['error'] === 4) {
        $picture = $oldpicture;
    } else {
        $picture = upload();
    }
    

    $query = "UPDATE anggota 
                INNER JOIN badan ON badan = badan.kode_badan 
                INNER JOIN jemlok ON jemlok = jemlok.kode_jemlok
                SET
                aims = '$aims',
                nama = '$nama',
                badan = '$badan',
                jemlok = '$jemlok',
                picture = '$picture'
              WHERE id = $id
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function search($keyword) {
    $query = " SELECT * FROM anggota 
                INNER JOIN badan ON badan = badan.kode_badan 
                INNER JOIN jemlok ON jemlok = jemlok.kode_jemlok
                WHERE
                nama LIKE '%$keyword%' OR
                aims LIKE '%$keyword%' OR
                badan LIKE '%$keyword%' OR
                jemlok LIKE '%$keyword%'
            ";
    return querry($query);
}

function registration($data) {
    global $conn;

    $username  = strtolower(stripslashes($data["username"]));
    $password  = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

    if( mysqli_fetch_assoc($result) ) {
        echo "<script>
                alert('Username sudah terdaftar')
              </script>";
        return false;
    }


    if( $password !== $password2 ) {
        echo "<script>
                alert('Password tidak sama');
              </script>";
        return false;
    }
    
    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);

}

?>