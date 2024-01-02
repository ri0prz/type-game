<?php

// Resource
require __DIR__ . "/config.php";

// Init recent session
session_start();

// Db auth
$db = connectDb();

// Check login state
isLogin();

// Fetch query
$query = "SELECT * FROM user_display";

// Get the result
$top_results = $db->query($query);

?>