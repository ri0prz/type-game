<?php

// Init recent session
session_start();

// Remove session state
$_SESSION = array();
session_destroy();

// Redirect
header("Location: ../");

?>