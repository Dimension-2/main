<?php
// my-project/admin/login.php
session_start(); // Start the session

// The config.php should be one level up, as it was in previous instructions
// If config.php is directly in 'admin' folder, use 'config.php'
// If config.php is in 'main' folder, use '../config.php'
require_once '../config.php'; // <--- IMPORTANT: This path might need adjustment based on your config.php location.
                             // If config.php is DIRECTLY in the same 'admin' folder as login.php, change to 'config.php'
                             // If it's in 'C:\xampp\htdocs\main\config.php', then '../config.php' is correct from 'admin/'

// Check if the user is already logged in, if yes then redirect to admin.php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: admin.php"); // Correct: admin.php is in the same directory (admin/)
    exit;
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

// Process form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Ensure you are selecting from the correct table, e.g., 'admin_users'
        $sql = "SELECT id, username, password FROM admin_users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, start a new session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // --- MODIFIED REDIRECTION FOR LOGIN SUCCESS MESSAGE ---
                            header("location: admin.php?status=loggedin_success");
                            exit;
                        } else{
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    if (isset($conn)) {
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin-styles.css">
    <style>
        body { font: 14px sans-serif; background-color: #f8f9fa; }
        .wrapper { width: 360px; padding: 20px; margin: 100px auto; background-color: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }

        /* --- CSS FOR SLIDE-AWAY MESSAGE --- */
        .alert.slide-fade-out {
            max-height: 150px; /* A reasonable starting height for the alert */
            opacity: 1;
            overflow: hidden; /* Ensures content doesn't spill during height animation */
            padding: 1rem 1.25rem; /* Standard Bootstrap alert padding */
            margin-bottom: 1rem; /* Standard Bootstrap alert margin */
            /* Define the transition properties for smooth animation */
            transition: max-height 0.7s ease-out, opacity 0.7s ease-out, padding 0.7s ease-out, margin 0.7s ease-out;
        }

        .alert.slide-fade-out.hidden {
            max-height: 0; /* Collapse height */
            opacity: 0; /* Fade out */
            padding-top: 0;
            padding-bottom: 0;
            margin-top: 0;
            margin-bottom: 0;
            border: 0; /* Remove border when collapsed */
        }
        /* --- END CSS --- */
    </style>
    </head>
<body>
    <div class="wrapper">
        <h2>Admin Login</h2>
        <?php
        // Display login error
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        // Display logout success message
        if(isset($_GET['status']) && $_GET['status'] == 'loggedout_success'){
            // MODIFIED: Removed Bootstrap's dismissible classes and close button for custom animation
            echo '<div class="alert alert-success" role="alert">
                    You have been successfully logged out.
                  </div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutAlert = document.querySelector('.alert.alert-success');

        if (logoutAlert) {
            // 1. Add the base class for our custom animation
            logoutAlert.classList.add('slide-fade-out');

            // 2. Set a timeout to trigger the slide-out and fade-out animation
            setTimeout(function() {
                logoutAlert.classList.add('hidden'); // This class triggers the CSS transition

                // 3. Remove the alert from the DOM *after* the animation completes
                logoutAlert.addEventListener('transitionend', function() {
                    logoutAlert.remove(); // Removes the element entirely from the page
                }, { once: true }); // Ensure the listener runs only once
            }, 3000); // 3000 milliseconds = 3 seconds before the animation starts
        }
    });
    </script>
</body>
</html>