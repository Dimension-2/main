<?php
// my-project/admin/admin.php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php"); // Correct: login.php is in the same directory (admin/)
    exit;
}

// Include config.php to get the database connection ($conn)
require_once '../config.php'; // Adjust path based on your project structure

// Function to fetch all content keys for the dropdown
function getAllContentKeys($conn) {
    $keys = [];
    $sql = "SELECT content_key FROM website_content ORDER BY content_key ASC";
    if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $keys[] = $row['content_key'];
        }
        mysqli_free_result($result);
    }
    return $keys;
}

// Get all content keys for the dropdown
$allContentKeys = getAllContentKeys($conn);

// Variables for form handling (initial values)
$selected_key = '';
$current_content = '';
$message = ''; // To display success or error messages

// Handle form submission for content update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_content'])) {
    $selected_key = $_POST['content_key'];
    $new_content_text = $_POST['new_content_text'];
    $admin_username = $_SESSION["username"]; // Get the logged-in admin's username

    // Fetch the old content text before updating
    $old_content_sql = "SELECT content_text FROM website_content WHERE content_key = ?";
    if ($stmt_old = mysqli_prepare($conn, $old_content_sql)) {
        mysqli_stmt_bind_param($stmt_old, "s", $selected_key);
        mysqli_stmt_execute($stmt_old);
        mysqli_stmt_store_result($stmt_old);
        $old_content_text = '';
        if (mysqli_stmt_num_rows($stmt_old) == 1) {
            mysqli_stmt_bind_result($stmt_old, $old_content_text);
            mysqli_stmt_fetch($stmt_old);
        }
        mysqli_stmt_close($stmt_old);
    }

    // Update the content in website_content table
    $update_sql = "UPDATE website_content SET content_text = ? WHERE content_key = ?";
    if ($stmt_update = mysqli_prepare($conn, $update_sql)) {
        mysqli_stmt_bind_param($stmt_update, "ss", $new_content_text, $selected_key);
        if (mysqli_stmt_execute($stmt_update)) {
            $message = "<div class='alert alert-success'>Content for '{$selected_key}' updated successfully!</div>";

            // Log the change in content_history table
            $log_sql = "INSERT INTO content_history (content_key, old_content_text, new_content_text, changed_by) VALUES (?, ?, ?, ?)";
            if ($stmt_log = mysqli_prepare($conn, $log_sql)) {
                mysqli_stmt_bind_param($stmt_log, "ssss", $selected_key, $old_content_text, $new_content_text, $admin_username);
                mysqli_stmt_execute($stmt_log);
                mysqli_stmt_close($stmt_log);
            } else {
                error_log("Failed to prepare history log statement: " . mysqli_error($conn));
            }

            // After successful update, fetch the new current content for display
            $current_content = $new_content_text;

        } else {
            $message = "<div class='alert alert-danger'>Error updating content: " . mysqli_error($conn) . "</div>";
        }
        mysqli_stmt_close($stmt_update);
    } else {
        $message = "<div class='alert alert-danger'>Error preparing update statement: " . mysqli_error($conn) . "</div>";
    }
}

// Handle request to load content for a selected key (e.g., via AJAX or form select change)
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['key'])) {
    $selected_key = $_GET['key'];
    $sql = "SELECT content_text FROM website_content WHERE content_key = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $selected_key);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $current_content);
            mysqli_stmt_fetch($stmt);
        } else {
            $current_content = "Content not found.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $current_content = "Database error fetching content.";
    }
    // If this is an AJAX request, echo the content and exit
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo $current_content;
        exit;
    }
}

// Fetch content history for display
$content_history = [];
$history_sql = "SELECT id, content_key, old_content_text, new_content_text, changed_by, changed_at FROM content_history ORDER BY changed_at DESC LIMIT 20"; // Limit for display
if ($result = mysqli_query($conn, $history_sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $content_history[] = $row;
    }
    mysqli_free_result($result);
} else {
    error_log("Error fetching content history: " . mysqli_error($conn));
}

// Handle "Clear History"
if (isset($_POST['clear_history'])) {
    $truncate_sql = "TRUNCATE TABLE content_history";
    if (mysqli_query($conn, $truncate_sql)) {
        $message = "<div class='alert alert-info'>Content history cleared successfully!</div>";
        $content_history = []; // Clear array as well
    } else {
        $message = "<div class='alert alert-danger'>Error clearing history: " . mysqli_error($conn) . "</div>";
    }
}

