<?php

// koneksi ke database
$db = mysqli_connect("localhost","root","","TypeGame");

// baca isi yang ada didatabase
function query($query){
    global $db;
    $result = mysqli_query($db, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return  $rows;
}

// registrasi//
function registrasi($tambah){
    global $db;

    $username = strtolower(stripslashes($tambah['username']));  //stripslashes adalah untuk membersihkan dari karakter2 aneh
    $password = $tambah['password'];
    $password2 = $tambah['password2'];

    // cek apakah username sudah pernah ada atau belum 
    $result = mysqli_query($db, "SELECT username FROM user WHERE username = '$username'");

    if(mysqli_fetch_assoc($result)){
        echo "<script>
        alert('username sudah pernah ada')
        </script>";
        return false;
    }
    
    // cek konfir password
    if($password !== $password2){
        echo "<script>
        alert('password salah')
        </script>";
        return false;
    }

    // enksripsi password
    $password = password_hash($password, PASSWORD_DEFAULT); //pakai parameter password_default aja
    // tambahkan username ke database
    $query = "INSERT INTO user VALUES (
    '',
    '$username',
    '$password'
    )";
    mysqli_query($db,$query);

    return mysqli_affected_rows($db);
}




?>