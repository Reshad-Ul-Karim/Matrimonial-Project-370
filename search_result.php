<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Include database connection file
include('DBconnect.php');

// Get the query parameters from the URL (passed from the search form)
$profession = isset($_GET['profession']) ? htmlspecialchars($_GET['profession']) : '';
$gender = isset($_GET['gender']) ? htmlspecialchars($_GET['gender']) : '';
$religion = isset($_GET['religion']) ? htmlspecialchars($_GET['religion']) : '';
$ethnicity = isset($_GET['ethnicity']) ? htmlspecialchars($_GET['ethnicity']) : '';
$marital_status = isset($_GET['marital_status']) ? htmlspecialchars($_GET['marital_status']) : '';
$secondary_education = isset($_GET['secondary_education']) ? htmlspecialchars($_GET['secondary_education']) : '';
$higher_secondary = isset($_GET['higher_secondary']) ? htmlspecialchars($_GET['higher_secondary']) : '';
$undergrade = isset($_GET['undergrade']) ? htmlspecialchars($_GET['undergrade']) : '';
$post_grade = isset($_GET['post_grade']) ? htmlspecialchars($_GET['post_grade']) : '';
$complexion = isset($_GET['complexion']) ? htmlspecialchars($_GET['complexion']) : '';
$height = isset($_GET['height']) ? floatval($_GET['height']) : 0;
$min_age = isset($_GET['min_age']) ? intval($_GET['min_age']) : 0;
$max_age = isset($_GET['max_age']) ? intval($_GET['max_age']) : 100;

$matches = [];

// SQL to join User and Profile_Details and compare preferences
$sql = "SELECT 
    U.user_id, U.First_Name, U.Middle_Name, U.Last_Name, U.Profession, U.Gender, U.Religion, U.Ethnicity, U.DOB, 
    PD.Marital_Status, PD.Secondary_Education, PD.Higher_Secondary, PD.Undergrade, PD.Post_Grade, PD.Complexion, PD.Height
FROM 
    User AS U
JOIN 
    Profile_Details AS PD ON U.user_id = PD.user_id
WHERE 
    U.user_id != ? AND U.Account_Status = 'Active'";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

// Compare and store matches
while ($user = $result->fetch_assoc()) {
    $match_count = 0;

    // Calculate age
    $dob = new DateTime($user['DOB']);
    $today = new DateTime();
    $age = $today->diff($dob)->y; // Calculate age in years

    // Full name concatenation (if Middle_Name is available)
    $full_name = trim($user['First_Name'] . ' ' . ($user['Middle_Name'] ?? '') . ' ' . $user['Last_Name']);

    // Matching logic for each preference
    if ($user['Profession'] === $profession) $match_count++;
    if ($user['Gender'] === $gender) $match_count++;
    if ($user['Religion'] === $religion) $match_count++;
    if ($user['Ethnicity'] === $ethnicity) $match_count++;
    if ($user['Marital_Status'] === $marital_status) $match_count++;
    if ($user['Secondary_Education'] === $secondary_education) $match_count++;
    if ($user['Higher_Secondary'] === $higher_secondary) $match_count++;
    if ($user['Undergrade'] === $undergrade) $match_count++;
    if ($user['Post_Grade'] === $post_grade) $match_count++;
    if ($user['Complexion'] === $complexion) $match_count++;

    // Check height and age match
    if ($user['Height'] > $height && $age >= $min_age && $age <= $max_age) {
        $match_count++; // Increment if height and age match
    }

    // Store the match if match_count is greater than 0
    if ($match_count > 0) {
        $matches[] = ['user_id' => $user['user_id'], 'name' => $full_name, 'match_count' => $match_count, 'age' => $age, 'profession' => $user['Profession'], 'religion' => $user['Religion'], 'ethnicity' => $user['Ethnicity']];
    }
}

// Sort matches by match_count in descending order
usort($matches, function($a, $b) {
    return $b['match_count'] - $a['match_count'];
});
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
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            flex-wrap: wrap; /* Ensure proper wrapping on smaller screens */
            
            text-align: center;
            position: relative; /* Ensures content stays within boundaries */
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

    <header>
        <img src="icon.png" alt="Logo">
        <h1>Matrimonial Hub</h1>
        <div class="header-right">
            <a href="home.php">Home</a>
            <a href="submit_preferences.php">Set Preferences</a>
        </div>
    </header>

    <h2>Your Best Matches</h2>

    <div class="profile-container" id="profile-container">
        <?php if (!empty($matches)): ?>
            <?php foreach ($matches as $match): ?>
                <div class="profile reveal">
                    <img src="default-profile.png" alt="Profile Image"> <!-- Placeholder image -->
                    <div class="profile-info">
                        <h3><?= htmlspecialchars($match['name']) ?></h3>
                        <p><strong>Age:</strong> <?= $match['age'] ?></p>
                        <p><strong>Profession:</strong> <?= htmlspecialchars($match['profession']) ?></p>
                        <p><strong>Religion:</strong> <?= htmlspecialchars($match['religion']) ?></p>
                        <p><strong>Ethnicity:</strong> <?= htmlspecialchars($match['ethnicity']) ?></p>
                        <p class="match-percentage"><?= $match['match_count'] ?> Matches</p>
                    </div>
                    <div class="profile-actions">
                        <a href="chatapp.php?user_id=<?= htmlspecialchars($match['user_id']) ?>">
                            <button>Send Message Request</button>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No matches found.</p>
        <?php endif; ?>
    </div>

    <script>
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
    </script>

</body>

</html>
