<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrimonial Website</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Product+Sans&display=swap');

        body {
            font-family: 'Product Sans';
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        header {
            background: linear-gradient(90deg, #D76D77 0%, #BA4A5F 50%, #8A2B3C 100%);
            
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        header h1 {
            flex-grow: 1;
            text-align: center;
            margin: 0;
        }

        .header-right {
            display: flex;
            gap: 0px;
        }

        header img {
            width: 50px;
            height: 50px;
            margin-right: 0px;
            margin-left: 40px;
        }

        .header-right {
            display: flex;
            gap: 10px;
        }

        .header-right a {
            background-color: #f76c6c;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 50px;
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
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 50px;
            color: white;
            margin: 0;
            text-align: center;
            width: 90%; /* Ensure the text doesn't overflow */
            max-width: 1200px; /* Optional: Set a max width */
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
         /* Floating Buttons */
         .floating-chat-btn, .floating-support-btn {
            position: fixed;
            right: 20px; /* Distance from the right */
            background-color: white; /* Background color */
            padding: 8px; /* Slightly increased padding */
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 1000; /* Ensure it appears above other elements */
            transition: background-color 0.3s ease;
        }

        /* Chat Button */
        .floating-chat-btn {
            bottom: 110px; /* Adjusted to leave space for the support button */
        }

        /* Support Button */
        .floating-support-btn {
            bottom: 40px; /* Adjusted spacing between buttons */
        }

        .floating-chat-btn img {
            width: 40px; /* Increased size of the chat icon */
            height: 40px;
        }
        .floating-support-btn img {
            width: 35px; /* Size of the support icon remains the same */
            height: 35px;
        }

        .floating-chat-btn:hover, .floating-support-btn:hover {
            background-color: #f0f0f0; /* Slightly darker background on hover */
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
            <a href="index.php">Login</a>
            <a href="admin_login.php">Admin</a>
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
            <input type="text" placeholder="Find your match..." href="login.html"> 
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
            <button><a href="index.php">Search</a></button>
        </div>

        <!-- Buttons Section -->
        <div class="buttons-container">
            <a href="aboutus.html">About Us</a>
            <a href="clientstories.html">Client Stories</a>
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
            <img src="img/biyai14.jpg" alt="Client Wedding 1">
            <p>Priya & Raj: "A big thanks to Matrimonial Hub for finding my perfect match!"</p>
        </div>
        <div class="client-review-card">
            <img src="img/biye2ai.jpg" alt="Client Wedding 2">
            <p>Sahil & Aditi: "We couldn't be happier. Thank you!"</p>
        </div>
        <div class="client-review-card">
            <img src="img/biyeai9.jpg" alt="Client Wedding 3">
            <p>Rahul & Sneha: "Thank you for making this journey possible."</p>
        </div>
        <div class="client-review-card">
            <img src="img/biyeai3.jpg" alt="Client Wedding 4">
            <p>Anjali & Aman: "Thank you Matrimonial Hub."</p>
        </div>
        <div class="client-review-card">
            <img src="img/biyeai8.jpeg" alt="Client Wedding 5">
            <p>Sonu & Yahi: "Thanks for this."</p>
        </div>
        <div class="client-review-card">
            <img src="img/biyeai9.jpg" alt="Client Wedding 6">
            <p>Rupuu & Ruhan: "Grateful to Matrimonial Hub for connecting our paths."</p>
        </div>
    </div>

    <!-- Plan Your Wedding Section -->
    <div class="wedding-planning">
        <h2>Plan Your Wedding with Us</h2>
        <p>Let us take care of all your wedding planning needs. From venue selection to decor and catering, we ensure every detail is perfect.</p>
        <a href="aboutus.html">Learn More</a>
    </div>

    <footer>
        <p>&copy; 2024 Matrimonial Hub. All Rights Reserved.</p>
        <div class="footer-links">
            <a href="privacy.php">Privacy Policy</a> |
            <a href="terms.php">Terms & Conditions</a> |
            <a href="contact.php">Contact Us</a>
        </div>
    </footer>
    <!-- Floating Chat Button -->
    <div class="floating-chat-btn" onclick="location.href='chatapp/index.php'">
            <img src="party.png" alt="Chat" />
    </div>
    
        <!-- Floating Customer Support Button -->
    <div class="floating-support-btn" onclick="location.href='https://bangladesh.gov.bd/site/page/aaebba14-f52a-4a3d-98fd-a3f8b911d3d9'">
            <img src="customer-service.png" alt="Support" />
    </div>

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