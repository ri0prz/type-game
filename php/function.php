<?php

// Koneksi ke database
$db = mysqli_connect("localhost", "root", "", "TypeGame");

// Baca isi yang ada didatabase
function query($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Registrasi
function registrasi($tambah)
{
    global $db;

    $username = strtolower(stripslashes($tambah['username'])); // ✨ stripslashes membersihkan dari karakter2 aneh
    $password = $tambah['password'];
    $password2 = $tambah['password2'];

    // Cek username ada belum 
    $result = mysqli_query($db, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('username sudah pernah ada')
        </script>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
        alert('password salah')
        </script>";
        return false;
    }

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan username ke database
    $query = "INSERT INTO user VALUES (
    '',
    '$username',
    '$password'
    )";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}




?>