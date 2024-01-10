<?php

class Database
{

   // Initialization
   private ?string
   $host = null,
   $port = null,
   $user = null,
   $password = null,
   $location = null;

   // Constructor
   public function __construct($host, $port, $user, $password, $location)
   {
      $this->host = $host;
      $this->port = $port;
      $this->user = $user;
      $this->password = $password;
      $this->location = $location;
   }

   // Connection
   public function connectDb()
   {
      try {
         return new PDO(
            "mysql:host={$this->host}:{$this->port};dbname={$this->location}",
            $this->user,
            $this->password
         );
      } catch (PDOException $err) {
         return null;
      }
   }


   // Login operation
   public function userLogin($username, $password)
   {
      // Init
      $db = $this->connectDb();

      // Identify
      $query = <<<SQL
         SELECT user_data.*, valuation_user.grade_id, user_image.image_url 
         FROM user_data
         JOIN valuation_user 
         ON valuation_user.user_id = user_data.user_id
         JOIN user_image 
         ON user_image.image_id = user_data.image_id
         WHERE username = :user 
         AND password = :pass
      SQL;

      $result = $db->prepare($query);
      $result->bindParam("user", $username);
      $result->bindParam("pass", $password);
      $result->execute();

      // Check user validation
      if ($data = $result->fetch()) {

         // Set user in session fetch
         session_start();

         $_SESSION['username'] = $username;
         $_SESSION['user_id'] = $data['user_id'];
         $_SESSION['user_server'] = $data['server_id'];
         $_SESSION['user_gender'] = $data['gender_id'];
         $_SESSION['user_grade'] = $data['grade_id'];
         $_SESSION['user_image'] = $data['image_id'];
         $_SESSION['image_url'] = $data['image_url'];
         $_SESSION['login'] = true;

         // Redirect
         header('Location: ../');
         exit();
      }
      return;
   }

   // Register operation
   public function userRegister($username, $password, $password2)
   {
      // Init
      $db = $this->connectDb();

      // Check username redundant
      $check_query = "SELECT * FROM user_data WHERE username = :user";

      $check_statement = $db->prepare($check_query);
      $check_statement->bindParam("user", $username);
      $check_statement->execute();

      if ($check_statement->fetch()) {
         $is_user_exist = true;
         return 8;
      }

      // Check password retype
      if ($password2 != $password) {
         $is_pass_diff = true;
         return 9;
      }

      // Insert data
      $send_query = <<<SQL
         INSERT INTO user_data (username, password)
         VALUES (:user, :pass);
      SQL;

      $statement = $db->prepare($send_query);
      $statement->bindParam("user", $username);
      $statement->bindParam("pass", $password);
      $statement->execute();

      // Redirect and start session   
      echo "
         <script>
            alert('Account created!');
            document.location.href = './login.php';
         </script>
      ";
      exit();
   }

   // Insert data operation after play
   public function insertResultToDb($user_avg, $user_score, $grade_id, $user_id, $user_server, $user_gender)
   {
      // Init
      $db = $this->connectDb();

      $query = <<<SQL
         INSERT INTO `valuation_user` 
            (`valuation_id`, `valuation_rate`, `valuation_score`, `grade_id`, `user_id`, `gender_id`, `server_id`) 
         VALUES 
            (NULL, :userAvg, :userScore, :gradeId, :userId, :userGender, :userServer);

         DELETE FROM `valuation_user` WHERE (valuation_rate = 0 OR valuation_score = 0)
         AND user_id = :userId;
      SQL;

      // Prepare
      $statement = $db->prepare($query);
      $statement->bindParam("userAvg", $user_avg);
      $statement->bindParam("userScore", $user_score);
      $statement->bindParam("gradeId", $grade_id);
      $statement->bindParam("userId", $user_id);
      $statement->bindParam("userGender", $user_gender);
      $statement->bindParam("userServer", $user_server);

      // Execute
      $statement->execute();
      $statement->closeCursor();

      // Recreate view
      $view_query = <<<SQL
         DROP VIEW IF EXISTS user_detail, user_display;
         CALL dbViews();
      SQL;

      // Execute view
      $db->exec($view_query);

      // Remove the recent cookie
      setcookie("sessionAverage", null, time() - 3600);
      setcookie("score", null, time() - 3600);

   }

