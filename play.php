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
   <link rel="stylesheet" href="css/play.css">

   <!-- Scripts -->
   <script type="module" src="js/play.js" defer></script>

   <script>

      // Log out function
      const logOut = () => {
         window.location.href = './backend/logout.php';
      }

      // A logout event when page refreshed
      if (performance.navigation.type === 1) logOut();

      // A logout event when url undo or reloaded
      if (performance.navigation.type === 2) logOut();
      
   </script>
</head>

<body class="d-flex justify-content-center align-items-center flex-column">   
   <div class="container d-flex justify-content-center align-items-center flex-column" style="height: 100vh;">

      <!-- System -->
      <div class="container d-flex justify-content-center align-items-center flex-column">
         <h1 id="timer" class="mb-1">10s</h1>
         <small class="mb-2 text-black-50">type this below</small>
         <div id="word">
            <p id="sentence" style="display: none;">A giant fungus inside of my belly</p>
            <div id="system" class="fs-1 w-100 text-center d-flex justify-content-center align-items-center">
               <div id="system-container" class="w-75 text-body-tertiary"></div>
            </div>
         </div>
         <input type="text" id="typer" autofocus style="opacity: 0;" />
      </div>

      <!-- Result -->
      <div id="result-bar" class="conatiner w-100">
         <div class="container text-center expandable">
            <div class="row">
               <h1 class="text-uppercase fs-2 fw-light">Result Showcase</h1>
            </div>
            <div class="row justify-content-center align-items-center">
               <div class="col-lg-2 col-6 bg-warning-subtle m-4 mb-1 py-3 rounded saturation-effect">
                  <small class="default text-uppercase">Repetition</small>
                  <p id="repetition-tag" class="default fs-2 mt-1">1</p>
               </div>
               <div class="col-lg-2 col-6 bg-success-subtle m-4 mb-1 py-3 rounded saturation-effect">
                  <small class="default text-uppercase">Valuation</small>
                  <p id="average-tag" class="default fs-2 mt-1">0%</p>
               </div>
            </div>
            <div class="row mt-4 text-uppercase fade-effect">
               <p>Click the screen</p>
            </div>
         </div>
      </div>
   </div>
</body>

</html>