<?php
// my-project/admin/admin.php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php"); // Correct: login.php is in the same directory (admin/)
    exit;
}

// Include config.php to get the database connection ($conn)
require_once '../config.php'; // Adjust path based on your project structure

// --- PHP Functions for Content Management ---

// Function to fetch all unique main headings
function getAllMainHeadings($conn)
{
    $headings = [];
    $sql = "SELECT DISTINCT main_heading FROM website_content WHERE main_heading IS NOT NULL AND main_heading != '' ORDER BY main_heading ASC";
    if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $headings[] = $row['main_heading'];
        }
        mysqli_free_result($result);
    }
    return $headings;
}

// Function to fetch content keys, optionally filtered by main heading
function getContentKeysByMainHeading($conn, $mainHeading = null)
{
    $keys = [];
    $sql = "SELECT content_key FROM website_content";
    $params = [];
    $types = '';

    if ($mainHeading) {
        $sql .= " WHERE main_heading = ?";
        $params[] = $mainHeading;
        $types .= 's';
    }

    $sql .= " ORDER BY content_key ASC";

    if (!empty($params)) {
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($row = mysqli_fetch_assoc($result)) {
                $keys[] = $row['content_key'];
            }
            mysqli_free_result($result);
            mysqli_stmt_close($stmt);
        }
    } else {
        // If no main heading is provided, fetch all as before
        if ($result = mysqli_query($conn, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $keys[] = $row['content_key'];
            }
            mysqli_free_result($result);
        }
    }
    return $keys;
}


// --- Initial Data Fetch and Variable Setup ---

// Get all main headings for the first dropdown
$allMainHeadings = getAllMainHeadings($conn);

// Variables for form handling (initial values)
$selected_main_heading = '';
$selected_key = '';
$current_content = '';
$message = ''; // To display success or error messages (from POST operations like update, clear history, redo)

// Initialize content keys based on selection or empty
$allContentKeys = [];

// Handle AJAX request for content keys
if (isset($_GET['main_heading'])) {
    $selected_main_heading = $_GET['main_heading'];
    $filteredKeys = getContentKeysByMainHeading($conn, $selected_main_heading);
    echo json_encode($filteredKeys);
    exit;
}

// Handle AJAX request for content text
if (isset($_GET['key'])) {
    $selected_key = $_GET['key'];
    $sql = "SELECT content_text FROM website_content WHERE content_key = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $selected_key);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $current_content);
        mysqli_stmt_fetch($stmt);
        echo $current_content;
        mysqli_stmt_close($stmt);
    }
    exit;
}

// --- Handle AJAX Requests ---
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // AJAX request to load content for a selected key
    if (isset($_GET['key'])) {
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
        echo $current_content; // Echo content for the specific key
        exit;
    }
    // AJAX request to load content keys for a selected main heading
    elseif (isset($_GET['main_heading'])) {
        $selected_main_heading = $_GET['main_heading'];
        $filteredKeys = getContentKeysByMainHeading($conn, $selected_main_heading);
        echo json_encode($filteredKeys); // Echo as JSON for JavaScript to parse
        exit;
    }
}


// --- Handle Form Submissions (POST) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle content update
    if (isset($_POST['update_content'])) {
        $selected_key = $_POST['content_key'];
        $new_content_text = $_POST['new_content_text'];
        $admin_username = $_SESSION["username"];

        // Fetch the old content text before updating for history log
        $old_content_sql = "SELECT content_text FROM website_content WHERE content_key = ?";
        $old_content_text = '';
        if ($stmt_old = mysqli_prepare($conn, $old_content_sql)) {
            mysqli_stmt_bind_param($stmt_old, "s", $selected_key);
            mysqli_stmt_execute($stmt_old);
            mysqli_stmt_store_result($stmt_old);
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
                $current_content = $new_content_text; // Update current content display
            } else {
                $message = "<div class='alert alert-danger'>Error updating content: " . mysqli_error($conn) . "</div>";
            }
            mysqli_stmt_close($stmt_update);
        } else {
            $message = "<div class='alert alert-danger'>Error preparing update statement: " . mysqli_error($conn) . "</div>";
        }
    }

    // Handle "Clear History"
    if (isset($_POST['clear_history'])) {
        $truncate_sql = "TRUNCATE TABLE content_history";
        if (mysqli_query($conn, $truncate_sql)) {
            $message = "<div class='alert alert-info'>Content history cleared successfully!</div>";
            // No need to re-fetch history, it will be empty
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
                    if (mysqli_stmt_fetch($stmt_get_current)) {
                        // Successfully fetched current text
                    }
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
    }

    // After any POST operation, if a main_heading was selected, we need to preserve it
    // And if a content_key was selected, fetch its current content
    if (isset($_POST['main_heading_select'])) {
        $selected_main_heading = $_POST['main_heading_select'];
        $allContentKeys = getContentKeysByMainHeading($conn, $selected_main_heading);
    }
    if (isset($_POST['content_key'])) {
        $selected_key = $_POST['content_key'];
        // Re-fetch current_content for display after update/selection
        $sql = "SELECT content_text FROM website_content WHERE content_key = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $selected_key);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $current_content);
                mysqli_stmt_fetch($stmt);
            }
            mysqli_stmt_close($stmt);
        }
    }
    // Append a status parameter to the URL to indicate content management action
    // This helps in keeping the modal open after a form submission within it.
    header("Location: admin.php?status=content_managed&selected_main_heading=" . urlencode($selected_main_heading) . "&selected_key=" . urlencode($selected_key));
    exit();
}


