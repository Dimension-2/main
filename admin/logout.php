<?php
// my-project/admin/logout.php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login.php"); // Correct: login.php is in the same directory (admin/)
exit;
?>