<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'DBconnect.php'; // Assume database connection is handled in this file

$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $secondaryEducation = htmlspecialchars($_POST['secondary_education']);
    $higherSecondary = htmlspecialchars($_POST['higher_secondary']);
    $undergrade = htmlspecialchars($_POST['undergrade']);
    $postGrade = htmlspecialchars($_POST['post_grade']);
    $maritalStatus = htmlspecialchars($_POST['marital_status']);
    $interest = htmlspecialchars($_POST['interest']);
    $hobbies = htmlspecialchars($_POST['hobbies']);
    $height = (float)$_POST['height'];
    $weight = (float)$_POST['weight'];
    $complexion = htmlspecialchars($_POST['complexion']);
    $biography = htmlspecialchars($_POST['biography']);
    $familyBackground = htmlspecialchars($_POST['family_background']);

    // Update or insert logic
    $query = "REPLACE INTO Profile_Details (user_id, Secondary_Education, Higher_Secondary, Undergrade, Post_Grade, Marital_Status, Interest, Hobbies, Height, Weight, Complexion, Biography, Family_Background) VALUES ('$user_id', '$secondaryEducation', '$higherSecondary', '$undergrade', '$postGrade', '$maritalStatus', '$interest', '$hobbies', $height, $weight, '$complexion', '$biography', '$familyBackground')";
    mysqli_query($conn, $query);
}

// Fetch existing data
$result = mysqli_query($conn, "SELECT * FROM Profile_Details WHERE user_id = '$user_id'");
$profile = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <style>
        input[type="text"], textarea, select {
            width: 100%; /* Full width */
            padding: 12px; /* Some padding */
            margin: 8px 0; /* Some margin */
            display: inline-block; /* Making sure it's on its own line */
            border: 1px solid #ccc; /* Gray border */
            border-radius: 4px; /* Rounded borders */
            box-sizing: border-box; /* Makes sure padding doesn't affect width */
        }
        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        form {
            width: 50%; /* Set the width of the form */
            margin: auto; /* Center the form on the page */
        }
    </style>
</head>
<body>
    <h1>User Profile</h1>
    <?php if ($profile): ?>
        <p>Secondary Education: <?= $profile['Secondary_Education'] ?></p>
        <!-- Display other fields similarly -->
    <?php else: ?>
        <p>No profile details found. Please add your information.</p>
    <?php endif; ?>

    <form method="post">
        Secondary Education: <input type="text" name="secondary_education" value="<?= $profile['Secondary_Education'] ?? '' ?>"><br>
        Higher Secondary: <input type="text" name="higher_secondary" value="<?= $profile['Higher_Secondary'] ?? '' ?>"><br>
        Undergraduate Degree: <input type="text" name="undergrade" value="<?= $profile['Undergrade'] ?? '' ?>"><br>
        Postgraduate Degree: <input type="text" name="post_grade" value="<?= $profile['Post_Grade'] ?? '' ?>"><br>
        Marital Status: <select name="marital_status">
            <option value="Single" <?= $profile['Marital_Status'] == 'Single' ? 'selected' : '' ?>>Single</option>
            <option value="Married" <?= $profile['Marital_Status'] == 'Married' ? 'selected' : '' ?>>Married</option>
            <option value="Divorced" <?= $profile['Marital_Status'] == 'Divorced' ? 'selected' : '' ?>>Divorced</option>
            <option value="Widowed" <?= $profile['Marital_Status'] == 'Widowed' ? 'selected' : '' ?>>Widowed</option>
        </select><br>
        Interests: <textarea name="interest"><?= $profile['Interest'] ?? '' ?></textarea><br>
        Hobbies: <textarea name="hobbies"><?= $profile['Hobbies'] ?? '' ?></textarea><br>
        Height (cm): <input type="text" name="height" value="<?= $profile['Height'] ?? '' ?>"><br>
        Weight (kg): <input type="text" name="weight" value="<?= $profile['Weight'] ?? '' ?>"><br>
        Complexion: <select name="complexion">
            <option value="Fair" <?= $profile['Complexion'] == 'Fair' ? 'selected' : '' ?>>Fair</option>
            <option value="Medium" <?= $profile['Complexion'] == 'Medium' ? 'selected' : '' ?>>Medium</option>
            <option value="Dark" <?= $profile['Complexion'] == 'Dark' ? 'selected' : '' ?>>Dark</option>
            <option value="Olive" <?= $profile['Complexion'] == 'Olive' ? 'selected' : '' ?>>Olive</option>
            <option value="Tan" <?= $profile['Complexion'] == 'Tan' ? 'selected' : '' ?>>Tan</option>
        </select><br>
        Biography: <textarea name="biography"><?= $profile['Biography'] ?? '' ?></textarea><br>
        Family Background: <textarea name="family_background"><?= $profile['Family_Background'] ?? '' ?></textarea><br>
        <input type="submit" value="Save Profile">
    </form>
</body>
</html>