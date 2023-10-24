<?php

// Determine user auth state
$login_state = false;
session_start();
if (isset($_SESSION['login']))
  $login_state = true;

$name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
echo "<script>
  alert('Hello, $name');  
  </script>";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="shortcut icon" href="images/png/icon-logo.png" type="image/x-icon" />
  <title>Type Game</title>

  <!-- Bootstrap + CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/index.css" />

  <!-- Scripts -->
  <script type="module" src="js/template.js" defer></script>
  <script type="module" src="js/index.js" defer></script>
</head>

<body>
  <header
    class="fluid-container d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 bg-white">
    <nav class="d-flex justify-content-around align-items-center w-100 h-100 bg-white">
      <div class="left">
        <h1 class="fw-bold" style="font-size: 2rem">
          t<span class="text-success">y</span>pe!
        </h1>
      </div>
      <div src="images/png/icon-bar.png" alt="mobile-tab" class="mobile-effect" style="width: 30px"></div>
      <div class="right d-flex justify-content-center align-items-center" style="gap: 14px">
        <a href="./" class="active">Home</a>
        <a href="./instruction.html">Instruction</a>
        <a href="./benefit.html">Benefit</a>
        <a href="./credits.html">Credits</a>

        <!-- Check state -->
        <?php if (!$login_state): ?>
          <a href="php/login.php">Login</a>
        <?php else: ?>
          <a href="php/logout.php">Logout</a>
        <?php endif; ?>

      </div>
    </nav>
  </header>
  <div id="profile" class="container d-flex justify-content-center align-items-center flex-column height-restore">
    <div class="position-relative">
      <img id="player-character" class="rounded-circle" src="images/jpg/player-icon-4.jpg" alt="char"
        style="width: 200px; aspect-ratio: 1/1" />
      <div class="position-absolute rounded-circle shadow p-2 bg-white" style="top: 0; right: 0; cursor: pointer">
        <img src="images/png/icon-change.png" alt="char-change" style="width: 2rem" id="liveToastBtn" />
      </div>
    </div>
    <small class="text-uppercase">Insert Your Name</small>
    <input type="text" placeholder="Unknown" class="text-center" />
    <a href="./play.html" class="text-uppercase fs-4">Start</a>
  </div>

  <!-- Toast Effect -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <strong class="me-auto">Avatar List</strong>
        <small>🎨</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div id="character-list" class="toast-body d-flex justify-content-center align-items-start flex-wrap"
        style="gap: 8px">
        <img src="images/jpg/player-icon-1.jpg" alt="avatar" class="w-25 rounded" style="cursor: pointer" />
        <img src="images/jpg/player-icon-2.jpg" alt="avatar" class="w-25 rounded" style="cursor: pointer" />
        <img src="images/jpg/player-icon-3.jpg" alt="avatar" class="w-25 rounded" style="cursor: pointer" />
        <img src="images/jpg/player-icon-4.jpg" alt="avatar" class="w-25 rounded" style="cursor: pointer" />
      </div>
    </div>
  </div>
  <!-- Toast Effect -->

  <footer class="fluid-container d-flex justify-content-center align-items-center" style="height: 5rem">
    <small class="text-uppercase fw-light text-secondary">© Created by Group 5</small>
  </footer>

  <!-- Bootstrap Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script>
    const toastTrigger = document.getElementById("liveToastBtn");
    const toastLiveExample = document.getElementById("liveToast");

    if (toastTrigger) {
      const toastBootstrap =
        bootstrap.Toast.getOrCreateInstance(toastLiveExample);
      toastTrigger.addEventListener("click", () => {
        toastBootstrap.show();
      });
    }
  </script>
  <!-- Bootstrap Script -->
</body>

</html>