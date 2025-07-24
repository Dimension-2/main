<?php include_once 'get_content.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getContent('matchmaking_title'); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9Oer2f3hU81YUuXoSM1+1QVxPEjD0xS5gLz9+9dF+R7" crossorigin="anonymous">
    <style>
        /* Professional Body & Layout Styling */
        body {
            font-family: 'Inter', sans-serif; /* A more modern, professional font */
            background-color: #f0f2f5; /* Light, subtle grey background for depth */
            color: #333333; /* Darker, professional text color */
            line-height: 1.6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Centers horizontally */
            align-items: center;    /* CENTERS VERTICALLY */
            min-height: 100vh; /* Ensure it takes full viewport height */
            padding: 40px 20px; /* Overall padding for the page content */
            box-sizing: border-box; /* Include padding in element's total width and height */
        }

        .solution-section {
            background-color: #ffffff; /* Crisp white background for the content container */
            border-radius: 15px; /* Slightly more prominent rounded corners for a modern feel */
            padding: 50px 60px; /* Generous internal padding */
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); /* More refined shadow for depth */
            margin: 20px 0; /* Vertical margin to separate from potential header/footer */
            max-width: 900px; /* Max width for readability */
            width: 100%; /* Ensure it's responsive */
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            position: relative; /* Needed for positioning the close button */
        }

        .solution-section:hover {
            transform: translateY(-5px); /* Subtle lift on hover */
            box-shadow: 0 15px 40px rgba(0,0,0,0.12); /* Enhanced shadow on hover */
        }

        /* New Close Button Styling */
        .close-button {
            position: absolute;
            top: 25px;
            right: 25px;
            background: none;
            border: none;
            font-size: 2.8rem; /* Large 'x' for easy clicking */
            color: #888; /* Soft gray */
            cursor: pointer;
            line-height: 1; /* Ensures 'x' is vertically centered */
            padding: 0;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .close-button:hover {
            color: #555; /* Darker gray on hover */
            transform: rotate(90deg); /* Playful rotation on hover */
        }

        .solution-title {
            color: #0056b3; /* A deeper, more professional blue */
            font-size: 3.2rem; /* Larger, more impactful heading */
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center; /* Center align for a clean presentation */
            padding-bottom: 15px;
            position: relative; /* For the underline effect */
        }

        .solution-title::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 80px; /* Short underline */
            height: 4px;
            background-color: #007bff; /* Accent blue */
            border-radius: 2px;
        }

        .solution-intro {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 40px;
            color: #555555;
            text-align: center;
            max-width: 700px; /* Control width for readability */
            margin-left: auto;
            margin-right: auto;
        }

        h2 {
            color: #007bff; /* Consistent blue for subheadings */
            font-size: 1.8rem;
            font-weight: 600;
            margin-top: 50px;
            margin-bottom: 25px;
            text-align: center;
        }

        .features-list {
            list-style: none; /* Remove default bullet points */
            padding-left: 0;
            display: grid; /* Use CSS Grid for a professional layout */
            grid-template-columns: 1fr; /* Single column by default */
            gap: 20px; /* Space between grid items */
        }

        .features-list li {
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 0; /* Reset default list item margin */
            display: flex; /* For icon alignment */
            align-items: flex-start;
            background-color: #f8faff; /* Very light blue background for list items */
            border-left: 5px solid #007bff; /* Accent border on the left */
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .features-list li .icon {
            color: #28a745; /* Green for checkmark */
            font-size: 1.6rem; /* Slightly larger icon */
            margin-right: 20px;
            line-height: 1; /* Align icon better with text baseline */
            flex-shrink: 0; /* Prevent icon from shrinking */
        }

        .call-to-action {
            font-size: 1.2rem;
            font-weight: 600;
            margin-top: 50px;
            color: #0056b3; /* Deeper blue for call to action */
            text-align: center;
            padding: 20px;
            background-color: #e6f7ff; /* Light blue background for emphasis */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        /* Styles for the checkmark and other icons, using Unicode characters */
        .icon-checkmark::before {
            content: "\2705"; /* Green check mark emoji */
        }
        .icon-manual::before {
            content: "\1F5B0"; /* Printer/plotter for manual process */
        }
        .icon-storage::before {
            content: "\1F4BE"; /* Floppy disk for storage */
        }
        .icon-organize::before {
            content: "\1F4DC"; /* Scroll for organized docs */
        }
        .icon-submit::before {
            content: "\1F527"; /* Wrench for process/submit */
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .features-list {
                grid-template-columns: 1fr 1fr; /* Two columns on larger screens */
            }
            .solution-title {
                font-size: 3.8rem;
            }
            .solution-section {
                padding: 60px 80px;
            }
        }

        @media (max-width: 576px) {
            .solution-section {
                padding: 30px 25px;
            }
            .solution-title {
                font-size: 2.5rem;
            }
            .solution-intro, .features-list li, .call-to-action {
                font-size: 0.95rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container solution-section">
        <button class="close-button" onclick="window.location.href='index.php'">×</button>

        <h1 class="solution-title"><?php echo getContent('matchmaking_main_heading'); ?></h1>
        <p class="solution-intro">
            <?php echo getContent('matchmaking_intro'); ?>
        </p>

        <h2 class="h4 mt-5 mb-3"><?php echo getContent('matchmaking_features_heading'); ?></h2>
        <ul class="features-list">
            <li>
                <span class="icon icon-checkmark"></span>
                <div>
                    <b><?php echo getContent('matchmaking_feature1_title'); ?></b>: <?php echo getContent('matchmaking_feature1_description'); ?>
                </div>
            </li>
            <li>
                <span class="icon icon-manual"></span>
                <div>
                    <b><?php echo getContent('matchmaking_feature2_title'); ?></b>: <?php echo getContent('matchmaking_feature2_description'); ?>
                </div>
            </li>
            <li>
                <span class="icon icon-storage"></span>
                <div>
                    <b><?php echo getContent('matchmaking_feature3_title'); ?></b>: <?php echo getContent('matchmaking_feature3_description'); ?>
                </div>
            </li>
            <li>
                <span class="icon icon-organize"></span>
                <div>
                    <b><?php echo getContent('matchmaking_feature4_title'); ?></b>: <?php echo getContent('matchmaking_feature4_description'); ?>
                </div>
            </li>
        </ul>
        <p class="call-to-action">
            <span class="icon icon-submit"></span> <?php echo getContent('matchmaking_cta'); ?>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>