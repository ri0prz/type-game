<?php

// Get resource
require __DIR__ . "/system.php";

// Check the form
$auth->userRegister();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

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

    <!-- Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-4">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger-subtle">
                <strong class="me-auto">Error occured.</strong>
                <small>recently</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Username already taken.
            </div>
        </div>
    </div>
    <!-- Toast -->

    <div class="container d-flex flex-column justify-content-center align-items-center">
        <h1 class="fw-bold mb-4" style="font-size: 2rem;">t<span class="text-success">y</span>pe!</h1>
        <form action="" method="post" class="d-flex flex-column justify-content-center align-items-center">
            <label for="username">Username.</label>
            <input type="text" name="username" id="username" autocomplete="off" required>

            <label for="password">Password.</label>
            <input type="password" name="password" id="password" autocomplete="off" required>

            <label for="password">Re-type Password.</label>
            <input type="password" name="password2" id="password2" autocomplete="off" required>

            <button class="btn btn-success w-100 py-2" name="submit" type="submit">Register</button>
            <p style="word-spacing: -1px; color: darkgray;">Had account? <a href="./login.php"
                    class="text-success fw-bold text-uppercase">click me</a></p>
            <a href="../" class="btn w-100 py-2 btn-secondary">Back</a>
        </form>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script>
        const toastTrigger = document.getElementById('liveToastBtn');
        const toastLiveExample = document.getElementById('liveToast');
        const alertToast = () => {
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
            toastBootstrap.show();
        }
    </script>
    <!-- Bootstrap Script -->

    <?php if ($auth->userRegister() == 4): ?>
        <script>alertToast();</script>
    <?php endif; ?>

    <?php if ($auth->userRegister() == 5): ?>
        <script>alert("Incorrect password defined.");</script>
    <?php endif; ?>
</body>

</html>