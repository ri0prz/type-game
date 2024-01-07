<?php

// Resource from: index.php

// Db auth
$db = connectDb();

function insertResultToDb($user_avg, $user_score, $grade_id, $user_id, $user_server, $user_gender)
{

   global $db;

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

}

?>