<?php include_once 'get_content.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getContent('demo_confirmation_title'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9Oer2f3hU81YUuXoSM1+1QVxPEjD0xS5gLz9+9dF+R7" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Lato:wght@400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f0f2f5; /* Light subtle background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            text-align: center; /* Center content horizontally */
        }
        .confirmation-card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 50px;
            max-width: 600px;
            width: 100%;
            position: relative;
            animation: fadeInScale 0.6s ease-out;
        }
        .confirmation-card h1 {
            font-family: 'Poppins', sans-serif;
            color: #28a745; /* Green for success */
            font-size: 2.8rem;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .confirmation-card h1 .icon {
            font-size: 3rem;
            margin-right: 15px;
        }
        .confirmation-card p {
            font-size: 1.1rem;
            color: #555555;
            margin-bottom: 30px;
        }
        .confirmation-card .btn-home {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .confirmation-card .btn-home:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        /* Close Button Styling */
        .close-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            font-size: 2.5rem; /* Large 'x' */
            color: #ccc; /* Lighter color for subtlety */
            cursor: pointer;
            line-height: 1;
            padding: 0;
            transition: color 0.3s ease, transform 0.2s ease;
        }
        .close-button:hover {
            color: #999; /* Darker on hover */
            transform: rotate(90deg); /* Consistent rotation effect */
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .confirmation-card {
                padding: 30px;
            }
            .confirmation-card h1 {
                font-size: 2.2rem;
            }
            .confirmation-card h1 .icon {
                font-size: 2.5rem;
            }
            .confirmation-card p {
                font-size: 1rem;
            }
            .confirmation-card .btn-home {
                padding: 10px 25px;
            }
            .close-button {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="confirmation-card">
        <button class="close-button" onclick="window.location.href='index.php'">×</button>

        <h1>
            <span class="icon">&#x2705;</span> <?php echo getContent('demo_confirmation_heading'); ?>
        </h1>
        <p>
            <?php echo getContent('demo_confirmation_paragraph_1'); ?>
        </p>
        <p>
            <?php echo getContent('demo_confirmation_paragraph_2'); ?>
        </p>
        <a href="index.php" class="btn-home"><?php echo getContent('demo_confirmation_home_button'); ?></a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>