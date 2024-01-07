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