// --- Initial page load handling / State restoration ---
// If a key is selected (e.g., via GET or after a POST that didn't specify main_heading),
// determine its main_heading to set the first dropdown.
if (!empty($selected_key) && empty($selected_main_heading)) {
    $sql = "SELECT main_heading FROM website_content WHERE content_key = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $selected_key);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $temp_main_heading);
        if (mysqli_stmt_fetch($stmt)) {
            $selected_main_heading = $temp_main_heading;
            $allContentKeys = getContentKeysByMainHeading($conn, $selected_main_heading);
        }
        mysqli_stmt_close($stmt);
    }
}
// If no main heading is selected but we have keys, fetch all keys initially
if (empty($selected_main_heading) && empty($allContentKeys)) {
    // Optionally, you could fetch keys for the first main heading, or just leave it blank
    // For now, let's leave it blank and rely on JS to populate on first selection
}

// Restore state from GET parameters after a content management action
if (isset($_GET['status']) && $_GET['status'] === 'content_managed') {
    if (isset($_GET['selected_main_heading'])) {
        $selected_main_heading = urldecode($_GET['selected_main_heading']);
        $allContentKeys = getContentKeysByMainHeading($conn, $selected_main_heading);
    }
    if (isset($_GET['selected_key'])) {
        $selected_key = urldecode($_GET['selected_key']);
        // Fetch current content for the selected key
        $sql = "SELECT content_text FROM website_content WHERE content_key = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $selected_key);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $current_content);
                mysqli_stmt_fetch($stmt);
            }
            mysqli_stmt_close($stmt);
        }
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
    <link rel="stylesheet" href="../css/admin-css.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Show/hide content key dropdown based on main heading selection
        $('#mainHeadingSelect').change(function () {
            if ($(this).val()) {
                $('#contentKeySelectGroup').show();

                // AJAX call to load content keys
                $.ajax({
                    url: 'admin.php',
                    type: 'GET',
                    data: { main_heading: $(this).val() },
                    success: function (response) {
                        var keys = JSON.parse(response);
                        $('#contentKeySelect').empty().append('<option value="">-- Select a Key --</option>');
                        keys.forEach(function (key) {
                            $('#contentKeySelect').append('<option value="' + key + '">' + key + '</option>');
                        });
                    }
                });
            } else {
                $('#contentKeySelectGroup').hide();
            }
        });

        // Load current content when a key is selected
        $('#contentKeySelect').change(function () {
            if ($(this).val()) {
                $.ajax({
                    url: 'admin.php',
                    type: 'GET',
                    data: { key: $(this).val() },
                    success: function (response) {
                        $('#currentContentDisplay').text(response);
                        $('#newContentText').val(response);
                    }
                });
            }
        });
    });
