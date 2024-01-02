<?php

// Resource
require __DIR__ . "/config.php";

// Init recent session
session_start();

// Db auth
$db = connectDb();

// Check login state
isLogin();

// Get user value
$user_id = $_SESSION['user_id'];
$user_gender = $_POST['gender_type'];
$user_server = $_POST['server_type'];

// Modify user server and gender
$query = <<< SQL
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

// Redirect
echo "<script> window.location.href = '../' </script>";

?>