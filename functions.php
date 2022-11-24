<?php

$conn = mysqli_connect("localhost", "root", "", "db_datasiswa");


function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    } 
    return $rows;
}



function tambah($data) {
    global $conn;

    $nis = htmlspecialchars($data["NIS"]);
    $nama = htmlspecialchars($data["Nama"]);
    $email = htmlspecialchars($data["Email"]);
    $jurusan = htmlspecialchars($data["Jurusan"]);

    $gambar = upload();
    if( !$gambar ) {
        return false;
    }

    $query = "INSERT INTO tb_siswa
                VALUES
               ('', '$nis', '$nama', '$email', '$jurusan', '$gambar') 
                ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload() {

    $namaFile = $_FILES['Gambar']['name'];
    $ukuranFile = $_FILES['Gambar']['size'];
    $error = $_FILES['Gambar']['error'];
    $tmpName = $_FILES['Gambar']['tmp_name']; 

    if( $error === 4 ) {
        echo "<script> 
                alert('pilih gambar terlebih dahulu!');
              </script>";
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "<script> 
                alert('yang anda unggah bukan gambar!');
              </script>";
        return false;
    }


     if( $ukuranFile > 1000000 ) {
        echo "<script> 
                alert('ukuran gambar terlalu besar!');
              </script>";
        return false;
     }


     $namaFileBaru = uniqid();
     $namaFileBaru .= '.';
     $namaFileBaru .= $ekstensiGambar;

     move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

     return $namaFileBaru;


}


function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM tb_siswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}


function ubah($data) {
    global $conn;

    $id = $data["id"];
    $nis = htmlspecialchars($data["NIS"]);
    $nama = htmlspecialchars($data["Nama"]);
    $email = htmlspecialchars($data["Email"]);
    $jurusan = htmlspecialchars($data["Jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    if( $_FILES['Gambar']['error'] === 4 ) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }
    

    $query = "UPDATE tb_siswa SET
                NIS ='$nis',
                Nama = '$nama',
                Email = '$email',
                Jurusan = '$jurusan',
                Gambar = '$gambar'
            WHERE id = $id
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari($keyword) {
    $query = "SELECT * FROM tb_siswa
                WHERE
              Nama LIKE '%$keyword%' OR
              NIS LIKE '%$keyword%' OR
              Email LIKE '%$keyword%' OR
              Jurusan LIKE '%$keyword%'
            ";
    return query($query);
}


function registrasi($data) {
    global $conn;

    $username = strtolower(stripcslashes($data["username"])); 
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if ( mysqli_fetch_assoc($result) ) {
        echo "<script> 
                alert('username sudah terdaftar!');
              </script>";
        return false;
    }

    if( $password !== $password2 ) {
        echo "<script> 
                alert('konfirmasi password tidak sesuai!');
              </script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");
    
    return mysqli_affected_rows($conn);
}

?>