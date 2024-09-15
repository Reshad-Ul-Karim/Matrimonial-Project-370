<?php
// Start session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection file
include('DBconnect.php'); // Modify this line according to your database connection setup

// Get the user_id from session
$user_id = $_SESSION['user_id'];

// Initialize default values as empty in case no profile details are found
$email = $profession = $dob = $gender = $religion = $ethnicity = $first_name = $middle_name = $last_name = $profile_photo_url = '';
$secondary_education = $higher_secondary = $undergrade = $post_grade = $road_number = $street_number = $building_number = $phone_number = $marital_status = $interest = $hobbies = $height = $weight = $complexion = $biography = $family_background = '';

// Handle form submission for editing the profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $profession = $_POST['profession'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $religion = $_POST['religion'];
    $ethnicity = $_POST['ethnicity'];
    $marital_status = $_POST['marital_status'];
    $secondary_education = $_POST['secondary_education'];
    $higher_secondary = $_POST['higher_secondary'];
    $undergrade = $_POST['undergrade'];
    $post_grade = $_POST['post_grade'];
    $road_number = $_POST['road_number'];
    $street_number = $_POST['street_number'];
    $building_number = $_POST['building_number'];
    $interest = $_POST['interest'];
    $hobbies = $_POST['hobbies'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $complexion = $_POST['complexion'];
    $biography = $_POST['biography'];
    $family_background = $_POST['family_background'];

    // Update profile details in the database
    $sql_update = "
    UPDATE User u
    JOIN Profile_Details pd ON u.user_id = pd.user_id
    SET 
        u.First_Name = ?, u.Middle_Name = ?, u.Last_Name = ?, u.Profession = ?, u.Email = ?, u.DOB = ?, u.Gender = ?, u.Religion = ?, u.Ethnicity = ?,
        pd.phone_number = ?, pd.Marital_Status = ?, pd.Secondary_Education = ?, pd.Higher_Secondary = ?, pd.Undergrade = ?, pd.Post_Grade = ?, pd.road_number = ?, pd.street_number = ?, pd.building_number = ?, pd.Interest = ?, pd.Hobbies = ?, pd.Height = ?, pd.Weight = ?, pd.Complexion = ?, pd.Biography = ?, pd.Family_Background = ?
    WHERE u.user_id = ?
    ";

    if ($stmt = $conn->prepare($sql_update)) {
        $stmt->bind_param(
            "ssssssssssssssssssssssssss", // 26 placeholders
            $first_name, $middle_name, $last_name, $profession, $email, $dob, $gender, $religion, $ethnicity, 
            $phone_number, $marital_status, $secondary_education, $higher_secondary, $undergrade, $post_grade, 
            $road_number, $street_number, $building_number, $interest, $hobbies, $height, $weight, $complexion, 
            $biography, $family_background, $user_id // 26 variables
        );

        if ($stmt->execute()) {
            echo "Profile updated successfully!";
        } else {
            echo "Error updating profile.";
        }
        $stmt->close();
    } else {
        echo "Error in query execution.";
    }
}

// Fetch profile details query
$sql = "
SELECT 
    u.Email, u.Profession, u.DOB, u.Gender, u.Religion, u.Ethnicity, u.First_Name, u.Middle_Name, u.Last_Name, 
    pd.Secondary_Education, pd.Higher_Secondary, pd.Undergrade, pd.Post_Grade, 
    pd.road_number, pd.street_number, pd.building_number, pd.phone_number, 
    pd.Marital_Status, pd.Interest, pd.Hobbies, pd.Height, pd.Weight, pd.Complexion, pd.Biography, pd.Family_Background,
    u.Profile_Photo_URL
FROM User u
LEFT JOIN Profile_Details pd ON u.user_id = pd.user_id
WHERE u.user_id = ?
";

