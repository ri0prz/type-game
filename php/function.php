<?php

// Koneksi ke database
$db = mysqli_connect("localhost", "root", "", "typegame_db");

// Retrieve data from database
function getQuery($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result))
        $rows[] = $row;
    return $rows;
}

// Read data from db
function readQuery($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    if ($result) return true;
    else return false;
}

// Retrieve user data from database
function getUser($username, $password)
{
    global $db;
    $findId = "SELECT * FROM user_data WHERE username = '$username' AND password = '$password'";
    $currentUserId = getQuery($findId);
    $userId = null;
    foreach ($currentUserId as $id)
        $userId = $id;
    return $userId;
}

// Retrieve user data from database by id
function getUserById($user_id)
{
    global $db;
    $query = "SELECT * FROM user_data WHERE user_id = $user_id";
    $currentUserId = getQuery($query);
    $userId = null;
    foreach ($currentUserId as $id)
        $userId = $id;
    return $userId;
}

// Insert user game score into db
function addScoreIntoDatabase($user_id, $user_score_total, $user_score_average)
{
    global $db;

    $initial = getUserById($user_id);
    $user_gender = $initial['gender_id'];
    $user_server = $initial['server_id'];

    $query = "INSERT INTO `valuation_user` 
    (`valuation_id`, `valuation_rate`, `valuation_score`, `grade_id`, `user_data_user_id`, `gender_id`, `server_id`) VALUES 
    (NULL, '$user_score_average', '$user_score_total', '1', '$user_id', '$user_gender', '$user_server')";
    mysqli_query($db, $query);

    $_COOKIE['sessionAverage'] = 0;
    $_COOKIE['score'] = 0;
    return;
}
?>