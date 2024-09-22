<?php
session_start();
include 'DBconnect.php'; // Include your database connection script

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Get the user ID from the session

// SQL query to find all users involved in accepted requests with the current user
$sql = "SELECT DISTINCT u.user_id, u.First_Name, u.Middle_Name, u.Last_Name, u.Profile_Photo_URL
        FROM User u
        INNER JOIN Request r ON u.user_id IN (r.receiver_id, r.sender_id) 
        WHERE (r.sender_id = ? OR r.receiver_id = ?) AND r.request_status = 'Accepted' AND u.user_id != ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $user_id, $user_id, $user_id); // Bind the user_id three times
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accepted Requests</title>
    <link href="https://fonts.googleapis.com/css2?family=Product+Sans&display=swap" rel="stylesheet">
    <style>
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
        .accepted-requests-list {
            margin-top: 20px;
        }
        .accepted-requests-list ul {
            list-style-type: none;
            padding-left: 0;
        }
        .accepted-requests-list li {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .accepted-requests-list img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }
        .chat-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-left: auto;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .chat-button:hover {
            background-color: #45a049;
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
            <img src="icon.png" alt="Matrimonial Hub Logo">
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
            
            <a href="submit_preferences.php">Search Matches</a>
            <a href="accepted_requests.php">My matches</a>
            <a href="my_profile_details.php">Edit Profile</a>
            <button onclick="window.location.href='message_requests.php';">Message Requests</button>
            <a href="dashboard.php">Go to Dashboard</a>
            
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h2>My Matches</h2>

            <!-- Accepted Requests List -->
            <div class="accepted-requests-list">
                <?php
                if ($result->num_rows > 0) {
                    echo "<ul>";
                    while ($row = $result->fetch_assoc()) {
                        // Combine first, middle, and last names into a full name
                        $full_name = $row['First_Name'] . ' ' . ($row['Middle_Name'] ?? '') . ' ' . $row['Last_Name'];
                        
                        // Display profile photo or default image if no photo is available
                        $profile_photo = !empty($row['Profile_Photo_URL']) ? 'uploads/' . htmlspecialchars($row['Profile_Photo_URL']) : 'images/default-profile.png';

                        // Chat button linking to chat.php with user_id as parameter
                        $chat_url = "chat.php?user_id=" . $row['user_id'];

                        echo "<li><img src='" . htmlspecialchars($profile_photo) . "' alt='Profile Photo'>" . htmlspecialchars(trim($full_name)) . "
                              <a href='" . htmlspecialchars($chat_url) . "' class='chat-button'>Chat</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No one has accepted your requests yet.</p>";
                }

                $stmt->close();
                $conn->close();
                ?>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 Matrimonial Hub - All Rights Reserved
    </footer>

</body>

</html>