// Handle "Redo" (revert last change for a specific key)
if (isset($_POST['redo_last_change']) && isset($_POST['history_id_to_redo'])) {
    $history_id_to_redo = $_POST['history_id_to_redo'];

    // 1. Fetch the specific history entry
    $fetch_history_sql = "SELECT content_key, old_content_text, new_content_text FROM content_history WHERE id = ?";
    if ($stmt_fetch_history = mysqli_prepare($conn, $fetch_history_sql)) {
        mysqli_stmt_bind_param($stmt_fetch_history, "i", $history_id_to_redo);
        mysqli_stmt_execute($stmt_fetch_history);
        mysqli_stmt_store_result($stmt_fetch_history);

        if (mysqli_stmt_num_rows($stmt_fetch_history) == 1) {
            mysqli_stmt_bind_result($stmt_fetch_history, $redo_key, $redo_old_text, $redo_new_text);
            mysqli_stmt_fetch($stmt_fetch_history);

            // 2. Update website_content with the old_content_text from history
            // First, get current text to log the "redo" itself
            $current_text_for_redo_log = '';
            $get_current_sql = "SELECT content_text FROM website_content WHERE content_key = ?";
            if ($stmt_get_current = mysqli_prepare($conn, $get_current_sql)) {
                mysqli_stmt_bind_param($stmt_get_current, "s", $redo_key);
                mysqli_stmt_execute($stmt_get_current);
                mysqli_stmt_bind_result($stmt_get_current, $current_text_for_redo_log);
                mysqli_stmt_fetch($stmt_get_current);
                mysqli_stmt_close($stmt_get_current);
            }

            $revert_sql = "UPDATE website_content SET content_text = ? WHERE content_key = ?";
            if ($stmt_revert = mysqli_prepare($conn, $revert_sql)) {
                mysqli_stmt_bind_param($stmt_revert, "ss", $redo_old_text, $redo_key); // Revert to old text
                if (mysqli_stmt_execute($stmt_revert)) {
                    $message = "<div class='alert alert-info'>Content for '{$redo_key}' reverted successfully!</div>";

                    // Log the "redo" action as a new change
                    $log_redo_sql = "INSERT INTO content_history (content_key, old_content_text, new_content_text, changed_by) VALUES (?, ?, ?, ?)";
                    if ($stmt_log_redo = mysqli_prepare($conn, $log_redo_sql)) {
                        $admin_username = $_SESSION["username"];
                        // FIX APPLIED HERE: Assign expression to a variable before binding
                        $redo_log_changed_by = $admin_username . " (Redo)";
                        mysqli_stmt_bind_param($stmt_log_redo, "ssss", $redo_key, $current_text_for_redo_log, $redo_old_text, $redo_log_changed_by);
                        mysqli_stmt_execute($stmt_log_redo);
                        mysqli_stmt_close($stmt_log_redo);
                    } else {
                        error_log("Failed to prepare redo log statement: " . mysqli_error($conn));
                    }
                } else {
                    $message = "<div class='alert alert-danger'>Error reverting content: " . mysqli_error($conn) . "</div>";
                }
                mysqli_stmt_close($stmt_revert);
            } else {
                $message = "<div class='alert alert-danger'>Error preparing revert statement: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>History entry not found for redo.</div>";
        }
        mysqli_stmt_close($stmt_fetch_history);
    } else {
        $message = "<div class='alert alert-danger'>Error preparing history fetch statement for redo: " . mysqli_error($conn) . "</div>";
    }
    // Re-fetch history to update display after redo
    $content_history = [];
    $history_sql = "SELECT id, content_key, old_content_text, new_content_text, changed_by, changed_at FROM content_history ORDER BY changed_at DESC LIMIT 20";
    if ($result = mysqli_query($conn, $history_sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $content_history[] = $row;
        }
        mysqli_free_result($result);
    } else {
        error_log("Error re-fetching content history after redo: " . mysqli_error($conn));
    }
}

// Close connection at the end of the script
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin-styles.css">
    <style>
        /* Basic styling for content form and history table */
        .content-management-section {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            margin-top: 30px;
        }
        .content-management-section h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        #currentContentDisplay {
            min-height: 80px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            word-wrap: break-word; /* Ensure long text wraps */
        }
        .history-table-container {
            margin-top: 40px;
        }
        .history-table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .history-table-container th, .history-table-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        .history-table-container th {
            background-color: #f2f2f2;
        }
        .btn-redo {
            padding: 5px 10px;
            font-size: 0.85em;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#content-management-section">Manage Content</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a> </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Welcome to the Admin Dashboard, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
        <p>This is where you can manage your website content, users, and settings.</p>

        <?php echo $message; // Display messages here ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">User Management</h5>
                        <p class="card-text">Add, edit, or delete user accounts.</p>
                        <a href="#" class="btn btn-primary">Go to Users</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Content Management</h5>
                        <p class="card-text">Manage headings,Paragraphs.</p>
                        <a href="#content-management-section" class="btn btn-success">Go to Content</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Site Settings</h5>
                        <p class="card-text">Configure global website settings.</p>
                        <a href="#" class="btn btn-warning">Go to Settings</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="content-management-section" class="content-management-section mt-5">
            <h2>Manage Website Content</h2>
            <form method="post" action="admin.php">
                <div class="form-group">
                    <label for="contentKeySelect">Select Content Key:</label>
                    <select class="form-select" id="contentKeySelect" name="content_key" required>
                        <option value="">-- Select a Key --</option>
                        <?php foreach ($allContentKeys as $key): ?>
                            <option value="<?php echo htmlspecialchars($key); ?>" <?php echo ($selected_key == $key) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($key); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="currentContent">Current Content:</label>
                    <div id="currentContentDisplay" class="form-control" style="white-space: pre-wrap; word-wrap: break-word;">
                        <?php echo htmlspecialchars($current_content); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="newContentText">Enter New Text:</label>
                    <textarea class="form-control" id="newContentText" name="new_content_text" rows="5" required><?php echo htmlspecialchars($current_content); ?></textarea>
                </div>
                <button type="submit" name="update_content" class="btn btn-primary mt-3">Change Text</button>
            </form>

            <div class="history-table-container mt-5">
                <h3>Content Change History</h3>
                <form method="post" action="admin.php" onsubmit="return confirm('Are you sure you want to clear all history? This action cannot be undone.');">
                    <button type="submit" name="clear_history" class="btn btn-danger mb-3">Clear All History</button>
                </form>
                <?php if (empty($content_history)): ?>
                    <p>No content change history available.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Content Key</th>
                                    <th>Old Text</th>
                                    <th>New Text</th>
                                    <th>Changed By</th>
                                    <th>Changed At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($content_history as $entry): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($entry['id']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['content_key']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['old_content_text']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['new_content_text']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['changed_by']); ?></td>
                                        <td><?php echo htmlspecialchars($entry['changed_at']); ?></td>
                                        <td>
                                            <form method="post" action="admin.php" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to revert this change? This will update the live content.');">
                                                <input type="hidden" name="history_id_to_redo" value="<?php echo htmlspecialchars($entry['id']); ?>">
                                                <button type="submit" name="redo_last_change" class="btn btn-warning btn-redo">Redo</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

        </div> </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('contentKeySelect').addEventListener('change', function() {
            var selectedKey = this.value;
            var currentContentDisplay = document.getElementById('currentContentDisplay');
            var newContentTextarea = document.getElementById('newContentText');

            if (selectedKey) {
                // Use AJAX to fetch the current content for the selected key
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'admin.php?key=' + encodeURIComponent(selectedKey), true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); // Indicate it's an AJAX request
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        currentContentDisplay.textContent = xhr.responseText;
                        newContentTextarea.value = xhr.responseText; // Pre-fill textarea with current content
                    } else {
                        currentContentDisplay.textContent = 'Error loading content.';
                        newContentTextarea.value = '';
                    }
                };
                xhr.send();
            } else {
                currentContentDisplay.textContent = '';
                newContentTextarea.value = '';
            }
        });

        // Trigger change event on page load if a key is already selected (e.g., after form submission)
        document.addEventListener('DOMContentLoaded', function() {
            var selectedOption = document.querySelector('#contentKeySelect option:checked');
            if (selectedOption && selectedOption.value) {
                // Manually trigger the change event to load content if a key is pre-selected
                document.getElementById('contentKeySelect').dispatchEvent(new Event('change'));
            }
        });
    </script>
</body>
</html>