   // User data grading
   public function userGrading()
   {
      // Init
      $db = $this->connectDb();

      // Get data
      $user_id = $_SESSION["user_id"];

      // Fetch query
      $get_query = "SELECT * FROM user_display WHERE user_id = :userId";

      // Prepare first query
      $statement = $db->prepare($get_query);
      $statement->bindParam("userId", $user_id);
      $statement->execute();

      // Identify the data for grading
      if ($data = $statement->fetch()) {

         // Set user value
         $user_avg = $data["rate"];
         $user_score = $data["score"];

         $_SESSION['userAverage'] = $user_avg;
         $_SESSION['userScore'] = $user_score;

         // Set another query   
         $grade_query = <<<SQL
            CALL gradeUpdate(:avg, :score, :userId)
         SQL;

         // Prepare grade query
         $grade_statement = $db->prepare($grade_query);
         $grade_statement->bindParam("avg", $user_avg);
         $grade_statement->bindParam("score", $user_score);
         $grade_statement->bindParam("userId", $user_id);
         $grade_statement->execute();

      }
   }

   // User data fetching
   public function getUserData()
   {
      // Init
      $db = $this->connectDb();

      // Get user value
      $user_id = $_SESSION['user_id'];
      $user_gender = isset($_POST['gender_type']) ? $_POST['gender_type'] : $_SESSION["user_gender"];
      $user_server = isset($_POST['server_type']) ? $_POST['server_type'] : $_SESSION["user_server"];
      $user_image = isset($_POST['image_type']) ? $_POST['image_type'] : $_SESSION["user_image"];

      // Modify user server and gender
      $query = <<<SQL
         UPDATE user_data
         SET gender_id = :gender, server_id = :server, image_id = :image
         WHERE user_id = :user;
      SQL;

      // Prepare
      $statement = $db->prepare($query);
      $statement->bindParam("gender", $user_gender);
      $statement->bindParam("server", $user_server);
      $statement->bindParam("image", $user_image);
      $statement->bindParam("user", $user_id);
      $statement->execute();
      $statement->closeCursor();

      // Change data
      $change_query = <<<SQL
         SELECT user_gender.*, user_server.*
         FROM user_data
         JOIN user_gender 
         ON user_gender.gender_id = user_data.gender_id
         JOIN user_server 
         ON user_server.server_id = user_data.server_id
         WHERE user_data.user_id = :userId
      SQL;

      // Prepare modify
      $statement = $db->prepare($change_query);
      $statement->bindParam("userId", $user_id);
      $statement->execute();

      // Fetch value to change data session
      $data = $statement->fetch();
      $_SESSION["gender_url"] = $data["gender_url"];
      $_SESSION["server_url"] = $data["server_url"];
      $_SESSION["user_gender"] = $data["gender_id"];
      $_SESSION["user_server"] = $data["server_id"];

      // Close statement
      $statement->closeCursor();

      // Get user data of gender, server, and appearance
      $gender_query = "SELECT * FROM user_gender";
      $server_query = "SELECT * FROM user_server";
      $image_query = "SELECT * FROM user_image";

      // Exec data query
      $user_genders = $db->query($gender_query);
      $user_servers = $db->query($server_query);
      $user_images = $db->query($image_query);

      $server_url = $_SESSION["server_url"];
      $gender_url = $_SESSION["gender_url"];

      return [
         'genders' => $user_genders,
         'servers' => $user_servers,
         'images' => $user_images,
         'server_url' => $server_url,
         'gender_url' => $gender_url
      ];
   }

   public function initUser()
   {
      // Prevention   
      echo "
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
      ";

      // Get user 
      $user_avg = isset($_COOKIE["sessionAverage"]) ? $_COOKIE["sessionAverage"] : null;
      $user_score = isset($_COOKIE["score"]) ? $_COOKIE["score"] : null;

      // Identify value
      if ($user_avg != null && $user_score != null)
         $this->insertResultToDb($user_avg, $user_score, $_SESSION["user_grade"], $_SESSION["user_id"], $_SESSION["user_server"], $_SESSION["user_gender"]);

      // Update grade
      $this->userGrading();

      // Return data
      return $this->getUserData();
   }

   public function getLeadboardData()
   {
      // Init
      $db = $this->connectDb();

      // Get recent session
      session_start();

      // Fetch query
      $query = "SELECT * FROM user_display";

      // Get the result
      $top_results = $db->query($query);      
      return $top_results;
   }

}

// Make db object
$auth = new Database("localhost", "3306", "typegame_admin", "admin", "typegame_db");

?>