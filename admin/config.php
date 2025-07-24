<?php
// my-project/admin/config.php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Your MySQL username
define('DB_PASSWORD', '');     // Your MySQL password (often empty for XAMPP/WAMP)
//define('DB_NAME', 'my_project_db'); // The database you created

// Attempt to connect to MySQL database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>