<?php
// Include the database connection
include 'DBconnect.php';
session_start(); // Start session to access saved preferences

// Check if preferences are set in the session
if (!isset($_SESSION['preferences'])) {
    // If preferences are not set, redirect to the preferences page or display an error message
    header('Location: submit_preferences.php');
    exit();
}

// Retrieve preferences from session
$preferences = $_SESSION['preferences'];

// Extract preferences from the session
$gender = $preferences['gender'];
$age = $preferences['age'];
$religion = $preferences['religion'];
$education = $preferences['education'];
$language = $preferences['language'];
$nationality = $preferences['nationality'];
$occupation = $preferences['occupation'];

// Query the database to get matching profiles based on preferences
$sql = "
    SELECT u.First_Name, u.Age, u.City, u.Religion, u.Profession, pd.Language, u.Profile_Photo_URL,
    (
        (CASE WHEN u.Gender = '$gender' THEN 1 ELSE 0 END) +
        (CASE WHEN pd.Religion = '$religion' THEN 1 ELSE 0 END) +
        (CASE WHEN pd.Education = '$education' THEN 1 ELSE 0 END) +
        (CASE WHEN pd.Language = '$language' THEN 1 ELSE 0 END) +
        (CASE WHEN pd.Occupation = '$occupation' THEN 1 ELSE 0 END)
    ) AS match_score
    FROM User u
    JOIN Profile_Details pd ON u.user_id = pd.user_id
    WHERE u.user_id != '".$_SESSION['user_id']."' -- Exclude the current user
    ORDER BY match_score DESC, u.First_Name ASC";  // Sort by match score first, then alphabetically by name

// Execute the query
$result = mysqli_query($conn, $sql);

// Fetch all matching profiles
$profiles = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $profiles[] = $row;
    }
} else {
    // No matches found
    $profiles = [];
}

// Encode the profiles to JSON to pass them to the frontend
$profiles_json = json_encode($profiles);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matching Profiles</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Product+Sans&display=swap');

        body {
            font-family: 'Product Sans', Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 5px;
        }

        header {
            background: linear-gradient(90deg, #f7886cd6 0%, rgba(255, 42, 0, 0.784) 100%);
            padding: 40px;
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

        h2 {
            text-align: center;
            color: #f76c6c;
            margin-top: 20px;
        }

        /* Profile Container */
        .profile-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffe4e1;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            border: 2px solid #f76c6c;
        }

        .profile {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.5s ease;
        }

        .profile img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }

        .profile-info {
            flex: 1;
        }

        .profile-info h3 {
            margin: 0;
            color: #f76c6c;
        }

        .profile-info p {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }

        .match-percentage {
            font-size: 18px;
            font-weight: bold;
            color: #f76c6c;
        }

        .profile-actions {
            text-align: right;
        }

        .profile-actions button {
            background-color: #f76c6c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .profile-actions button:hover {
            background-color: #ff9999;
        }

        /* Scrollbar Styling */
        .profile-container::-webkit-scrollbar {
            width: 10px;
        }

        .profile-container::-webkit-scrollbar-thumb {
            background-color: #f76c6c;
            border-radius: 5px;
        }

        .profile-container::-webkit-scrollbar-track {
            background-color: #f0f8ff;
        }
    </style>
</head>

<body>

    <!-- Header with Logo and Navigation -->
    <header>
        <img src="icon.png" alt="Logo">
        <h1>Matrimonial Hub</h1>
        <div class="header-right">
            <a href="home.php">Home</a>
            <a href="submit_preferences.php">Set Preferences</a>
        </div>
    </header>

    <h2>Your Best Matches</h2>

    <!-- Container for Profile Results -->
    <div class="profile-container" id="profile-container">
        <!-- Profiles will be dynamically loaded here from the database -->
    </div>

    <script>
        // Retrieve profiles from PHP
        const profiles = <?php echo $profiles_json; ?>;

        function fetchProfiles() {
            const profileContainer = document.getElementById('profile-container');

            if (profiles.length === 0) {
                profileContainer.innerHTML = "<p>No matches found based on your preferences.</p>";
                return;
            }

            profiles.forEach(profile => {
                let profileDiv = document.createElement('div');
                profileDiv.classList.add('profile', 'reveal');

                profileDiv.innerHTML = `
                    <img src="${profile.Profile_Photo_URL || 'default_profile.jpg'}" alt="${profile.First_Name}">
                    <div class="profile-info">
                        <h3>${profile.First_Name}</h3>
                        <p><strong>Age:</strong> ${profile.Age}</p>
                        <p><strong>Location:</strong> ${profile.City}</p>
                        <p><strong>Religion:</strong> ${profile.Religion}</p>
                        <p><strong>Occupation:</strong> ${profile.Profession}</p>
                        <p class="match-percentage">${profile.match_score * 10}% Match</p>
                    </div>
                    <div class="profile-actions">
                        <button>View Profile</button>
                    </div>
                `;

                profileContainer.appendChild(profileDiv);
            });

            // Call the revealOnScroll function after loading the profiles dynamically
            revealOnScroll();
        }

        // Reveal on Scroll Animation
        function revealOnScroll() {
            const reveals = document.querySelectorAll('.reveal');
            reveals.forEach(function (reveal) {
                const windowHeight = window.innerHeight;
                const revealTop = reveal.getBoundingClientRect().top;
                const revealPoint = 150;

                if (revealTop < windowHeight - revealPoint) {
                    reveal.style.opacity = '1';
                    reveal.style.transform = 'translateY(0)';
                }
            });
        }

        window.addEventListener('scroll', revealOnScroll);

        // Trigger fetching profiles when the page loads
        window.onload = fetchProfiles;
    </script>

</body>

</html>
