<?php require "./backend/user-top.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Leadboard</title>

   <!-- Bootstrap + CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/leaderboard.css">
</head>

<body>
   <div class="container d-flex flex-column justify-content-center align-items-center height-restore">
      <div
         class="container d-flex flex-column justify-content-start align-items-center height-restore"
         style="height: 34rem;">

         <div class="container text-center">            
            <h1 class="fw-bold" style="font-size: 2rem;">t<span class="text-success">y</span>pe!</h1>
            <p class="text-secondary default">Global Leadboard</p>
         </div>

         <div class="container d-flex flex-column justify-content-start align-items-center p-4 gap-2 mb-4"
            style="max-height: 40rem; overflow-y: scroll; scrollbar-width: none; max-width: 60rem;">

            <?php foreach ($top_results as $index => $result): ?>
               <!-- User Interface -->
               <div class="row container py-2" style="max-width: 800px;">
                  <div class="col d-flex align-items-center justify-content-center" style="max-width: 20%;">
                     <img id="player-character" class="rounded-circle" src="images/jpg/player-icon-4.jpg" alt="char"
                        style="width: inherit; aspect-ratio: 1/1; max-width: 120px; min-width: 70px;">
                  </div>
                  <div class="col d-flex align-items-start justify-content-center flex-column"
                     style="width: 90%; overflow: hidden;">
                     <small class="text-uppercase text-black-50 mb-2" data-title="<?= $result["grade"] ?>">
                        <span><?= ++$index ?> <span class="d-none d-sm-inline-block">• <?= $result["grade"] ?></span></span>
                     </small>
                     <p class="default fs-4"
                        style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: inherit;">
                        <?= $result["username"] ?>
                     </p>
                  </div>

                  <!-- Tab and Desktop -->
                  <div data-type="user-valuation"
                     class="col d-flex align-items-center justify-content-end d-none d-md-flex" style="max-width: 60%;">
                     <div class="col" style="background-color: gainsboro;">
                        <small class="text-uppercase">rate</small>
                        <p class="default">
                           <?= $result["rate"] ?><small>%</small>
                        </p>
                     </div>
                     <div class="col" style="background-color: whitesmoke;">
                        <small class="text-uppercase">value</small>
                        <p class="default">
                           <?= $result["score"] ?><small>pts</small>
                        </p>
                     </div>
                  </div>

                  <!-- Mobile -->
                  <div data-type="user-valuation" class="col d-flex align-items-center justify-content-end d-md-none"
                     style="max-width: 60%;">
                     <div class="col" style="background-color: whitesmoke;">
                        <p class="default">95<small>%</small></p>
                        <hr class="default my-2" style="width: 50%;">
                        <p class="default">74<small>pts</small></p>
                     </div>
                  </div>
               </div>
               <!-- User Interface -->
            <?php endforeach ?>

         </div>

         <div class="container text-center">
            <p class="text-secondary default">You are on the <b>#7</b> board!</p>
            <a href="./" class="d-block bg-success text-white text-uppercase p-2 mt-3 position-relative start-50 rounded" style="transform: translateX(-50%); width: 100px;">Back</a>
         </div>

      </div>
   </div>
</body>

</html>