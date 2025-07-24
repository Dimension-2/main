<?php
// my-project/admin/login.php
session_start(); // Start the session

// The config.php should be one level up, as it was in previous instructions
// If config.php is directly in 'admin' folder, use 'config.php'
// If config.php is in 'main' folder, use '../config.php'
require_once '../config.php'; // <--- IMPORTANT: This path might need adjustment based on your config.php location.
                              // If config.php is DIRECTLY in the same 'admin' folder as login.php, change to 'config.php'
                              // Based on your original prompt, it was 'admin/config.php', so it should be this path.
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
        // This query is fine if 'admin_users' is your table for admins
        $sql = "SELECT id, username, password FROM admin_users WHERE username = ?";

        // Fix: Use $conn instead of $link
        if($stmt = mysqli_prepare($conn, $sql)){ // <--- CHANGED: $link to $conn
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

                            header("location: admin.php"); // Correct: admin.php is in the same directory (admin/)
                            exit; // Important to exit after header redirect
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
    // Fix: Close $conn instead of $link, and only if it's open
    if (isset($conn)) {
        mysqli_close($conn); // <--- CHANGED: $link to $conn
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
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Admin Login</h2>
        <?php
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
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
</body>
</html>