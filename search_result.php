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
        $matches[] = ['user_id' => $user['user_id'], 'name' => $full_name, 'match_count' => $match_count];
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
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .match-count {
            font-weight: bold;
            color: #4CAF50;
        }
    </style>
</head>
<body>

<h2>Search Results</h2>

<?php if (!empty($matches)): ?>
    <ul>
        <?php foreach ($matches as $match): ?>
            <li>
                Name: <?= htmlspecialchars($match['name']) ?> <br>
                Matches: <span class="match-count"><?= $match['match_count'] ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No matches found.</p>
<?php endif; ?>

</body>
</html>
