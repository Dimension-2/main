<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // Or your actual password if you set one
define('DB_NAME', 'main_db');

/* Attempt to connect to MySQL database */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// Set headers to prevent XSS
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");

// For production, force HTTPS
if ($_SERVER['HTTPS'] != "on" && $_SERVER['SERVER_NAME'] != 'localhost') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}
/**
 * Fetches content from main_file_content table
 * @param mysqli $conn Database connection
 * @param string $section The section identifier
 * @param string $content_type Type of content ('text', 'image', 'video')
 * @return array|null Associative array of content or null if not found
 */
function getContent($conn, $section, $content_type)
{
    $sql = "SELECT * FROM main_file_content WHERE section = ? AND content_type = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($conn));
        return null;
    }

    mysqli_stmt_bind_param($stmt, "ss", $section, $content_type);
    if (!mysqli_stmt_execute($stmt)) {
        error_log("Execute failed: " . mysqli_stmt_error($stmt));
        return null;
    }

    $result = mysqli_stmt_get_result($stmt);
    $content = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    return $content;
}


// You can add other utility functions here as needed
?>