<?php include_once 'get_content.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getContent('faqs_title'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9Oer2f3hU81YUuXoSM1+1QVxPEjD0xS5gLz9+9dF+R7" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/variables.css"> 
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">

    <style>
        /* Variables (optional - if you have a variables.css, ensure these align) */
        :root {
            --primary-blue: #007bff;
            --dark-blue: #1a436e;
            --light-gray-bg: #f8f9fa; /* Very light background for the page */
            --white: #ffffff;
            --text-color: #343a40;
            --light-text: #6c757d;
            --border-color: #e9ecef;
            --shadow-light: rgba(0, 0, 0, 0.05);
            --shadow-medium: rgba(0, 0, 0, 0.1);
            --font-heading: 'Poppins', sans-serif;
            --font-body: 'Lato', sans-serif;
        }

        /* Body and overall container styling */
        body {
            font-family: var(--font-body);
            background-color: var(--light-gray-bg); /* Very light background */
            color: var(--text-color);
            line-height: 1.6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center; /* <<< --- THIS CENTERS THE FAQ SECTION VERTICALLY --- >>> */
            min-height: 100vh;
            padding: 60px 20px; /* More padding around the main container */
            box-sizing: border-box;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }

        .faq-section {
            background-color: var(--white);
            border-radius: 20px; /* Softer, more modern rounded corners */
            box-shadow: 0 20px 60px var(--shadow-medium); /* More pronounced shadow */
            padding: 60px 70px; /* Generous internal padding */
            max-width: 1000px; /* Max width for readability */
            width: 100%; /* Ensure responsiveness */
            position: relative; /* For positioning the close button */
            box-sizing: border-box;
            animation: fadeIn 0.8s ease-out; /* Fade in animation */
        }

        /* Close Button Styling */
        .close-button {
            position: absolute;
            top: 25px;
            right: 25px;
            background: none;
            border: none;
            font-size: 2.8rem; /* Large 'x' */
            color: #ccc; /* Lighter color for subtlety */
            cursor: pointer;
            line-height: 1;
            padding: 0;
            transition: color 0.3s ease, transform 0.2s ease;
            z-index: 10; /* Ensure it's above other content */
        }

        .close-button:hover {
            color: #999; /* Darker on hover */
            transform: rotate(90deg); /* Consistent rotation effect */
        }

        /* Title Styling */
        .faq-title {
            font-family: var(--font-heading);
            font-size: 3.8rem; /* Larger, more impactful title */
            font-weight: 800; /* Extra bold */
            color: var(--dark-blue);
            text-align: center;
            margin-bottom: 50px; /* More space below title */
            position: relative;
            padding-bottom: 15px;
        }

        .faq-title::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 100px; /* A bit wider underline */
            height: 5px; /* Thicker underline */
            background-color: var(--primary-blue);
            border-radius: 3px;
        }

        /* FAQ Item Styling */
        .faq-item {
            background-color: var(--white);
            border: 1px solid var(--border-color); /* Subtle border */
            border-radius: 12px; /* Rounded corners for each item */
            margin-bottom: 25px; /* Space between items */
            overflow: hidden; /* Hide overflow for smooth animation */
            transition: all 0.3s ease; /* Smooth transition for hover and open state */
            box-shadow: 0 8px 25px var(--shadow-light); /* Individual item shadow */
        }

        .faq-item:hover {
            transform: translateY(-5px); /* Lift effect on hover */
            box-shadow: 0 12px 30px var(--shadow-medium); /* Enhanced shadow on hover */
        }

        .faq-question-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 22px 30px; /* Generous padding */
            background-color: var(--white);
            cursor: pointer;
            border-bottom: 1px solid transparent; /* No bottom border initially */
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .faq-question-wrapper:hover {
            background-color: #f0f7ff; /* Light blue on hover for question */
        }

        .faq-question {
            font-family: var(--font-heading); /* Poppins for questions */
            font-size: 1.15rem; /* Slightly larger font */
            font-weight: 600;
            color: var(--dark-blue);
            flex-grow: 1; /* Allows question to take available space */
            padding-right: 15px; /* Space from arrow */
        }

        .faq-arrow {
            font-size: 1.8rem; /* Larger arrow */
            color: var(--primary-blue);
            transition: transform 0.3s ease; /* Smooth rotation */
            flex-shrink: 0; /* Prevent arrow from shrinking */
        }

        .faq-item.open .faq-arrow {
            transform: rotate(90deg); /* Rotate arrow when open */
            color: var(--dark-blue); /* Darker arrow when open */
        }

        .faq-item.open .faq-question-wrapper {
            border-bottom: 1px solid var(--border-color); /* Add border when open */
        }

        .faq-answer {
            max-height: 0; /* Initially hidden */
            overflow: hidden;
            padding: 0 30px; /* Padding for answer */
            transition: max-height 0.4s ease-out, padding 0.4s ease-out; /* Smooth slide effect */
            background-color: #fcfdfe; /* Very light background for answer */
            color: var(--light-text); /* Slightly lighter text for answers */
        }

        .faq-item.open .faq-answer {
            max-height: 500px; /* Adjust as needed for max answer height. Make this large enough to fit your longest answer */
            padding: 20px 30px 30px; /* Show padding when open */
        }

        .faq-answer p {
            margin-bottom: 1em; /* Space between paragraphs in answers */
        }
        .faq-answer ul {
            margin-top: 15px;
            margin-bottom: 15px;
            padding-left: 25px;
            list-style: disc; /* Default disc bullets for lists */
            color: var(--light-text);
        }
        .faq-answer ul li {
            margin-bottom: 8px;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .faq-section {
                padding: 50px 50px;
            }
            .faq-title {
                font-size: 3.2rem;
                margin-bottom: 40px;
            }
            .faq-item {
                margin-bottom: 20px;
            }
            .faq-question-wrapper {
                padding: 20px 25px;
            }
            .faq-question {
                font-size: 1.1rem;
            }
            .faq-answer {
                padding: 0 25px;
            }
            .faq-item.open .faq-answer {
                padding: 18px 25px 25px;
            }
        }

        @media (max-width: 768px) {
            .faq-section {
                padding: 40px 30px;
                border-radius: 15px;
            }
            .faq-title {
                font-size: 2.8rem;
                margin-bottom: 30px;
            }
            .close-button {
                font-size: 2.2rem;
                top: 20px;
                right: 20px;
            }
            .row.g-5 > div { /* Target the direct column children of row g-5 */
                width: 100%; /* Make them full width on small screens */
            }
            .faq-item {
                margin-bottom: 18px;
            }
            .faq-question-wrapper {
                padding: 18px 20px;
            }
            .faq-question {
                font-size: 1rem;
            }
            .faq-arrow {
                font-size: 1.5rem;
            }
            .faq-answer {
                padding: 0 20px;
            }
            .faq-item.open .faq-answer {
                padding: 15px 20px 20px;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 20px 10px;
            }
            .faq-section {
                padding: 30px 20px;
                box-shadow: 0 10px 40px var(--shadow-medium);
            }
            .faq-title {
                font-size: 2.2rem;
                margin-bottom: 25px;
            }
            .faq-title::after {
                width: 70px;
                height: 4px;
            }
            .close-button {
                font-size: 2rem;
                top: 15px;
                right: 15px;
            }
            .faq-item {
                margin-bottom: 15px;
            }
            .faq-question-wrapper {
                padding: 15px 18px;
            }
            .faq-question {
                font-size: 0.95rem;
            }
            .faq-arrow {
                font-size: 1.2rem;
            }
            .faq-answer {
                font-size: 0.9rem;
                padding: 0 18px;
            }
            .faq-item.open .faq-answer {
                padding: 12px 18px 18px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="container faq-section">
        <button class="close-button" onclick="window.location.href='index.php'">×</button>

        <h1 class="faq-title"><?php echo getContent('faqs_main_heading'); ?></h1>
        <div class="row g-5">
            <div class="col-md-6">
                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q1'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a1'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q2'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a2'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q3'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a3'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q4'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a4'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q5'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a5'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q6'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a6_p1'); ?></p>
                        <p><?php echo getContent('faqs_a6_p2'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q7'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a7'); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q8'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a8'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q9'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a9'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q10'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a10'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q11'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a11'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q12'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a12_p1'); ?></p>
                        <p><?php echo getContent('faqs_a12_p2'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q13'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a13_p1'); ?></p>
                        <ul>
                            <li><?php echo getContent('faqs_a13_li1'); ?></li>
                            <li><?php echo getContent('faqs_a13_li2'); ?></li>
                            <li><?php echo getContent('faqs_a13_li3'); ?></li>
                        </ul>
                        <p><?php echo getContent('faqs_a13_p2'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q14'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a14'); ?></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question-wrapper">
                        <span class="faq-question"><?php echo getContent('faqs_q15'); ?></span>
                        <span class="faq-arrow">&#x2192;</span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo getContent('faqs_a15'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // JavaScript for collapsible FAQ functionality
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const questionWrapper = item.querySelector('.faq-question-wrapper');
                const answer = item.querySelector('.faq-answer');
                
                questionWrapper.addEventListener('click', function() {
                    item.classList.toggle('open');
                    
                    if (item.classList.contains('open')) {
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                    } else {
                        answer.style.maxHeight = '0';
                    }
                });
            });
        });
    </script>
</body>
</html>