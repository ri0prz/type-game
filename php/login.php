<?php
session_start();
require 'function.php';

// cek apakah button sudah di klik atau belum
if (isset($_POST['submit'])){
=======
// Cek apakah button sudah di klik atau belum
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($db, "SELECT * FROM user WHERE username = '$username'");

// cek username
if(mysqli_num_rows($result) === 1){
    // Cek username
    if (mysqli_num_rows($result) === 1) {

        // Cek password
        $row = mysqli_fetch_assoc($result);
        if (readQuery("SELECT * FROM user WHERE password = '$password'")) {

            // Session
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;

            // Redirect
            header('Location: ../');
            exit();
        }
    }
}
$error = true;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<?php if(isset($error)) : ?>
<p style="color='red'">password/username salah bro</p>
    <?php endif; ?>
    <div class="container">
        <form action="" method="post" class="form">
            <label for="username">Username : </label>
            <input type="text" name="username" id="username" placeholder="Username" autocomplete="none"><br>

            <label for="password">Password : </label>
            <input type="password" name="password" id="password" placeholder="password" autocomplete="none">

        <button type="submit" name="submit" class="button">Login!!!</button>
        </form>
        <p class="text">belum punya akun?Daftar <a href="register.php">Disini</a>.</p>
    </div>
</body>
</html>