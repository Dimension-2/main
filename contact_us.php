<?php include_once 'get_content.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FortiFund - Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9Oer2f3hU81YUuXoSM1+1QVxPEjD0xS5gLz9+9dF+R7" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        /* Variables for easy color management */
        :root {
            --primary-blue: #007bff;
            --dark-blue: #1a436e;
            --light-gray: #f8f9fa;
            --medium-gray: #555;
            --dark-gray: #343a40;
            --border-color: #e0e0e0;
            --shadow-light: rgba(0, 0, 0, 0.08);
            --shadow-medium: rgba(0, 0, 0, 0.12);
            --shadow-dark: rgba(0, 0, 0, 0.2);
            --font-heading: 'Montserrat', sans-serif; /* Modern, clean heading font */
            --font-body: 'Roboto', sans-serif; /* Highly readable body font */
        }

        /* General Body Styles */
        body {
            /* Subtle gradient background for added depth and elegance */
            background: linear-gradient(to bottom right, var(--light-gray), #e9ecef);
            font-family: var(--font-body); /* Using Roboto for body text */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--dark-gray);
            line-height: 1.6;
            overflow-x: hidden; /* Prevent horizontal scroll */
            overflow-y: auto; /* Allow vertical scrolling if content overflows */
        }

        /* Contact Container - The main white, central box */
        .contact-container {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 80px var(--shadow-medium); /* More prominent shadow */
            padding: 55px 70px;
            max-width: 900px;
            width: 92%;
            position: relative;
            box-sizing: border-box;
            animation: fadeInScale 0.7s ease-out forwards;
            margin: 40px auto;
            text-align: center;
        }

        /* Close Button (for main container) */
        .close-button {
            position: absolute;
            top: 25px;
            right: 25px;
            background: none;
            border: none;
            font-size: 2.8rem;
            color: #888;
            cursor: pointer;
            line-height: 1;
            padding: 0;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .close-button:hover {
            color: var(--medium-gray);
            transform: rotate(90deg);
        }

        /* Header Section */
        .contact-header {
            margin-bottom: 50px;
        }

        .contact-header h1 {
            font-family: var(--font-heading); /* Montserrat for headings */
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--dark-blue);
            margin-bottom: 20px;
            line-height: 1.15;
            text-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
        }

        .contact-header p {
            font-family: var(--font-body); /* Roboto for body text */
            font-size: 1.2rem;
            color: var(--medium-gray);
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* Contact Info Section */
        .contact-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: stretch;
            gap: 35px;
            padding-top: 20px;
        }

        .contact-info h2 {
            font-family: var(--font-heading);
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--dark-gray);
            text-align: center;
            width: 100%;
            margin-bottom: 40px;
        }

        .contact-item {
            background-color: #fcfdfe;
            border-radius: 18px;
            box-shadow: 0 8px 25px var(--shadow-light);
            padding: 35px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            flex: 1;
            min-width: 280px;
            max-width: 45%;
            box-sizing: border-box;
            border: 1px solid var(--border-color);
        }

        .contact-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px var(--shadow-medium);
        }

        .contact-item h3 {
            font-family: var(--font-heading);
            font-size: 1.7rem;
            font-weight: 600;
            color: var(--dark-blue);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .contact-item h3 span.icon {
            font-size: 1.5em;
            line-height: 1;
        }

        .contact-item p {
            font-family: var(--font-body);
            font-size: 1rem;
            color: var(--medium-gray);
            margin-bottom: 20px;
            line-height: 1.7;
        }

        .contact-item a:not(.contact-button) {
            font-family: var(--font-body);
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease, text-decoration 0.3s ease, background-color 0.3s ease;
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: rgba(0, 123, 255, 0.05);
        }

        .contact-item a:not(.contact-button):hover {
            color: #0056b3;
            text-decoration: underline;
            background-color: rgba(0, 123, 255, 0.1);
        }

        .contact-button {
            display: inline-block;
            background: linear-gradient(to right, var(--primary-blue), #0056b3);
            color: #ffffff;
            font-family: var(--font-heading); /* Button text uses Montserrat */
            font-size: 1.15rem;
            font-weight: 600;
            padding: 14px 35px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 10px 25px rgba(0, 123, 255, 0.35);
            margin-top: 15px;
            position: relative;
            overflow: hidden;
        }

        .contact-button:hover {
            background: linear-gradient(to right, #0056b3, #003f80);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 123, 255, 0.5);
        }

        /* --- Modal (Pop-up Form) Styles --- */
        .modal {
            --bs-modal-bg: #fff; /* Bootstrap 5 variable override */
            --bs-modal-border-radius: 15px;
            --bs-modal-box-shadow: 0 15px 45px var(--shadow-medium);
        }
        .modal-content {
            border: none; /* Remove default border */
            border-radius: var(--bs-modal-border-radius);
            box-shadow: var(--bs-modal-box-shadow);
            padding: 30px; /* Internal padding for the modal */
        }

        .modal-header {
            border-bottom: none; /* Remove default border */
            padding: 0;
            margin-bottom: 25px;
            text-align: center;
            display: block; /* To center content easily */
        }

        .modal-header .btn-close {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 1.5rem;
            color: #888;
            opacity: 0.8;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-header .modal-title {
            font-family: var(--font-heading);
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark-blue);
            line-height: 1.2;
        }

        .modal-body {
            padding: 0;
        }

        .modal-body .form-group {
            margin-bottom: 20px; /* Spacing for modal form groups */
        }

        .modal-body label {
            font-family: var(--font-body);
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--dark-gray);
            margin-bottom: 8px;
            display: block;
        }

        .modal-body .form-control {
            font-family: var(--font-body);
            font-size: 1rem;
            padding: 12px 18px; /* Slightly less padding than main form for compactness */
            border: 1px solid var(--border-color);
            border-radius: 10px; /* Consistent rounded inputs */
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.03);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
            box-sizing: border-box;
            background-color: #fefefe;
        }

        .modal-body .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25), inset 0 1px 3px rgba(0, 0, 0, 0.03);
            outline: none;
        }

        .modal-footer {
            border-top: none;
            padding: 0;
            margin-top: 30px;
            text-align: center; /* Center the submit button */
            justify-content: center; /* For flexbox alignment */
            display: flex;
        }

        .modal-submit-button {
            background: linear-gradient(to right, #28a745, #218838); /* Green gradient for submission */
            color: #ffffff;
            font-family: var(--font-heading);
            font-size: 1.1rem;
            font-weight: 600;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        }

        .modal-submit-button:hover {
            background: linear-gradient(to right, #218838, #1e7e34);
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(40, 167, 69, 0.4);
        }


        /* Animations */
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive CSS */
        @media (max-width: 992px) {
            .contact-container {
                padding: 45px 50px;
            }
            .contact-header h1 {
                font-size: 2.8rem;
            }
            .contact-header p {
                font-size: 1.1rem;
            }
            .contact-info h2 {
                font-size: 1.8rem;
            }
            .contact-item {
                padding: 30px;
                max-width: 48%;
            }
            .contact-item h3 {
                font-size: 1.5rem;
            }
            .contact-button {
                font-size: 1.1rem;
                padding: 12px 30px;
            }
            .modal-header .modal-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 768px) {
            .contact-container {
                border-radius: 15px;
                padding: 35px 30px;
                width: 90%;
                margin: 30px auto;
            }
            .close-button {
                font-size: 2.2rem;
                top: 20px;
                right: 20px;
            }
            .contact-header h1 {
                font-size: 2.2rem;
            }
            .contact-header p {
                font-size: 1rem;
            }
            .contact-info {
                flex-direction: column;
                gap: 25px;
            }
            .contact-info h2 {
                font-size: 1.6rem;
            }
            .contact-item {
                padding: 28px;
                max-width: 100%;
            }
            .contact-item h3 {
                font-size: 1.3rem;
            }
            .contact-button {
                font-size: 1rem;
                padding: 10px 25px;
            }
            .modal-header .modal-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .contact-container {
                padding: 25px 20px;
            }
            .contact-header h1 {
                font-size: 1.8rem;
            }
            .contact-header p {
                font-size: 0.9rem;
            }
            .contact-info h2 {
                font-size: 1.4rem;
            }
            .contact-item h3 {
                font-size: 1.2rem;
            }
            .modal-content {
                padding: 20px;
            }
            .modal-header .modal-title {
                font-size: 1.3rem;
            }
            .modal-body .form-control {
                padding: 10px 15px;
            }
            .modal-submit-button {
                font-size: 0.95rem;
                padding: 10px 25px;
            }
        }
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
                <p><a href="mailto:<?php echo getContent('contact_us_email_address'); ?>"><?php echo getContent('contact_us_email_address'); ?></a></p>
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

    <div class="modal fade" id="callBackModal" tabindex="-1" aria-labelledby="callBackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="callBackModalLabel"><?php echo getContent('modal_call_back_title'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="callBackForm" novalidate> <div class="modal-body">
                        <div class="form-group">
                            <label for="modalName"><?php echo getContent('modal_label_your_name'); ?>*</label>
                            <input type="text" class="form-control" id="modalName" name="name" required pattern="[A-Za-z ]+" title="Name can only contain letters and spaces.">
                        </div>
                        <div class="form-group">
                            <label for="modalPhone"><?php echo getContent('modal_label_phone_number'); ?>*</label>
                            <input type="tel" class="form-control" id="modalPhone" name="phone" required pattern="[0-9]{10,15}" title="Please enter a valid phone number (10-15 digits).">
                        </div>
                        <div class="form-group">
                            <label for="modalEmail"><?php echo getContent('modal_label_email'); ?> (<?php echo getContent('modal_label_optional'); ?>)</label>
                            <input type="email" class="form-control" id="modalEmail" name="email">
                        </div>
                        <div class="form-group">
                            <label for="modalMessage"><?php echo getContent('modal_label_your_message'); ?> (<?php echo getContent('modal_label_optional'); ?>)</label>
                            <textarea class="form-control" id="modalMessage" name="message" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="modal-submit-button"><?php echo getContent('modal_submit_request_button'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.querySelector('.close-button').addEventListener('click', function() {
            window.history.back(); // Keeps current behavior of going back
        });

        // Client-side validation for the modal form
        document.getElementById('callBackForm').addEventListener('submit', function(event) {
            if (!this.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                alert('Call back request submitted successfully! We will contact you soon. (This is a demo, no actual submission)');

                // Hide the modal after successful submission (for demo purposes)
                var modalElement = document.getElementById('callBackModal');
                var modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }

                // Optionally reset the form
                this.reset();
                this.classList.remove('was-validated'); // Remove validation styles after reset
                event.preventDefault(); // Prevent actual form submission for demo
            }
            this.classList.add('was-validated'); // Add Bootstrap's validation class
        });
    </script>
</body>
</html>