// Prepare and execute query
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $user_id); // Bind the user_id parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any user details are found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Assign values from the query to variables, use the default empty if not found
        $email = $row['Email'];
        $profession = $row['Profession'];
        $dob = $row['DOB'];
        $gender = $row['Gender'];
        $religion = $row['Religion'];
        $ethnicity = $row['Ethnicity'];
        $first_name = $row['First_Name'];
        $middle_name = $row['Middle_Name'];
        $last_name = $row['Last_Name'];
        $profile_photo_url = $row['Profile_Photo_URL'];
        
        $secondary_education = $row['Secondary_Education'];
        $higher_secondary = $row['Higher_Secondary'];
        $undergrade = $row['Undergrade'];
        $post_grade = $row['Post_Grade'];
        $road_number = $row['road_number'];
        $street_number = $row['street_number'];
        $building_number = $row['building_number'];
        $phone_number = $row['phone_number'];
        $marital_status = $row['Marital_Status'];
        $interest = $row['Interest'];
        $hobbies = $row['Hobbies'];
        $height = $row['Height'];
        $weight = $row['Weight'];
        $complexion = $row['Complexion'];
        $biography = $row['Biography'];
        $family_background = $row['Family_Background'];
    }
    $stmt->close();
} else {
    echo "Error in query execution.";
    exit();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        /* Styling for the form */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff6f61, #ffe5b4);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .profile-container {
            background-color: #ffffff;
            padding: 20px;
            width: 600px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin: 40px 0;
        }
        input[type="text"], input[type="date"], input[type="email"], input[type="password"], input[type="number"], select, textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input[type="checkbox"] { margin-right: 10px; }
        input:focus, select:focus, textarea:focus { border-color: #ff6f61; outline: none; }
        .submit-btn { width: 100%; padding: 10px; background-color: #ff6f61; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease; }
        .submit-btn:hover { background-color: #ff4f41; }
        h2 { text-align: center; color: #ff6f61; margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        .checkbox-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; margin-bottom: 15px; }
        textarea { resize: vertical; }
        body:before { content: ''; position: absolute; top: -50px; left: -50px; right: -50px; bottom: -50px; background: linear-gradient(135deg, rgba(255, 111, 97, 0.6), rgba(255, 229, 180, 0.6)); z-index: -1; }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Edit Profile</h2>
    <form method="POST" action="my_profile_details.php">
        <!-- Personal Information -->
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required>

        <label for="middle_name">Middle Name:</label>
        <input type="text" name="middle_name" value="<?= htmlspecialchars($middle_name) ?>">

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" value="<?= htmlspecialchars($dob) ?>" required>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male" <?= ($gender == 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= ($gender == 'Female') ? 'selected' : '' ?>>Female</option>
            <option value="Other" <?= ($gender == 'Other') ? 'selected' : '' ?>>Other</option>
        </select>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="<?= htmlspecialchars($phone_number) ?>">

        <!-- Education Details -->
        <h2>Education</h2>
        <label for="secondary_education">Secondary Education:</label>
        <input type="text" name="secondary_education" value="<?= htmlspecialchars($secondary_education) ?>">

        <label for="higher_secondary">Higher Secondary:</label>
        <input type="text" name="higher_secondary" value="<?= htmlspecialchars($higher_secondary) ?>">

        <label for="undergrade">Undergraduate:</label>
        <input type="text" name="undergrade" value="<?= htmlspecialchars($undergrade) ?>">

        <label for="post_grade">Postgraduate:</label>
        <input type="text" name="post_grade" value="<?= htmlspecialchars($post_grade) ?>">

        <!-- Address Information -->
        <h2>Address</h2>
        <label for="road_number">Road Number:</label>
        <input type="text" name="road_number" value="<?= htmlspecialchars($road_number) ?>">

        <label for="street_number">Street Number:</label>
        <input type="text" name="street_number" value="<?= htmlspecialchars($street_number) ?>">

        <label for="building_number">Building Number:</label>
        <input type="text" name="building_number" value="<?= htmlspecialchars($building_number) ?>">

        <!-- Additional Details -->
        <h2>Personal Details</h2>
        <label for="marital_status">Marital Status:</label>
        <select name="marital_status" required>
            <option value="Single" <?= ($marital_status == 'Single') ? 'selected' : '' ?>>Single</option>
            <option value="Married" <?= ($marital_status == 'Married') ? 'selected' : '' ?>>Married</option>
            <option value="Divorced" <?= ($marital_status == 'Divorced') ? 'selected' : '' ?>>Divorced</option>
        </select>

        <label for="complexion">Complexion:</label>
        <input type="text" name="complexion" value="<?= htmlspecialchars($complexion) ?>">

        <label for="height">Height (cm):</label>
        <input type="number" name="height" value="<?= htmlspecialchars($height) ?>" required>

        <label for="weight">Weight (kg):</label>
        <input type="number" name="weight" value="<?= htmlspecialchars($weight) ?>" required>

        <label for="biography">Biography:</label>
        <textarea name="biography"><?= htmlspecialchars($biography) ?></textarea>

        <label for="family_background">Family Background:</label>
        <textarea name="family_background"><?= htmlspecialchars($family_background) ?></textarea>

        <!-- Interests and Hobbies -->
        <h2>Interests</h2>
        <textarea name="interest"><?= htmlspecialchars($interest) ?></textarea>

        <h2>Hobbies</h2>
        <textarea name="hobbies"><?= htmlspecialchars($hobbies) ?></textarea>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">Save Changes</button>
    </form>
</div>

</body>
</html>
