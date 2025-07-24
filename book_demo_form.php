<?php include_once 'get_content.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FortiFund - Book Your Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9Oer2f3hU81YUuXoSM1+1QVxPEjD0xS5gLz9+9dF+R7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/form_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="demo-form-card">
        <button class="close-button" onclick="window.location.href='index.php'">×</button>

        <h1><?php echo getContent('book_demo_heading'); ?></h1>
        <form id="demoBookingForm" class="needs-validation" novalidate>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="firstName" class="form-label"><?php echo getContent('form_label_first_name'); ?> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="firstName" placeholder="First Name" required>
                </div>
                <div class="col-md-6">
                    <label for="lastName" class="form-label"><?php echo getContent('form_label_last_name'); ?> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="lastName" placeholder="Last Name" required>
                </div>

                <div class="col-12">
                    <label for="email" class="form-label"><?php echo getContent('form_label_work_email'); ?> <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" placeholder="Work Email" required>
                </div>
                <div class="col-12">
                    <label for="phoneNumber" class="form-label"><?php echo getContent('form_label_phone_number'); ?> <small class="text-muted">(<?php echo getContent('form_optional_text'); ?>)</small></label>
                    <input type="tel" class="form-control" id="phoneNumber" placeholder="Phone Number">
                </div>
                <div class="col-12">
                    <label for="companyName" class="form-label"><?php echo getContent('form_label_company_name'); ?> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="companyName" placeholder="Company Name" required>
                </div>

                <div class="col-md-6">
                    <label for="industry" class="form-label"><?php echo getContent('form_label_industry'); ?> <span class="text-danger">*</span></label>
                    <select class="form-select" id="industry" required>
                        <option selected disabled value=""><?php echo getContent('form_option_select_industry'); ?></option>
                        <option>Financial Services</option>
                        <option>Real Estate</option>
                        <option>Technology</option>
                        <option>Healthcare</option>
                        <option>Manufacturing</option>
                        <option>Retail</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="role" class="form-label"><?php echo getContent('form_label_your_role'); ?> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="role" placeholder="Your Role" required>
                </div>

                <div class="col-12">
                    <label for="message" class="form-label"><?php echo getContent('form_label_achieve_message'); ?> <small class="text-muted">(<?php echo getContent('form_optional_text'); ?>)</small></label>
                    <textarea class="form-control" id="message" rows="3" placeholder="<?php echo getContent('form_placeholder_your_message'); ?>"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-submit-demo"><?php echo getContent('btn_schedule_my_demo'); ?></button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        } else {
                            event.preventDefault();
                            // Changed the redirect to a PHP file for consistency
                            window.location.href = 'demo_request_done.php';
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>