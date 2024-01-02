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

         // A logout event when page refreshed
         if (performance.navigation.type === 1) logOut();

         // A logout event when url undo or reloaded
         if (performance.navigation.type === 2) logOut();

      <?php endif; ?>

   </script>

   <?php

   // Do auto db data store here      
   if ($is_login) {

      // Get user 
      $user_avg = isset($_COOKIE["sessionAverage"]) ? $_COOKIE["sessionAverage"] : null;
      $user_score = isset($_COOKIE["score"]) ? $_COOKIE["score"] : null;

      $grade_id = $_SESSION["user_grade"];
      $user_id = $_SESSION["user_id"];
      $server_id = $_SESSION["user_server"];
      $gender_id = $_SESSION["user_gender"];      

      // Identify value
      if ($user_avg != null && $user_score != null) {

         // Set last result to db
         require "./backend/user-result.php";
         insertResultToDb($user_avg, $user_score, $grade_id, $user_id, $server_id, $gender_id);

         // Remove the recent cookie
         setcookie("sessionAverage", null, time() - 3600);
         setcookie("score", null, time() - 3600);
      }

      echo "
         <script>
            alert(" . $user_avg . ");
         </script>
      ";
   }

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
            style="width: 180px; aspect-ratio: 1/1;">
         <?php if ($is_login): ?>
            <div class="position-absolute rounded-circle shadow p-2 bg-white" style="top: 0; right: 0; cursor: pointer;">
               <img src="images/png/gender-female.png" alt="char-change" style="width: 2rem;" class="liveToastBtn">
            </div>
         <?php endif; ?>
      </div>
      <?php if (!$is_login): ?>
         <small class="text-uppercase">Insert Your Name</small>
         <input type="text" placeholder="Unknown" class="text-center">
      <?php else: ?>
         <small class="text-uppercase">Welcome</small>
         <input type="text" placeholder="<?= $_SESSION['username'] ?>" class="text-center" disabled>
      <?php endif; ?>

      <!-- User Bar -->
      <div data-type="user-bar" class="container d-flex flex-wrap justify-content-center align-items-center gap-2">

         <div class="col" style="background-color: #fca3a0;">
            <small class="text-uppercase">scores</small>
            <p>86<small>pts</small></p>
         </div>
         <div class="col" style="background-color: #a4c6f6;">
            <small class="text-uppercase">accuracy</small>
            <p>25<small>%</small></p>
         </div>

         <?php if (!$is_login): ?>
            <div class="col" style="background-color: whitesmoke;">
               <small class="text-uppercase">locked</small>
               <p>???</p>
            </div>
            <div class="col" style="background-color: whitesmoke;">
               <small class="text-uppercase">locked</small>
               <p>???</p>
            </div>
         <?php else: ?>
            <div class="col" style="background-color: #f4d304;" id="leadboardBox">
               <small class="text-uppercase">leadboard</small>
               <p>#7</p>
            </div>
            <div class="col liveToastBtn" style="background-color: #04fed7;">
               <small class="text-uppercase">profile</small>
            </div>
         <?php endif; ?>

      </div>
      <!-- User Bar -->

      <a href="./play.php" class="text-uppercase fs-4">Start</a>
   </div>

   <!-- Toast Effect -->
   <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
         <div class="toast-header">
            <strong class="me-auto">User Profile</strong>
            <small>🎨</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
         </div>
         <div id="profile-data" class="py-3">
            <form class="row default" method="post" action="./backend/user-data.php">
               <div class="col px-4">
                  <small class="text-center d-inline-block w-100 text-uppercase" style="color: gray;">gender</small>
                  <select name="gender_type" class="d-inline-block w-100 py-2 mt-1 text-center">
                     <option value="0" class="my-2">None 👥</option>
                     <option value="1" class="my-2">Boy 🙋‍♂️</option>
                     <option value="2" class="my-2">Girl 💁‍♀️</option>
                  </select>
               </div>
               <div class="col px-4">
                  <small class="text-center d-inline-block w-100 text-uppercase" style="color: gray;">server</small>
                  <select name="server_type" class="d-inline-block w-100 py-2 mt-1 text-center">
                     <option value="1" class="my-2">None</option>
                     <option value="2" class="my-2">Asia</option>
                     <option value="3" class="my-2">America</option>
                     <option value="4" class="my-2">Europe</option>
                     <option value="5" class="my-2">Africa</option>
                  </select>
               </div>
               <div class="col-12 mt-3" style="padding: 0 80px">
                  <input type="submit" class="w-100 py-2 bg-success text-white border-0 rounded" value="Submit">
               </div>
            </form>
         </div>
         <hr class="m-auto" style="width: 80%;">
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

   <!-- Bootstrap Scripts -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"></script>

   <?php if ($is_login): ?>
      <script>
         const toastTriggers = document.querySelectorAll('.liveToastBtn');
         const toastLiveExample = document.querySelector('#liveToast');

         // Bootstrap UI
         const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);

         for (const toastTrigger of toastTriggers) {
            toastTrigger.addEventListener('click', () => {
               toastBootstrap.show();
            })
         }

         document.querySelector("#leadboardBox").onclick = () => {
            window.location.href = "./leadboard.php";
         }
      </script>
   <?php endif; ?>
   <!-- Bootstrap Scripts -->
</body>

</html>