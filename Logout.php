<?php
// logout.php
session_start(); // Start the session

// Destroy the session to log out the user
session_destroy();

// Redirect to the login page (or any other page)
header("Location: index.php");
exit();
?>
