<?php
// Include the database connection
include 'DBconnect.php';
session_start(); // Start session to store the preferences

// Check if this is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect the form data
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $religion = $_POST['religion'];
    $education = $_POST['education'];
    $location = $_POST['location'];
    $language = $_POST['language'];
    $nationality = $_POST['nationality'];
    $occupation = $_POST['occupation'];
    $height = $_POST['height'];

    // Save the preferences in the session array
    $_SESSION['preferences'] = [
        'gender' => $gender,
        'age' => $age,
        'religion' => $religion,
        'education' => $education,
        'location' => $location,
        'language' => $language,
        'nationality' => $nationality,
        'occupation' => $occupation,
        'height' => $height,
        'diet' => $diet,
    ];

    // Redirect to the search results page
    header("Location: search_result.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Preferences</title>
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

        h2 {
            text-align: center;
            color: #f76c6c;
            margin-top: 20px;
        }

        form {
            background-color: #ffe4e1;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            border: 2px solid #f76c6c;
        }

        form label {
            font-size: 18px;
            color: #333;
        }

        form input, form select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 2px solid #f76c6c;
            font-size: 16px;
        }

        form button {
            width: 100%;
            padding: 12px;
            background-color: #f76c6c;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #ff9999;
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
        </div>
    </header>

    <h2>Set Your Preferences</h2>

    <form action="submit_preferences.php" method="post">
        <!-- Gender Preference -->
        <label for="gender">Preferred Gender:</label>
        <select id="gender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>

        <!-- Age Group Preference -->
        <label for="age">Preferred Age Group:</label>
        <select id="age" name="age">
            <option value="18-25">18-25</option>
            <option value="26-35">26-35</option>
            <option value="36-45">36-45</option>
            <option value="45+">45+</option>
        </select>

        <!-- Religion Preference -->
        <label for="religion">Preferred Religion:</label>
        <select id="religion" name="religion">
            <option value="any">Any</option>
            <option value="hindu">Hindu</option>
            <option value="muslim">Muslim</option>
            <option value="christian">Christian</option>
            <option value="sikh">Sikh</option>
            <option value="jain">Jain</option>
            <option value="other">Other</option>
        </select>

        <!-- Education Level Preference -->
        <label for="education">Preferred Education Level:</label>
        <select id="education" name="education">
            <option value="any">Any</option>
            <option value="highschool">High School</option>
            <option value="bachelor">Bachelor's</option>
            <option value="master">Master's</option>
            <option value="phd">Ph.D</option>
        </select>

        <!-- Location Preference -->
        <label for="location">Preferred Location:</label>
        <select id="location" name="location">
            <option value="city1">City 1</option>
            <option value="city2">City 2</option>
            <option value="city3">City 3</option>
            <option value="other">Other</option>
        </select>

        <!-- Language Preference -->
        <label for="language">Preferred Language:</label>
        <select id="language" name="language">
            <option value="any">Any</option>
            <option value="english">English</option>
            <option value="hindi">Hindi</option>
            <option value="spanish">Spanish</option>
            <option value="french">French</option>
            <option value="other">Other</option>
        </select>

        <!-- Nationality Preference -->
        <label for="nationality">Preferred Nationality:</label>
        <select id="nationality" name="nationality">
            <option value="any">Any</option>
            <option value="indian">Indian</option>
            <option value="american">American</option>
            <option value="british">British</option>
            <option value="australian">Australian</option>
            <option value="canadian">Canadian</option>
            <option value="other">Other</option>
        </select>

        <!-- Occupation Preference -->
        <label for="occupation">Preferred Occupation:</label>
        <select id="occupation" name="occupation">
            <option value="any">Any</option>
            <option value="engineer">Engineer</option>
            <option value="doctor">Doctor</option>
            <option value="teacher">Teacher</option>
            <option value="business">Business</option>
            <option value="other">Other</option>
        </select>

        <!-- Height Preference -->
        <label for="height">Preferred Height Range:</label>
        <input type="text" id="height" name="height" placeholder="e.g., 5'4'' - 6'0''">

        <button type="submit">Submit Preferences</button>
    </form>

</body>

</html>
