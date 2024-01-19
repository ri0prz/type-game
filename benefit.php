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

   <!-- Scripts -->
   <script type="module" src="js/template.js" defer></script>

   <!-- Card Style -->
   <style>
      .benefit-card {
         width: 22rem;                      
         padding: 0;
         margin: 0;
         overflow: hidden;
      }
      .benefit-card > div > img {
         height: 20rem;
         object-fit: cover;
         box-shadow: 0 0 20px rgba(0, 0, 0, 0.04);
      }
   </style>
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
            <a href="./">Home</a>
            <a href="./instruction.php">Instruction</a>
            <a href="./benefit.php" class="active">Benefit</a>
            <a href="./credits.php">Credits</a>
         </div>
      </nav>
   </header>
   <div class="container d-flex justify-content-end align-items-center flex-column text-center" style="height: 16rem;">
      <h1 class="fw-bold" style="font-size: 2rem;">t<span class="text-success">y</span>pe!</h1>
      <p class="text-secondary">Game Benefits</p>
   </div>

   <div class="container d-flex justify-content-center align-items-start height-restore flex-wrap text-center w-75" style="height: inherit;">
      <div class="container benefit-card">
         <div class="card mb-3">
            <img src="images/jpg/image-typing-improve.jpg" class="card-img-top" alt="image">
            <div class="card-body">
               <h5 class="card-title text-secondary">Pace Improvement</h5>
               <p class="card-text px-2">This game is designed to improve players type skill faster.</p>
            </div>
         </div>
      </div>
      <div class="container benefit-card">
         <div class="card mb-3">
            <img src="images/jpg/image-typing-accuracy.jpg" class="card-img-top" alt="image">
            <div class="card-body">
               <h5 class="card-title text-secondary">Accuracy</h5>
               <p class="card-text">This game help users develop accurate typing habits.</p>
            </div>
         </div>
      </div>      
      <div class="container benefit-card">
         <div class="card mb-3">
            <img src="images/jpg/image-confidence.jpg" class="card-img-top" alt="image">
            <div class="card-body">
               <h5 class="card-title text-secondary">Confidence</h5>
               <p class="card-text">Users could gain confidence with ability, which affect impact on self-esteem.</p>
            </div>
         </div>
      </div>      
      <div class="container benefit-card">
         <div class="card mb-3">
            <img src="images/jpg/image-typing-education.jpg" class="card-img-top" alt="image">
            <div class="card-body">
               <h5 class="card-title text-secondary">Education</h5>
               <p class="card-text">Often used in educational, helping them become proficient in keyboarding.</p>
            </div>
         </div>
      </div>      
      <div class="container benefit-card">
         <div class="card mb-3">
            <img src="images/jpg/image-entertainment.jpg" class="card-img-top" alt="image">
            <div class="card-body">
               <h5 class="card-title text-secondary">Entertainment</h5>
               <p class="card-text">It provides a fun and engaging way to practice typing skills.</p>
            </div>
         </div>
      </div>      
   </div>
</body>

</html>