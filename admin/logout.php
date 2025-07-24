<?php
// my-project/admin/logout.php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page with a success message parameter
header("location: login.php?status=loggedout_success");
exit;
?>