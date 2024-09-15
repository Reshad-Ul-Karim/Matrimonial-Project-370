<?php
session_start(); // Start the session

// Check if the user is logged in, otherwise redirect to login page

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect preferences from the form
    $preferred_religion = $_POST['preferred_religion'] ?? 'Other';
    $preferred_height = $_POST['preferred_height'] ?? 0;
    $preferred_ethnicity = $_POST['preferred_ethnicity'] ?? '';
    $preferred_pets = $_POST['preferred_pets'] ?? 'Other';
    $preferred_gender = $_POST['preferred_gender'] ?? 'Other';

    // Redirect to a matching script or handle matching here
    header("Location: match.php?religion=$preferred_religion&height=$preferred_height&ethnicity=$preferred_ethnicity&pets=$preferred_pets&gender=$preferred_gender");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrimonial Website</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Product+Sans&display=swap');

        body {
            font-family: 'Product Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        header {
            background: linear-gradient(90deg, #f7886cd6 0%, rgba(255, 42, 0, 0.784) 100%);
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        header img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .header-right {
            display: flex;
            gap: 20px;
        }

        .header-right a {
            background-color: #f76c6c;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }

        .header-right a:hover {
            background-color: #ff9999;
        }

        /* Hero Section with Video Background */
        .hero-section {
            position: relative;
            height: 550px;
            overflow: hidden;
        }

        .hero-section video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .hero-section h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 36px;
            color: white;
            margin: 0;
            text-align: center;
        }

        /* Search Bar */
        .search-container {
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            justify-content: center;
            z-index: 1;
        }

        .search-container input,
        .search-container select {
            padding: 12px;
            border-radius: 20px;
            border: 2px solid #f76c6c;
            font-size: 16px;
            margin-right: 10px;
        }

        .search-container button {
            background-color: #f76c6c;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
        }

        /* Buttons on Hero Section */
        .buttons-container {
            position: absolute;
            top: 75%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 1;
        }

        .buttons-container a {
            background-color: #f76c6c;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            margin: 10px;
            display: inline-block;
        }

        .buttons-container a:hover {
            background-color: #ff9999;
        }

        /* Centered Welcome Note */
        .welcome-note {
            text-align: center;
            margin: 40px 0;
            font-size: 20px;
            padding: 14px;
            max-width: 800px;
            margin: 40px auto;
            background-color: #ffe4e1;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            border: 2px solid #f76c6c;
            position: relative;
        }

        .welcome-note:before,
        .welcome-note:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background-color: #f76c6c;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 10px;
        }

        .welcome-note:after {
            top: auto;
            bottom: -10px;
        }

        /* Client Reviews Section */
        .client-reviews-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-height: 600px;
            overflow-y: scroll;
            padding: 25px;
            margin: 40px auto;
            gap: 20px;
            background-color: #ffe4e1;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            width: 80%;
            opacity: 0;
            transform: translateY(50px);
            transition: all 1s ease-out;
        }

        .client-review-card {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px;
            width: 95%;
        }

        .client-review-card img {
            width: 200px;
            height: 170px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }

        .client-review-card p {
            font-size: 16px;
            color: #333;
        }

        .client-reviews-container::-webkit-scrollbar {
            width: 8px;
        }

        .client-reviews-container::-webkit-scrollbar-thumb {
            background-color: #f76c6c;
            border-radius: 8px;
        }

        /* Plan Your Wedding Section */
        .wedding-planning {
            text-align: center;
            margin: 40px auto;
            padding: 20px;
            background: linear-gradient(90deg, #f76c6c, #ff9999);
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            color: white;
            max-width: 80%;
        }

        .wedding-planning h2 {
            font-size: 28px;
        }

        .wedding-planning p {
            font-size: 18px;
        }

        .wedding-planning a {
            display: inline-block;
            background-color: white;
            color: #f76c6c;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 10px;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #f76c6c;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .footer-links {
            margin-top: 20px;
        }

        .footer-links a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        /* Reveal on Scroll Animation */
        .reveal {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>

    <!-- Header with Logo and Sign In/Sign Up -->
    <header>
        <img src="icon.png" alt="Logo">
        <h1>Matrimonial Hub</h1>
        <div class="header-right">
            <a href="register.php">Sign Up</a>
            <a href="index.php">Sign In</a>
        </div>
    </header>

    <!-- Hero Section with Video Background -->
    <div class="hero-section">
        <video autoplay muted loop>
            <source src="videoplayback.mp4" type="video/mp4">
            
            Your browser does not support the video tag.
        </video>
        <h1>Your Journey to a Beautiful Marriage Begins Here</h1>

        <!-- Search Bar Section -->
        <div class="search-container">
            <input type="text" placeholder="Find your match...">
            <select>
                <option value="gender">Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <select>
                <option value="age">Age Group</option>
                <option value="18-25">18-25</option>
                <option value="26-35">26-35</option>
                <option value="36-45">36-45</option>
            </select>
            <select>
                <option value="location">Location</option>
                <option value="city1">City 1</option>
                <option value="city2">City 2</option>
                <option value="city3">City 3</option>
            </select>
            <button>Search</button>
        </div>

        <!-- Buttons Section -->
        <div class="buttons-container">
            <a href="aboutus.html">About Us</a>
            <a href="client_stories.html">Client Stories</a>
            <a href="help.html">Help</a>
        </div>
    </div>

    <!-- Centered Welcome Note -->
    <div class="welcome-note">
        <p>We are excited to have you here! Matrimonial Hub is a trusted platform that has helped countless people find their life partners. Join us today and let us help you find the love of your life.</p>
    </div>

    <!-- Client Reviews Section -->
    <div class="client-reviews-container" id="client-reviews">
        <div class="client-review-card">
            <img src="biyeai.jpg" alt="Client Wedding 1">
            <p>Priya & Raj: "A big thanks to Matrimonial Hub for finding my perfect match!"</p>
        </div>
        <div class="client-review-card">
            <img src="biye2ai.jpg" alt="Client Wedding 2">
            <p>Sahil & Aditi: "We couldn't be happier. Thank you!"</p>
        </div>
        <div class="client-review-card">
            <img src="biyai14.jpg" alt="Client Wedding 3">
            <p>Rahul & Sneha: "Thank you for making this journey possible."</p>
        </div>
        <div class="client-review-card">
            <img src="biyeai3.jpg" alt="Client Wedding 4">
            <p>Anjali & Aman: "Thank you Matrimonial Hub."</p>
        </div>
        <div class="client-review-card">
            <img src="biyeai8.jpeg" alt="Client Wedding 5">
            <p>Sonu & Yahi: "Thanks for this."</p>
        </div>
        <div class="client-review-card">
            <img src="biye7ai.jpg" alt="Client Wedding 6">
            <p>Rupuu & Ruhan: "Grateful to Matrimonial Hub for connecting our paths."</p>
        </div>
    </div>

    <!-- Plan Your Wedding Section -->
    <div class="wedding-planning">
        <h2>Plan Your Wedding with Us</h2>
        <p>Let us take care of all your wedding planning needs. From venue selection to decor and catering, we ensure every detail is perfect.</p>
        <a href="plan_wedding.html">Learn More</a>
    </div>

    <footer>
        <p>&copy; 2024 Matrimonial Hub. All Rights Reserved.</p>
        <div class="footer-links">
            <a href="privacy.php">Privacy Policy</a> |
            <a href="terms.php">Terms & Conditions</a> |
            <a href="contact.php">Contact Us</a>
        </div>
    </footer>

    <script>
        // Reveal on Scroll Animation
        function revealOnScroll() {
            const clientReviews = document.getElementById('client-reviews');
            const windowHeight = window.innerHeight;
            const revealTop = clientReviews.getBoundingClientRect().top;
            const revealPoint = 150;

            if (revealTop < windowHeight - revealPoint) {
                clientReviews.classList.add('reveal');
            }
        }

        window.addEventListener('scroll', revealOnScroll);
    </script>

</body>

</html>