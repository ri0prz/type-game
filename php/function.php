<?php

// Koneksi ke database
$db = mysqli_connect("localhost", "root", "", "typegame");

// Baca isi yang ada didatabase
function addQuery($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function readQuery($query)
{
    global $db;
    $result = mysqli_query($db, $query);    
    if ($result) return true;
    else return false;
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
        alert('Username already taken.')
        </script>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
        alert('Incorrect password.')
        </script>";
        return false;
    }

    // Tambahkan username ke database
    $query = "INSERT INTO user (id, username, password, gender_id, server_id) VALUES (
    '',
    '$username',
    '$password',
    1,
    1
    )";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}
?>