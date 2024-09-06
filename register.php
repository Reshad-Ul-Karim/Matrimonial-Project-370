<?php
require_once("DBconnect.php");
// This project is by Reshad
// Function to generate a random 10-character alphanumeric user ID
function generateUserId($length = 10) {
    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
//The function to generate user id is working


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']); // Format: YYYY-MM-DD
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $religion = mysqli_real_escape_string($conn, $_POST['religion']);
    $ethnicity = mysqli_real_escape_string($conn, $_POST['ethnicity']);
    $profession = mysqli_real_escape_string($conn, $_POST['profession']);
    $nid = mysqli_real_escape_string($conn, $_POST['nid']);
    $registrationDate = date('Y-m-d');  // Assuming registration date is today

    // Check if email already exists
    $checkEmailQuery = "SELECT Email FROM User WHERE Email = '$email'";
    $result = mysqli_query($conn, $checkEmailQuery);
    if (mysqli_num_rows($result) > 0) {
        echo "Email already exists!";
    } else {
        // Generate custom user_id (10-character alphanumeric)
        $user_id = generateUserId();

        // Password hashing for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user with the generated user_id
        $sql = "INSERT INTO User (user_id, Email, Password, First_Name, Last_Name, DOB, Gender, Religion, Ethnicity, Profession, NID, Registration_Date) 
                VALUES ('$user_id', '$email', '$hashed_password', '$firstName', '$lastName', '$dob', '$gender', '$religion', '$ethnicity', '$profession', '$nid', '$registrationDate')";
        if (mysqli_query($conn, $sql)) {
            echo "Registration successful!";
            header("Location: index.php"); // Redirect to login page after successful registration
            exit(); // Ensure no further script execution after redirection
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Matrimonial Hub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="email"], input[type="password"], input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #f76c6c;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register to Matrimonial Hub</h2>
        <form action="register.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
            
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
            
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>
            
            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            
            <label for="religion">Religion:</label>
            <select id="religion" name="religion">
                <option value="Christian">Christian</option>
                <option value="Muslim">Muslim</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddhist">Buddhist</option>
                <option value="Jewish">Jewish</option>
                <option value="Atheist">Atheist</option>
                <option value="Other">Other</option>
            </select>
            
            <label for="ethnicity">Ethnicity:</label>
            <input type="text" id="ethnicity" name="ethnicity" placeholder="Ethnicity" required>
            
            <label for="profession">Profession:</label>
            <input type="text" id="profession" name="profession" placeholder="Profession" required>
            
            <label for="nid">National ID (NID):</label>
            <input type="text" id="nid" name="nid" placeholder="National ID (NID)" required>
            
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
