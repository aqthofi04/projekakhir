<?php
// session_start();

// if( !isset($_SESSION["login"]) ) {
//     header("Location: login.php");
//     exit;
// }

require 'functions.php';
$siswa = query("SELECT * FROM tb_siswa");

if( isset($_POST["cari"]) ) {
    $siswa = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="global.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <div class="container">


    
<h1 class="text-center">Daftar Siswa</h1>
<a href="logout.php">logout</a>
<a href="tambah.php">Tambah Data Siswa</a>
<br><br>

<form action="" method="post">
<div class="input-group">
  <input type="search" class="form-control rounded" placeholder="Search" name="keyword" autofocus="" aria-label="Search" aria-describedby="search-addon">
  <button type="submit" name="cari" class="btn btn-outline-primary">Cari</button>
</div>
</form>

<br>
<table  class="table table-striped">

    <tr>
        <th>No.</th>
        <th>Aksi</th>
        <th>Gambar</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Jurusan</th>
    </tr>

    <?php foreach( $siswa as $row ) : ?>
    <tr>
        <td><?= $i=1; ?></td>
        <td>
            <a class="a1" href="ubah.php?id=<?= $row["id"]; ?>">ubah</a> |
            <a class="a2" href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin?');">hapus</a>
        </td>
        <td><img src="img/<?= $row["Gambar"]; ?>" width="50"></td>
        <td><?= $row["NIS"]; ?></td>
        <td><?= $row["Nama"]; ?></td>
        <td><?= $row["Email"]; ?></td>
        <td><?= $row["Jurusan"]; ?></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>

</table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>