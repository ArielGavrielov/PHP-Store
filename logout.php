<?php
// Initialize the session
session_start();

// Destroy the session.
unset($_SESSION["loggedin"]);
unset($_SESSION["id"]);
unset($_SESSION["username"]);
unset($_SESSION["name"]);
unset($_SESSION["admin"]);
 
// Redirect to login page
header("location: index.php");
exit;
?>