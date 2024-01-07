<?php

// Resource for: index.php

// Db auth
$db = connectDb();

// Get user value
$user_id = $_SESSION['user_id'];
$user_gender = isset($_POST['gender_type']) ? $_POST['gender_type'] : $_SESSION["user_gender"];
$user_server = isset($_POST['server_type']) ? $_POST['server_type'] : $_SESSION["user_server"];

// Modify user server and gender
$query = <<<SQL
   UPDATE user_data
   SET gender_id = :gender, server_id = :server
   WHERE user_id = :user;
SQL;

// Prepare
$statement = $db->prepare($query);
$statement->bindParam("gender", $user_gender);
$statement->bindParam("server", $user_server);
$statement->bindParam("user", $user_id);
$statement->execute();
$statement->closeCursor();

// Change data
$change_query = <<< SQL
   SELECT user_gender.gender_url, user_server.server_url FROM user_data
   JOIN user_gender ON user_gender.gender_id = user_data.gender_id
   JOIN user_server ON user_server.server_id = user_data.server_id
   WHERE user_data.user_id = :userId
SQL;

// Prepare modify
$statement = $db->prepare($change_query);
$statement->bindParam("userId", $user_id);
$statement->execute();

// Fetch value
$data = $statement->fetch();
$_SESSION["gender_url"] = $data["gender_url"];
$_SESSION["server_url"] = $data["server_url"];

?>