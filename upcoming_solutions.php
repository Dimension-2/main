<?php include_once 'get_content.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getContent('upcoming_solutions_page_title'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9Oer2f3hU81YUuXoSM1+1QVxPEjD0xS5gLz9+9dF+R7" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="CSS/variable.css">
    <link rel="stylesheet" href="CSS/base.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/responsive.css">
    
    <style>
        /* Specific overrides/additions for this page */

        body {
            /* Changed to pure white background */
            background-color: #ffffff;
            font-family: 'Lato', sans-serif; /* Adjusted body font for this page */
            color: #333333; /* Dark text for readability on white background */
            line-height: 1.6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
            box-sizing: border-box;
        }

        .solution-section {
            background-color: #ffffff; /* Remains white for the content box */
            border-radius: 15px;
            padding: 50px 60px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); /* Keeps its shadow to stand out */
            margin: 20px 0;
            max-width: 900px;
            width: 100%;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            position: relative; /* Essential for the close button positioning */
        }

        .solution-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        }

        /* Styles for the new Close Button */
        .close-button {
            position: absolute;
            top: 25px;
            right: 25px;
            background: none;
            border: none;
            font-size: 2.8rem; /* Large 'x' for easy clicking */
            color: #888; /* Soft gray for visibility on white, yet subtle */
            cursor: pointer;
            line-height: 1;
            padding: 0;
            transition: color 0.3s ease, transform 0.2s ease;
            z-index: 10; /* Ensure it's above other content */
        }

        .close-button:hover {
            color: #555; /* Darker gray on hover */
            transform: rotate(90deg); /* Playful rotation on hover */
        }

        .solution-title {
            color: #0056b3; /* Keeping the professional blue for headings */
            font-family: 'Poppins', sans-serif; /* Using Poppins for headings */
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            padding-bottom: 15px;
            position: relative;
        }

        .solution-title::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: #007bff; /* Accent blue */
            border-radius: 2px;
        }

        .solution-intro {
            font-family: 'Lato', sans-serif; /* Lato for intro text */
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 40px;
            color: #555555; /* Dark text for readability */
            text-align: center;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        h2 {
            color: #007bff; /* Consistent blue for subheadings */
            font-family: 'Poppins', sans-serif; /* Poppins for subheadings */
            font-size: 1.8rem;
            font-weight: 600;
            margin-top: 50px;
            margin-bottom: 25px;
            text-align: center;
        }

        .features-list {
            list-style: none;
            padding-left: 0;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .features-list li {
            font-family: 'Lato', sans-serif; /* Lato for list items */
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 0;
            display: flex;
            align-items: flex-start;
            background-color: #f8faff; /* Very light blue background for list items, slightly off-white */
            border-left: 5px solid #007bff; /* Accent border on the left */
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .features-list li .icon {
            color: #28a745; /* Green for icons */
            font-size: 1.6rem;
            margin-right: 20px;
            line-height: 1;
            flex-shrink: 0;
        }

        /* Unicode icon mappings (ensure these are set up in your 'base.css' or here) */
        .icon-ai::before {
            content: "\1F916"; /* Robot Face */
        }
        .icon-drag-drop::before {
            content: "\1F4C1"; /* Folder */
        }
        .icon-delivery::before {
            content: "\1F69B"; /* Delivery Truck */
        }
        .icon-chat::before {
            content: "\1F4AC"; /* Speech Balloon */
        }
        .icon-early-access::before {
            content: "\1F510"; /* Key */
        }


        .call-to-action {
            font-family: 'Lato', sans-serif; /* Lato for call to action */
            font-size: 1.2rem;
            font-weight: 600;
            margin-top: 50px;
            color: #0056b3; /* Deeper blue */
            text-align: center;
            padding: 20px;
            background-color: #e6f7ff; /* Light blue background for emphasis */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .features-list {
                grid-template-columns: 1fr 1fr;
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
</head>
<body>

    <div class="container solution-section">
        <button class="close-button" onclick="window.location.href='index.php'">×</button>

        <h1 class="solution-title"><?php echo getContent('upcoming_solutions_main_heading'); ?></h1>
        <p class="solution-intro">
            <?php echo getContent('upcoming_solutions_intro_paragraph'); ?>
        </p>

        <h2><?php echo getContent('upcoming_solutions_subheading'); ?></h2>
        <ul class="features-list">
            <li>
                <span class="icon icon-ai"></span>
                <div>
                    <strong><?php echo getContent('upcoming_solutions_feature1_title'); ?></strong>: <?php echo getContent('upcoming_solutions_feature1_description'); ?>
                </div>
            </li>
            <li>
                <span class="icon icon-drag-drop"></span>
                <div>
                    <strong><?php echo getContent('upcoming_solutions_feature2_title'); ?></strong>: <?php echo getContent('upcoming_solutions_feature2_description'); ?>
                </div>
            </li>
            <li>
                <span class="icon icon-delivery"></span>
                <div>
                    <strong><?php echo getContent('upcoming_solutions_feature3_title'); ?></strong>: <?php echo getContent('upcoming_solutions_feature3_description'); ?>
                </div>
            </li>
            <li>
                <span class="icon icon-chat"></span>
                <div>
                    <strong><?php echo getContent('upcoming_solutions_feature4_title'); ?></strong>: <?php echo getContent('upcoming_solutions_feature4_description'); ?>
                </div>
            </li>
        </ul>
        <p class="call-to-action">
            <span class="icon icon-early-access"></span> <?php echo getContent('upcoming_solutions_call_to_action'); ?>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>