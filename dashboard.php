<?php
session_start();
include 'DBconnect.php'; // Include your database connection

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to the login page if the user is not logged in
    exit();
}

function calculateAge($dob) {
    $dob = new DateTime($dob); // Convert date of birth to DateTime object
    $currentDate = new DateTime(); // Get the current date
    $age = $currentDate->diff($dob); // Calculate the difference between current date and date of birth
    return $age->y; // Return the age in years
}

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session during login

// Updated SQL Query: Retrieve user details along with profile picture URL
$sql = "SELECT u.First_Name, u.Last_Name, u.Middle_Name, u.Email, u.DOB, u.Profile_Photo_URL
        FROM User u
        WHERE u.user_id = '$user_id'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // Fetch user data
    $user = mysqli_fetch_assoc($result);
    $user_name = $user['First_Name'] .' '. $user['Middle_Name'] .' '. $user['Last_Name'];
    $email = $user['Email'];
    $DOB = $user['DOB'];
    $age = calculateAge($DOB);
    $profile_photo = !empty($user['Profile_Photo_URL']) ? 'uploads/' . htmlspecialchars($user['Profile_Photo_URL']) : 'images/default-profile.png'; // Adjusted image path
} else {
    // If user is not found, log them out and redirect to login page
    header("Location: logout.php");
    exit();
}

// Example queries for statistics
$profile_views = 102; // Replace with actual queries if you have profile view tracking
$matches_found = 15;  // Replace with a query that counts matching profiles
$messages_received = 8; // Replace with a query that counts the number of received messages
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrimonial Dashboard</title>
    <style>
        /* Your existing CSS for layout, typography, and styling */
        @import url('https://fonts.googleapis.com/css2?family=Product+Sans&display=swap');
        body {
            font-family: 'Product Sans', Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background: linear-gradient(90deg, #f7886cd6 0%, rgba(255, 42, 0, 0.784) 100%);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo-container img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }
        .title {
            font-size: 24px;
        }
        .sign-out {
            background-color: #f76c6c;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .sign-out:hover {
            background-color: #ff9999;
        }
        .dashboard-container {
            display: flex;
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffe4e1;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            flex: 1;
        }
        .sidebar {
            flex: 1;
            background-color: #f76c6c;
            padding: 20px;
            border-radius: 10px;
            color: white;
        }
        .sidebar a, .sidebar button {
            display: block;
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #ff9999;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .sidebar button {
            border: none;
            cursor: pointer;
        }
        .sidebar a:hover, .sidebar button:hover {
            background-color: #ffcccc;
        }
        .main-content {
            flex: 3;
            margin-left: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        }
        .profile-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }
        .actions button {
            background-color: #f76c6c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .actions button:hover {
            background-color: #ff9999;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #f7886cd6;
            color: white;
            margin-top: auto;
        }
    </style>
</head>

<body>

    <!-- Header with Logo, Title, and Sign-out Button -->
    <header>
        <div class="logo-container">
            <img src="path/to/your/logo.png" alt="Matrimonial Hub Logo">
            <h1 class="title">Matrimonial Hub</h1>
        </div>
        <!-- Sign-out button -->
        <a href="logout.php" class="sign-out">Sign Out</a>
    </header>

    <!-- Dashboard Main Content -->
    <div class="dashboard-container">

        <!-- Sidebar with Links -->
        <div class="sidebar">
            <h2>Menu</h2>
            <a href="view_matches.php">View Matches</a>
            <a href="submit_preferences.php">Search Matches</a>
            <a href="my_profile_details.php">My Profile</a>
            <a href="account_settings.php">Account Settings</a>
            <button onclick="window.location.href='message_requests.php';">Message Requests</button>
            <!-- New link to show accepted requests -->
            <a href="accepted_requests.php">Accepted Requests</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">

            <!-- Profile Information -->
            <div class="profile-info" style="display: flex; align-items: center;">
        
                <img src="<?php echo htmlspecialchars($profile_photo); ?>" alt="User Profile Picture">
                <div>
                    <h2>Welcome, <?php echo htmlspecialchars($user_name); ?></h2>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                    <p><strong>Age:</strong> <?php echo htmlspecialchars($age); ?></p>
                </div>
            </div>

            <!-- Profile Statistics -->
            <div class="profile-stats">
                <h2>Your Profile Stats</h2>
                <div class="stats-grid">
                    <div class="stat-box">
                        <h3>Profile Views</h3>
                        <p><?php echo $profile_views; ?></p>
                    </div>
                    <div class="stat-box">
                        <h3>Matches Found</h3>
                        <p><?php echo $matches_found; ?></p>
                    </div>
                    <div the="stat-box">
                        <h3>Messages Received</h3>
                        <p><?php echo $messages_received; ?></p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="actions">
                <button onclick="window.location.href='search_result.php';">View Matches</button>
                <button onclick="window.location.href='edit_preferences.php';">Edit Preferences</button>
                <button onclick="window.location.href='login.php';">chat</button>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 Matrimonial Hub - All Rights Reserved
    </footer>

</body>

</html>
