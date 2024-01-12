<?php

// Resources
require "./backend/system.php";

// Db Auth
$auth->connectDb();

// Init recent session
session_start();

// Check state
$is_login = isset($_SESSION['login']) ? true : false;

// Do auto db data store here      
if ($is_login)
   $data = $auth->initUser();

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
         <?php if ($is_login): ?>
            <img id="player-character" class="rounded-circle" src="images/jpg/<?= $_SESSION["image_url"] ?>" alt="char"
               style="width: 180px; aspect-ratio: 1/1;">
            <div class="position-absolute rounded-circle shadow p-2 bg-white"
               style="bottom: 0; right: 0; cursor: pointer;">
               <img src="images/png/<?= $data["gender_url"] ?>" alt="<?= $data["gender_url"] ?>"
                  style="width: 2rem; aspect-ratio: 1/1; transform: scale(0.8);" class="liveToastBtn">
            </div>
            <div class="position-absolute rounded-circle shadow p-2 bg-white" style="bottom: 0; left: 0; cursor: pointer;">
               <img src="images/png/<?= $data["server_url"] ?>" alt="<?= $data["server_url"] ?>"
                  style="width: 2rem; aspect-ratio: 1/1;" class="liveToastBtn">
            </div>
         <?php endif; ?>
      </div>
      <?php if (!$is_login): ?>
         <img id="player-character" class="rounded-circle" src="images/jpg/player-icon-4.jpg" alt="char"
            style="width: 180px; aspect-ratio: 1/1;">
         <small class="text-uppercase">Insert Your Name</small>
         <input type="text" placeholder="Unknown" class="text-center">
      <?php else: ?>
         <small class="text-uppercase">Welcome</small>
         <input type="text" placeholder="<?= $_SESSION['username'] ?>" class="text-center" disabled>
      <?php endif; ?>

      <!-- User Bar -->
      <div data-type="user-bar" class="container row justify-content-center align-items-center gap-2">
         <?php if (!$is_login): ?>
            <div class="col-4 col-lg-2" style="background-color: whitesmoke;">
               <small class="text-uppercase">locked</small>
               <p>???</p>
            </div>
            <div class="col-4 col-lg-2" style="background-color: whitesmoke;">
               <small class="text-uppercase">locked</small>
               <p>???</p>
            </div>
            <div class="col-4 col-lg-2" style="background-color: whitesmoke;">
               <small class="text-uppercase">locked</small>
               <p>???</p>
            </div>
            <div class="col-4 col-lg-2" style="background-color: whitesmoke;">
               <small class="text-uppercase">locked</small>
               <p>???</p>
            </div>
         <?php else: ?>
            <div class="col-4 col-lg-2 liveToastBtn2" style="background-color: #a4c6f6;">
               <small class="text-uppercase">history</small>
            </div>
            <div class="col-4 col-lg-2" style="background-color: #f4d304;" id="leadboardBox">
               <small class="text-uppercase">leadboard</small>
            </div>
            <div class="col-4 col-lg-2 liveToastBtn" style="background-color: #04fed7;">
               <small class="text-uppercase">profile</small>
            </div>
         <?php endif; ?>

      </div>
      <!-- User Bar -->

      <a href="./play.php" class="text-uppercase fs-4">Start</a>
   </div>

   <!-- Toast Effect 1 -->
   <?php if ($is_login): ?>
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
         <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
               <strong class="me-auto">User Profile</strong>
               <small>🎨</small>
               <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div id="profile-data" class="py-3">
               <form class="row default" method="post" action="">
                  <div class="col px-4">
                     <input data-role="image-setter" type="hidden" name="image_type"
                        value="<?= $_SESSION["user_image"] ?>">
                     <small class="text-center d-inline-block w-100 text-uppercase" style="color: gray;">gender</small>
                     <select name="gender_type" class="d-inline-block w-100 py-2 mt-1 text-center">
                        <?php foreach ($data["genders"] as $gender): ?>
                           <option value="<?= $gender["gender_id"] ?>" class="my-2">
                              <?= $gender["gender_name"] ?>
                           </option>
                        <?php endforeach ?>
                     </select>
                  </div>
                  <div class="col px-4">
                     <small class="text-center d-inline-block w-100 text-uppercase" style="color: gray;">server</small>
                     <select name="server_type" class="d-inline-block w-100 py-2 mt-1 text-center">
                        <?php foreach ($data["servers"] as $server): ?>
                           <option value="<?= $server["server_id"] ?>" class="my-2">
                              <?= $server["server_name"] ?>
                           </option>
                        <?php endforeach ?>
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
               <?php foreach ($data["images"] as $image): ?>
                  <img data-id="<?= $image["image_id"] ?>" src="images/jpg/<?= $image["image_url"] ?>" alt="avatar"
                     class="w-25 rounded user-image" style="cursor: pointer;">
               <?php endforeach ?>
            </div>
         </div>
      </div>
   <?php endif ?>
   <!-- Toast Effect 1 -->

   <!-- Toast Effect 2 -->
   <?php if ($is_login): ?>
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
         <div id="liveToast2" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
               <strong class="me-auto">User Match</strong>
               <small>🔮</small>
               <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div id="profile-history" class="py-3">
               <div class="row default justify-content-center align-items-center gap-4">
                  <div class="col-4 col-lg-2 history-box" style="background-color: #fca3a0;">
                     <small class="text-uppercase">scores</small>
                     <p class="default">
                        <?= $_SESSION['userScore'] ?><small>pts</small>
                     </p>
                  </div>
                  <div class="col-4 col-lg-2 history-box" style="background-color: #a4c6f6;">
                     <small class="text-uppercase">accuracy</small>
                     <p class="default">
                        <?= $_SESSION['userAverage'] ?><small>%</small>
                     </p>
                  </div>
               </div>
            </div>
            <hr class="m-auto" style="width: 80%;">
            <p class="text-center mb-2 mt-3 text-uppercase">history ⏳</p>
            <div id="history-list" class="toast-body d-block my-2 px-3" style="gap: 8px; max-height: 400px;">

               <!-- History Bar -->
               <?php foreach ($data["histories"] as $history): ?>
                  <div class="container w-100 d-flex flex-column mb-2">
                     <small class="mb-1 text-uppercase text-black-50">
                        <?= $history["date"] ?>
                     </small>
                     <div class="d-flex w-100 default justify-content-start align-items-center gap-2">
                        <div class="history-box" style="background-color: #fca3a0; width: 100px;">
                           <small class="text-uppercase">scores</small>
                           <p class="default">
                              <?= $history["score"] ?><small>pts</small>
                           </p>
                        </div>
                        <div class="history-box" style="background-color: #a4c6f6; width: 100px;">
                           <small class="text-uppercase">accuracy</small>
                           <p class="default">
                              <?= $history["rate"] ?><small>%</small>
                           </p>
                        </div>
                        <div class="history-box" style="background-color: #ff6; width: 100px;">
                           <small class="text-uppercase">repeat</small>
                           <p class="default">
                              4<small>x</small>
                           </p>
                        </div>
                     </div>
                  </div>
               <?php endforeach ?>
               <!-- History Bar -->

            </div>
         </div>
      </div>
   <?php endif ?>
   <!-- Toast Effect 2 -->

   <!-- Bootstrap Scripts -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"></script>

   <?php if ($is_login): ?>
      <script>
         const toastTriggers = document.querySelectorAll('.liveToastBtn');
         const toastLive1 = document.querySelector('#liveToast');

         const toastTrigger2 = document.querySelector('.liveToastBtn2');
         const toastLive2 = document.querySelector('#liveToast2');

         // Bootstrap UI
         const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive1);
         const toastBootstrap2 = bootstrap.Toast.getOrCreateInstance(toastLive2);

         for (const toastTrigger of toastTriggers) {
            toastTrigger.addEventListener('click', () => {
               toastBootstrap.show();
            })
         }
         toastTrigger2.addEventListener('click', () => {
            toastBootstrap2.show();
         })

         // Leadboard redirect when clicked
         document.querySelector("#leadboardBox").onclick = () => {
            window.location.href = "./leadboard.php";
         }

         // Image setter for form necessity
         const imageHandler = document.querySelectorAll(".user-image");
         const targetHandler = document.querySelector("[data-role='image-setter']");

         for (const imageHandle of imageHandler) {
            imageHandle.addEventListener("click", () => {
               const val = imageHandle.getAttribute("data-id");
               targetHandler.setAttribute("value", val);
            })
         }
      </script>
   <?php endif; ?>
   <!-- Bootstrap Scripts -->
</body>

</html>