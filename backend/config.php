<?php

// Initialization
const 
host = "localhost",
port = "3306",
user = "typegame_admin",
pass = "admin",
location = "typegame_db";

// Authority
const
credit = "© Created by Group 4";

// User login test
function isLogin() {      
   if (!isset($_SESSION["user_id"])) header("Location: ../");
}

// Connection
function connectDb() {
   try {      
      return new PDO("mysql:localhost=".host.":".port.";dbname=".location, user, pass);
   } 
   catch (PDOException $err) {      
      return null;
   }
}

?>