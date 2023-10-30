<?php

// Koneksi ke database
$db = mysqli_connect("localhost", "root", "", "typegame_db");

// Retrieve data from database
function getQuery($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) $rows[] = $row;
    return $rows;
}

// Baca isi yang ada didatabase
function readQuery($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    if ($result)
        return true;
    else
        return false;
}
?>