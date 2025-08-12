<?php
include_once 'get_content.php';
require_once 'send_email.php'; // Include your email sending functions

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'config.php';

    // Prepare data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = !empty($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : NULL;
    $message = !empty($_POST['message']) ? mysqli_real_escape_string($conn, $_POST['message']) : NULL;
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // Insert query
    $sql = "INSERT INTO contact_sub (name, phone, email, message, ip_address) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars(mysqli_error($conn)));
    }

    $bind = mysqli_stmt_bind_param($stmt, "sssss", $name, $phone, $email, $message, $ip_address);
    if ($bind === false) {
        die("Bind failed: " . htmlspecialchars(mysqli_stmt_error($stmt)));
    }

    $exec = mysqli_stmt_execute($stmt);
    if ($exec) {
        $last_id = mysqli_insert_id($conn);

        // Send admin notification
        $admin_email = 'armaghanali304@gmail.com';  // Replace with your admin email
        $admin_subject = "New Contact Submission";
        $admin_body = "New submission from $name\nPhone: $phone\nEmail: " . ($email ?: 'Not provided') . "\nMessage: " . ($message ?: 'No message');

        if (sendEmail($admin_email, $admin_subject, $admin_body)) {
            mysqli_query($conn, "UPDATE contact_sub SET admin_email_sent=1 WHERE id=$last_id");
        }

        // Send user confirmation if email provided
        if ($email) {
            $user_subject = "Thank You for Contacting Us";
            $user_body = "Dear $name,\n\nWe've received your message and will contact you soon.\n\nBest regards,\nFortiFund Team";

            if (sendEmail($email, $user_subject, $user_body)) {
                mysqli_query($conn, "UPDATE contact_sub SET user_email_sent=1 WHERE id=$last_id");
            }
        }

        // Success - set message and hide modal via JavaScript
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("callBackModal"));
                if (modal) modal.hide();
                alert("Thank you! We will contact you soon.");
            });
        </script>';
    } else {
        $error_message = "Error: " . mysqli_stmt_error($stmt);
    }

    // mysqli_stmt_close($stmt);
    // mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FortiFund - Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9Oer2f3hU81YUuXoSM1+1QVxPEjD0xS5gLz9+9dF+R7" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/contact_us.css">
    <style>

    </style>
</head>

<body>

    <div class="contact-container">
        <button class="close-button" onclick="window.location.href='index.php'">×</button>

        <div class="contact-header">
            <h1><?php echo getContent('contact_us_heading'); ?></h1>
            <p><?php echo getContent('contact_us_intro_text'); ?></p>
        </div>

        <div class="contact-info">
            <h2><?php echo getContent('contact_us_primary_contact_heading'); ?></h2>

            <div class="contact-item">
                <h3><span class="icon">📧</span> <?php echo getContent('contact_us_email_heading'); ?></h3>
                <p><?php echo getContent('contact_us_email_description'); ?></p>
                <p><a
                        href="mailto:<?php echo getContent('contact_us_email_address'); ?>"><?php echo getContent('contact_us_email_address'); ?></a>
                </p>
            </div>

            <div class="contact-item">
                <h3><span class="icon">📞</span> <?php echo getContent('contact_us_call_back_heading'); ?></h3>
                <p><?php echo getContent('contact_us_call_back_description'); ?></p>
                <button type="button" class="contact-button" data-bs-toggle="modal" data-bs-target="#callBackModal">
                    <?php echo getContent('contact_us_request_call_button'); ?>
                </button>
            </div>
        </div>
    </div>
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <div class="modal fade" id="callBackModal" tabindex="-1" aria-labelledby="callBackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="callBackModalLabel"><?php echo getContent('modal_call_back_title'); ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="callBackForm" method="POST" novalidate>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="modalName"><?php echo getContent('modal_label_your_name'); ?>*</label>
                            <input type="text" class="form-control" id="modalName" name="name" required
                                pattern="[A-Za-z ]+" title="Name can only contain letters and spaces.">
                        </div>
                        <div class="form-group">
                            <label for="modalPhone"><?php echo getContent('modal_label_phone_number'); ?>*</label>
                            <input type="tel" class="form-control" id="modalPhone" name="phone" required
                                pattern="[0-9]{10,15}" title="Please enter a valid phone number (10-15 digits).">
                        </div>
                        <div class="form-group">
                            <label for="modalEmail"><?php echo getContent('modal_label_email'); ?>
                                (<?php echo getContent('modal_label_optional'); ?>)</label>
                            <input type="email" class="form-control" id="modalEmail" name="email">
                        </div>
                        <div class="form-group">
                            <label for="modalMessage"><?php echo getContent('modal_label_your_message'); ?>
                                (<?php echo getContent('modal_label_optional'); ?>)</label>
                            <textarea class="form-control" id="modalMessage" name="message" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="modal-submit-button"><?php echo getContent('modal_submit_request_button'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        document.getElementById('callBackForm').addEventListener('submit', function (event) {
            // Client-side validation
            if (!this.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            this.classList.add('was-validated');
        });

        document.querySelector('.close-button').addEventListener('click', function () {
            window.history.back();
        });
    </script>
</body>
<?php
if (isset($conn)) {
    mysqli_close($conn);
}
?>

</html>