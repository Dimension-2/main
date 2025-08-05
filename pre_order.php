<?php include_once 'get_content.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getContent('preorder_page_title'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9Oer2f3hU81YUuXoSM1+1QVxPEjD0xS5gLz9+9dF+R7" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/pre_order.css">


</head>

<body>

    <div class="preorder-container">
        <button class="close-button" onclick="window.location.href='index.php'">×</button>
        <div class="preorder-header">
            <h2><?php echo getContent('preorder_heading'); ?></h2>
            <p><?php echo getContent('preorder_subheading'); ?></p>
        </div>

        <form id="preorderForm">
            <div class="form-grid">
                <div class="form-group">
                    <label for="firstName"><?php echo getContent('preorder_label_first_name'); ?></label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required pattern="[A-Za-z]+"
                        title="First name can only contain letters.">
                </div>
                <div class="form-group">
                    <label for="lastName"><?php echo getContent('preorder_label_last_name'); ?></label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required pattern="[A-Za-z]+"
                        title="Last name can only contain letters.">
                </div>

                <div class="form-group">
                    <label for="jobTitle"><?php echo getContent('preorder_label_job_title'); ?></label>
                    <input type="text" class="form-control" id="jobTitle" name="jobTitle" required>
                </div>
                <div class="form-group">
                    <label for="companyName"><?php echo getContent('preorder_label_company_name'); ?></label>
                    <input type="text" class="form-control" id="companyName" name="companyName" required>
                </div>

                <div class="form-group">
                    <label for="phoneNumber"><?php echo getContent('preorder_label_phone_number'); ?></label>
                    <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" required
                        pattern="[0-9]{10,15}" title="Please enter a valid phone number (10-15 digits).">
                </div>
                <div class="form-group">
                    <label for="email"><?php echo getContent('preorder_label_email'); ?></label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="industry"><?php echo getContent('preorder_label_industry'); ?></label>
                    <select class="form-select" id="industry" name="industry" required>
                        <option value=""><?php echo getContent('preorder_option_please_select'); ?></option>
                        <option value="finance"><?php echo getContent('preorder_option_finance'); ?></option>
                        <option value="tech"><?php echo getContent('preorder_option_technology'); ?></option>
                        <option value="healthcare"><?php echo getContent('preorder_option_healthcare'); ?></option>
                        <option value="retail"><?php echo getContent('preorder_option_retail'); ?></option>
                        <option value="manufacturing"><?php echo getContent('preorder_option_manufacturing'); ?>
                        </option>
                        <option value="other"><?php echo getContent('preorder_option_other'); ?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="numEmployees"><?php echo getContent('preorder_label_num_employees'); ?></label>
                    <input type="number" class="form-control" id="numEmployees" name="numEmployees" min="1" required>
                </div>
            </div>

            <fieldset>
                <legend><?php echo getContent('preorder_legend_how_can_we_help'); ?></legend>
                <div class="radio-options-grid">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="helpOptions" id="businessInsurance"
                            value="businessInsurance" required>
                        <label class="form-check-label"
                            for="businessInsurance"><?php echo getContent('preorder_radio_business_insurance'); ?></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="helpOptions" id="employeeBenefits"
                            value="employeeBenefits">
                        <label class="form-check-label"
                            for="employeeBenefits"><?php echo getContent('preorder_radio_employee_benefits'); ?></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="helpOptions" id="retirementServices"
                            value="retirementServices">
                        <label class="form-check-label"
                            for="retirementServices"><?php echo getContent('preorder_radio_retirement_services'); ?></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="helpOptions" id="hrServices"
                            value="hrServices">
                        <label class="form-check-label"
                            for="hrServices"><?php echo getContent('preorder_radio_hr_services'); ?></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="helpOptions" id="personalLines"
                            value="personalLines">
                        <label class="form-check-label"
                            for="personalLines"><?php echo getContent('preorder_radio_personal_lines'); ?></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="helpOptions" id="wholesaleBenefits"
                            value="wholesaleBenefits">
                        <label class="form-check-label"
                            for="wholesaleBenefits"><?php echo getContent('preorder_radio_wholesale_benefits'); ?></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="helpOptions" id="assetProtection"
                            value="assetProtection">
                        <label class="form-check-label"
                            for="assetProtection"><?php echo getContent('preorder_radio_asset_protection'); ?></label>
                    </div>
                </div>
            </fieldset>

            <div class="form-group">
                <label for="additionalDetails"><?php echo getContent('preorder_label_additional_details'); ?></label>
                <textarea class="form-control" id="additionalDetails" name="additionalDetails" rows="5"></textarea>
            </div>

            <div class="submit-button-container">
                <button type="submit"
                    class="submit-button"><?php echo getContent('preorder_submit_button_text'); ?></button>
            </div>
        </form>

        <div class="form-footer">
            <?php echo getContent('preorder_footer_text_part1'); ?> <a
                href="#"><?php echo getContent('preorder_footer_link_terms_privacy'); ?></a>.
            <?php echo getContent('preorder_footer_text_part2'); ?> <a
                href="#"><?php echo getContent('preorder_footer_link_notice_collection'); ?></a>
            <?php echo getContent('preorder_footer_text_part3'); ?> <a
                href="#"><?php echo getContent('preorder_footer_link_cookie_preferences'); ?></a>.<br>
            <?php echo getContent('preorder_footer_recaptcha_text_part1'); ?> <a
                href="#"><?php echo getContent('preorder_footer_recaptcha_link_privacy'); ?></a>
            <?php echo getContent('preorder_footer_recaptcha_text_and'); ?> <a
                href="#"><?php echo getContent('preorder_footer_recaptcha_link_terms'); ?></a>
            <?php echo getContent('preorder_footer_recaptcha_text_apply'); ?>.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        document.getElementById('preorderForm').addEventListener('submit', function (event) {
            event.preventDefault();

            // Validate form
            if (!this.checkValidity()) {
                event.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            // Submit form via AJAX
            fetch('process_preorder.php', {
                method: 'POST',
                body: new FormData(this)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Thank you for your pre-order! We will contact you soon.');
                        window.location.href = 'index.php'; // Redirect after submission
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Network error: ' + error);
                });
        });
    </script>
</body>

</html>