</script>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin.php">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal"
                            data-bs-target="#contentManagementModal">Manage Content</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal"
                            data-bs-target="#mediaManagementModal">Manage Media</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Welcome to the Admin Dashboard, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
        <p>This is where you can manage your website content, users, and settings.</p>

        <?php
        // Display login success message
        if (isset($_GET['status']) && $_GET['status'] == 'loggedin_success') {
            echo '<div class="alert alert-success" role="alert">
                    You have been successfully logged in!
                  </div>';
        }
        ?>
        <?php echo $message; // Display messages from POST operations ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Content Management</h5>
                        <p class="card-text">Manage headings,Paragraphs.</p>
                        <a href="#" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#contentManagementModal">
                            Go to Content
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Media Management</h5>
                        <p class="card-text">Manage images, videos, and other media.</p>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#mediaManagementModal">
                            Go to Media
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="contentManagementModal" tabindex="-1" aria-labelledby="contentManagementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contentManagementModalLabel">Manage Website Content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="content-management-section" class="content-management-section mt-1">
                        <h2>Manage Website Content</h2>
                        <form method="post" action="admin.php">
                            <div class="form-group">
                                <label for="mainHeadingSelect">Select Main Section:</label>
                                <select class="form-select" id="mainHeadingSelect" name="main_heading_select" required>
                                    <option value="">-- Select a Section --</option>
                                    <?php foreach ($allMainHeadings as $heading): ?>
                                        <option value="<?php echo htmlspecialchars($heading); ?>" <?php echo ($selected_main_heading == $heading) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($heading); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group" id="contentKeySelectGroup"
                                style="<?php echo !empty($selected_main_heading) ? 'display: block;' : 'display: none;'; ?>">
                                <label for="contentKeySelect">Select Content Key:</label>
                                <select class="form-select" id="contentKeySelect" name="content_key" required>
                                    <option value="">-- Select a Key --</option>
                                    <?php
                                    // Populate this dropdown if a main heading was already selected (e.g., on page reload after update)
                                    if (!empty($selected_main_heading)) {
                                        foreach ($allContentKeys as $key): ?>
                                            <option value="<?php echo htmlspecialchars($key); ?>" <?php echo ($selected_key == $key) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($key); ?>
                                            </option>
                                        <?php endforeach;
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="currentContent">Current Content:</label>
                                <div id="currentContentDisplay" class="form-control"
                                    style="white-space: pre-wrap; word-wrap: break-word;">
                                    <?php echo htmlspecialchars($current_content); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="newContentText">Enter New Text:</label>
                                <textarea class="form-control" id="newContentText" name="new_content_text" rows="5"
                                    required><?php echo htmlspecialchars($current_content); ?></textarea>
                            </div>
                            <button type="submit" name="update_content" class="btn btn-primary mt-3">Change
                                Text</button>
                        </form>

                        <div class="history-table-container mt-5">
                            <h3>Content Change History</h3>
                            <form method="post" action="admin.php"
                                onsubmit="return confirm('Are you sure you want to clear all history? This action cannot be undone.');">
                                <button type="submit" name="clear_history" class="btn btn-danger mb-3">Clear All
                                    History</button>
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
                                                        <form method="post" action="admin.php" style="display:inline-block;"
                                                            onsubmit="return confirm('Are you sure you want to revert this change? This will update the live content.');">
                                                            <input type="hidden" name="history_id_to_redo"
                                                                value="<?php echo htmlspecialchars($entry['id']); ?>">
                                                            <button type="submit" name="redo_last_change"
                                                                class="btn btn-warning btn-redo">Redo</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mediaManagementModal" tabindex="-1" aria-labelledby="mediaManagementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediaManagementModalLabel">Manage Media Content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="mediaTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="images-tab" data-bs-toggle="tab"
                                data-bs-target="#images" type="button" role="tab">Images</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="videos-tab" data-bs-toggle="tab" data-bs-target="#videos"
                                type="button" role="tab">Videos</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="text-tab" data-bs-toggle="tab" data-bs-target="#text"
                                type="button" role="tab">Text Content</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="mediaTabsContent">
                        <!-- Images Tab -->
                        <div class="tab-pane fade show active" id="images" role="tabpanel">
                            <div class="row mt-3">
                                <?php
                                $images = $conn->query("SELECT * FROM Main_file_Content WHERE content_type='image'");
                                while ($img = $images->fetch_assoc()):
                                    ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card">
                                            <img src="../<?php echo $img['file_path']; ?>" class="card-img-top"
                                                alt="<?php echo $img['alt_text']; ?>">
                                            <div class="card-body">
                                                <h5><?php echo $img['description']; ?></h5>
                                                <p>Section: <?php echo $img['section']; ?></p>
                                                <button class="btn btn-sm btn-primary edit-media"
                                                    data-id="<?php echo $img['id']; ?>">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>

                        <!-- Videos Tab -->
                        <div class="tab-pane fade" id="videos" role="tabpanel">
                            <div class="row mt-3">
                                <?php
                                $videos = $conn->query("SELECT * FROM Main_file_Content WHERE content_type='video'");
                                while ($vid = $videos->fetch_assoc()):
                                    ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5><?php echo $vid['description']; ?></h5>
                                                <p>File: <?php echo $vid['file_path']; ?></p>
                                                <p>Section: <?php echo $vid['section']; ?></p>
                                                <button class="btn btn-sm btn-primary edit-media"
                                                    data-id="<?php echo $vid['id']; ?>">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>

                        <!-- Text Tab -->
                        <div class="tab-pane fade" id="text" role="tabpanel">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Section</th>
                                        <th>Description</th>
                                        <th>Content Preview</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $texts = $conn->query("SELECT * FROM Main_file_Content WHERE content_type='text'");
                                    while ($txt = $texts->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <td><?php echo $txt['section']; ?></td>
                                            <td><?php echo $txt['description']; ?></td>
                                            <td><?php echo substr($txt['content_text'], 0, 50) . '...'; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary edit-media"
                                                    data-id="<?php echo $txt['id']; ?>">Edit</button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addMediaModal">Add
                        New</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Media Modal -->
    <div class="modal fade" id="editMediaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="mediaForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="mediaId">
                        <input type="hidden" name="content_type" id="contentType">

                        <div class="mb-3">
                            <label class="form-label">Section</label>
                            <input type="text" class="form-control" name="section" id="mediaSection" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" id="mediaDescription" required>
                        </div>

                        <div class="mb-3" id="fileUploadGroup">
                            <label class="form-label">File</label>
                            <input type="file" class="form-control" name="file" id="mediaFile">
                            <small class="text-muted" id="currentFile"></small>
                        </div>

                        <div class="mb-3" id="altTextGroup">
                            <label class="form-label">Alt Text</label>
                            <input type="text" class="form-control" name="alt_text" id="mediaAltText">
                        </div>

                        <div class="mb-3" id="contentTextGroup">
                            <label class="form-label">Content Text</label>
                            <textarea class="form-control" name="content_text" id="mediaContentText"
                                rows="5"></textarea>
                        </div>

                        <button type="submit" name="save_media" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>