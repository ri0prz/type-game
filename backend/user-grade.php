<?php

// Resource from: index.php

// Db auth
$db = connectDb();

// Init
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

?>