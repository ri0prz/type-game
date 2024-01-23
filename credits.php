<?php 
require "./backend/system.php";
session_start();
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

   <!-- Style -->
   <style>
      img {
         height: 80px;
         object-fit: contain;
      }
   </style>
</head>

<body>
   <?php $auth->userNavbar() ?>

   <div class="container d-flex justify-content-end align-items-center flex-column text-center" style="height: 8rem;"></div>

   <div class="container text-center">
      <div class="row">
         <div class="col m-3">
            <h1 class="text-uppercase fw-light text-black-50 mb-4 fs-3">Members</h1>
            <div class="row justify-content-center">
               <div class="col-lg-2 col-4">
                  <img src="images/png/icon-ergar.png" alt="icon" class="mb-2">
                  <p>Ergar</p>
               </div>
               <div class="col-lg-2 col-4">
                  <img src="images/png/icon-fariz.png" alt="icon" class="mb-2">
                  <p>Fariz</p>
               </div>
            </div>
         </div>
      </div>
      <div class="row m-3">
         <div class="col">
            <h1 class="text-uppercase fw-light text-black-50 mb-4 fs-3">Assets</h1>
            <div class="row justify-content-center align-items-center" style="gap: 40px;">
               <div class="col-lg-2 col-md-3 col d-flex flex-column justify-content-center align-items-center">
                  <img src="images/png/credit-freepik.png" alt="image">
                  <p class="m-2 f-poppins">Freepik</p>
               </div>
               <div class="col-lg-2 col-md-3 col d-flex flex-column justify-content-center align-items-center">
                  <img src="images/png/credit-gfonts.png" alt="image">
                  <p class="m-2 f-poppins">GFonts</p>
               </div>
               <div class="col-lg-2 col-md-3 col d-flex flex-column justify-content-center align-items-center">
                  <img src="images/png/credit-bootstrap.png" alt="image">
                  <p class="m-2 f-poppins">Bootstrap</p>
               </div>
            </div>
         </div>
      </div>
   </div>

   <footer class="fluid-container d-flex justify-content-center align-items-center" style="height: 5rem;">
      <small class="text-uppercase fw-light text-secondary">Created by Group 11</small>
   </footer>
</body>

</html>