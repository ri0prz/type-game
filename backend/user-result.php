<?php

// Resource for: index.php

// Db auth
$db = connectDb();

// Check login state
isLogin();

function insertResultToDb($user_avg, $user_score, $grade_id, $user_id, $user_server, $user_gender) {

   global $db;

   // Set query
   $query = <<< SQL
      INSERT INTO `valuation_user` 
         (`valuation_id`, `valuation_rate`, `valuation_score`, `grade_id`, `user_id`, `gender_id`, `server_id`) 
      VALUES 
         (NULL, ?, ?, ?, ?, ?, ?);
   SQL;

   // Prepare
   $statement = $db->prepare($query);
   $statement->execute([$user_avg, $user_score, $grade_id, $user_id, $user_gender, $user_server]);

   echo "<script> alert('COOL!!') </script>";
}

?>