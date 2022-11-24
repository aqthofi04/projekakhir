<?php
session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php'; 

$id = $_GET["id"];

$siswa = query("SELECT * FROM tb_siswa WHERE id = $id")[0]; 


if( isset($_POST["submit"]) ) {

    if( ubah($_POST) > 0 ) {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
        <script> 
            alert('data gagal diubah!');
            document.location.href = 'index.php';
        </script>
        ";
    }

}
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Siswa</title>
</head>
<body>
    <h1>Ubah Data Siswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $siswa["id"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $siswa["Gambar"]; ?>">
        <ul>
            <li>
                <label for="NIS">NIS : </label>
                <input type="text" name="NIS" id="NIS" required value="<?= $siswa["NIS"]; ?>">
            </li>
            <li>
                <label for="Nama">Nama : </label>
                <input type="text" name="Nama" id="Nama" required value="<?= $siswa["Nama"]; ?>">
            </li>
            <li>
                <label for="Email">Email : </label>
                <input type="text" name="Email" id="Email" required value="<?= $siswa["Email"]; ?>">
            </li>
            <li>
                <label for="Jurusan">Jurusan : </label>
                <input type="text" name="Jurusan" id="Jurusan" required value="<?= $siswa["Jurusan"]; ?>">
            </li>
            <li>
                <label for="Gambar">Gambar : </label> <br>
                <img src="img/<?= $siswa['Gambar']; ?>" width="40"> <br>
                <input type="file" name="Gambar" id="Gambar">
            </li>
            <li>
                <button type="submit" name="submit">Ubah Data!</button>
            </li>
        </ul>
    </form>
</body>
</html>