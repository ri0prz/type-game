<?php
session_start();
require 'function.php';

// Cek apakah button sudah di klik atau belum
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = mysqli_query($db, "SELECT * FROM user_data WHERE username = '$username'");

    // Cek username
    if (mysqli_num_rows($result) === 1) {

        // Cek password
        $checkPass = "SELECT * FROM user_data WHERE password = '$password'";
        if (readQuery($checkPass)) {

            // Session
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = getUser($username, $password)['user_id'];
            $_SESSION['username'] = $username;                                            

            // Redirect
            header('Location: ../');
            exit();
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

    <!-- Plugins -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">

    <!-- Styles -->
    <style>
        label {
            align-self: flex-start;
            color: gray;
        }

        input {
            border: none;
            border-bottom: 2px solid black;
            outline: none;
            padding: 8px 4px;
            margin-bottom: 28px;
        }

        button[type="submit"] {
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">
    <div class="toast-container position-fixed bottom-0 end-0 p-4">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger-subtle">
                <strong class="me-auto">Error occured.</strong>
                <small>recently</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Data defined is not found.
            </div>
        </div>
    </div>

    <div class="container d-flex flex-column justify-content-center align-items-center">
        <h1 class="fw-bold mb-4" style="font-size: 2rem;">t<span class="text-success">y</span>pe!</h1>
        <form action="" method="post" class="d-flex flex-column justify-content-center align-items-center">
            <label for="username">Username.</label>
            <input type="text" name="username" id="username" autocomplete="off">

            <label for="password">Password.</label>
            <input type="password" name="password" id="password" autocomplete="off">

            <button class="btn btn-primary w-100 py-2" name="submit" type="submit">Login</button>
        </form>
        <p style="word-spacing: -1px; color: darkgray;">Do register? <a href="register.php"
                class="text-primary fw-bold text-uppercase">click me</a></p>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script>
        const toastTrigger = document.getElementById('liveToastBtn')
        const toastLiveExample = document.getElementById('liveToast')
        const alertToast = () => {
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
            toastBootstrap.show();
        }        
    </script>
    <!-- Bootstrap Script -->

    <?php if (isset($error)): ?>
        <script>alertToast();</script>
    <?php endif; ?>
</body>

</html>