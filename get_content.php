<?php

// This file defines the getContent() function.

// Ensure config.php is included to get the database connection ($conn)
// Since config.php and get_content.php are in the SAME folder, use 'config.php' directly.
if (!isset($conn)) {
    require_once 'config.php';
}

function getContent($key) {
    global $conn; // Use the $conn variable defined in config.php

    // Prepare a select statement
    $sql = "SELECT content_text FROM website_content WHERE content_key = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_key);

        // Set parameters
        $param_key = $key;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            mysqli_stmt_store_result($stmt);

            // Check if content_key exists
            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $content_text);

                // Fetch result
                if (mysqli_stmt_fetch($stmt)) {
                    return $content_text;
                }
            }
        } else {
            // Log a more specific error for execution issues
            error_log("Error executing query for content key: " . $key . " - " . mysqli_error($conn));
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // Log a more specific error for prepare issues
        error_log("Error preparing query for content key: " . $key . " - " . mysqli_error($conn));
    }

    // Fallback for missing content key or database error
    // This will return a default message and log the missing key
    error_log("Missing content key or database error: " . $key);
    return "Content for '{$key}' is missing or could not be retrieved.";
}

?>