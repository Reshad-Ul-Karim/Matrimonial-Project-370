<?php
session_start(); // Start the session

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

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
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Product Sans', Arial, sans-serif;
        }

        #myVideo {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -100;
            background-size: cover;
        }

        .content {
            position: relative;
            z-index: 1;
            padding: 10px;
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

        .hero-section h1 {
            font-size: 36px;
            color: white;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .search-container input, .search-container select {
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

        .client-reviews-container {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            background-color: #f2f2f2;
            opacity: 0;
            transform: translateY(50px);

            transform: translateY(50px);
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
        }

        .client-review-card {
            max-width: 300px;
            margin: 10px;
            padding: 10px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            text-align: center;
        }

        .client-review-card img {
            width: 100%;
            border-radius: 5px;
        }

        .reveal {
            opacity: 1;
            transform: translateY(0px);
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #f76c6c;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <video autoplay muted loop id="myVideo">
        <source src="videoplayback.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <div class="content">
        <header>
            <img src="icon.png" alt="Logo">
            <h1>Matrimonial Hub</h1>
            <div class="header-right">
                <a href="signup.html">Sign Up</a>
                <a href="login.html">Sign In</a>
            </div>
        </header>

        <div class="hero-section">
            <h1>Your Journey to a Beautiful Marriage Begins Here</h1>
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
                <img src="biyeai3.jpg" alt="Client Wedding 3">
                <p>Rahul & Sneha: "Thank you for making this journey possible."</p>
            </div>
            <div class="client-review-card">
                <img src="biye11.webp" alt="Client Wedding 4">
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

        <!-- Footer -->
        <footer>
            <p>&copy; 2024 Matrimonial Hub. All Rights Reserved.</p>
            <a href="privacy.php">Privacy Policy</a> |
            <a href="terms.php">Terms & Conditions</a> |
            <a href="contact.php">Contact Us</a>
        </footer>
    </div>

    <script>
        const video = document.getElementById('myVideo');
        function controlVideo() {
            if (window.scrollY === 0) {
                video.play();
            } else {
                video.pause();
            }
        }

        function revealOnScroll() {
            const clientReviews = document.getElementById('client-reviews');
            const windowHeight = window.innerHeight;
            const revealTop = clientReviews.getBoundingClientRect().top;
            const revealBottom = clientReviews.getBoundingClientRect().bottom;
            const revealPoint = 150;

            // Reveal when the top of the client reviews is within the viewport
            if (revealTop < windowHeight - revealPoint && revealBottom > revealPoint) {
                clientReviews.classList.add('reveal');
            } 
            // Hide when the bottom of the client reviews is out of the viewport (scrolling up)
            if (revealBottom < revealPoint || revealTop > windowHeight) {
                clientReviews.classList.remove('reveal');
            }
        }



        window.addEventListener('scroll', () => {
            controlVideo();
            revealOnScroll();
        });
    </script>
</body>
</html>

