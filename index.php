<?php

// Resources
include "./backend/config.php";

// Init recent session
session_start();

// Check state
$is_login = isset($_SESSION['login']) ? true : false;

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="shortcut icon" href="images/png/icon-logo.png" type="image/x-icon">
   <title>Type Game</title>

   <!-- Bootstrap + CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/index.css">

   <!-- Scripts -->
   <script type="module" src="js/template.js" defer></script>
   <script type="module" src="js/index.js" defer></script>

   <script>

      // Log out function
      const logOut = () => { 
         window.location.href = "./backend/logout.php";         
      }

      <?php if ($is_login): ?>

         // An event when page refreshed
         if (performance.navigation.type === 1) logOut();

         // An event when url undo or reloaded
         if (performance.navigation.type === 2) logOut();

      <?php endif; ?>

   </script>
   
   <?php 

      // Do auto db data store here      
      if ($is_login) echo "
         <script>
            alert(". $_SESSION['user_id'] .");
         </script>
      ";

   ?>

</head>

<body>

   <header
      class="fluid-container d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 bg-white">
      <nav class="d-flex justify-content-around align-items-center w-100 h-100 bg-white">
         <div class="left">
            <h1 class="fw-bold" style="font-size: 2rem;">t<span class="text-success">y</span>pe!</h1>
         </div>
         <div src="images/png/icon-bar.png" alt="mobile-tab" class="mobile-effect" style="width: 30px;"></div>
         <div class="right d-flex justify-content-center align-items-center" style="gap: 14px;">
            <a href="./" class="active">Home</a>
            <a href="./instruction.php">Instruction</a>
            <a href="./benefit.php">Benefit</a>
            <a href="./credits.php">Credits</a>

            <?php if (!$is_login): ?>
               <a href="./backend/register.php">Sign Up</a>
            <?php else: ?>
               <a href="./backend/logout.php">Logout</a>
            <?php endif; ?>
         </div>
      </nav>
   </header>

   <div id="profile" class="container d-flex justify-content-center align-items-center flex-column height-restore">
      <div class="position-relative">
         <img id="player-character" class="rounded-circle" src="images/jpg/player-icon-4.jpg" alt="char"
            style="width: 200px; aspect-ratio: 1/1;">
         <div class="position-absolute rounded-circle shadow p-2 bg-white" style="top: 0; right: 0; cursor: pointer;">
            <img src="images/png/icon-change.png" alt="char-change" style="width: 2rem;" id="liveToastBtn">
         </div>
      </div>
      <?php if (!$is_login): ?>
         <small class="text-uppercase">Insert Your Name</small>
         <input type="text" placeholder="Unknown" class="text-center">
      <?php else: ?>
         <small class="text-uppercase">Welcome</small>
         <input type="text" placeholder="<?= $_SESSION['username'] ?>" class="text-center" disabled>
      <?php endif; ?>
      <a href="./play.php" class="text-uppercase fs-4">Start</a>
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
            style="gap: 8px;">
            <img src="images/jpg/player-icon-1.jpg" alt="avatar" class="w-25 rounded" style="cursor: pointer;">
            <img src="images/jpg/player-icon-2.jpg" alt="avatar" class="w-25 rounded" style="cursor: pointer;">
            <img src="images/jpg/player-icon-3.jpg" alt="avatar" class="w-25 rounded" style="cursor: pointer;">
            <img src="images/jpg/player-icon-4.jpg" alt="avatar" class="w-25 rounded" style="cursor: pointer;">
         </div>
      </div>
   </div>
   <!-- Toast Effect -->

   <footer class="fluid-container d-flex justify-content-center align-items-center" style="height: 5rem;">
      <small class="text-uppercase fw-light text-secondary">
         <?= credit ?>
      </small>
   </footer>

   <!-- Bootstrap Scripts -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"></script>
   <script>
      const toastTrigger = document.getElementById('liveToastBtn')
      const toastLiveExample = document.getElementById('liveToast')

      if (toastTrigger) {
         const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
         toastTrigger.addEventListener('click', () => {
            toastBootstrap.show();
         })
      }

      console.log(performance.navigation.type);

   </script>
   <!-- Bootstrap Scripts -->
</body>

</html>