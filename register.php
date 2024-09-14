<?php
require_once("DBconnect.php");
function generateUserId($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
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
        // Generate a unique user_id
        $user_id = generateUserId();

        // Password hashing for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user with the unique user_id
        $sql = "INSERT INTO User (user_ID, Email, Password, First_Name, Last_Name, DOB, Gender, Religion, Ethnicity, Profession, NID, Registration_Date) VALUES ('$user_id', '$email', '$hashed_password', '$firstName', '$lastName', '$dob', '$gender', '$religion', '$ethnicity', '$profession', '$nid', '$registrationDate')";
        if (mysqli_query($conn, $sql)) {
            echo "Registration successful!";
            header("Location: index.php"); // Redirect to login page after successful registration
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
    <title>Create Profile</title>
    <style>
        /* Gradient background */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff6f61, #ffe5b4);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Form container */
        .profile-container {
            background-color: #ffffff;
            padding: 20px;
            width: 400px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.6s ease-out; /* Slide-in animation */
        }

        /* Input fields styling */
        input[type="text"], input[type="date"], input[type="email"], input[type="password"], select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #ff6f61; /* Highlight border on focus */
            outline: none;
        }

        /* Submit button styling */
        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #ff6f61;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #ff4f41; /* Darker color on hover */
        }

        /* Heading styling */
        h2 {
            text-align: center;
            color: #ff6f61;
            margin-bottom: 20px;
        }

        /* Keyframe animation for form container */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animation for input fields */
        .profile-container input, .profile-container select {
            animation: fadeIn 1s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Subtle background animation */
        body:before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            right: -50px;
            bottom: -50px;
            background: linear-gradient(135deg, rgba(255, 111, 97, 0.6), rgba(255, 229, 180, 0.6));
            z-index: -1;
            animation: animateBg 5s ease-in-out infinite;
        }

        @keyframes animateBg {
            0% {
                background-position: 0 0;
            }
            50% {
                background-position: 100% 100%;
            }
            100% {
                background-position: 0 0;
            }
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Create Your Profile</h2>
    <form method="POST" action="">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" required>

        <label for="middle_name">Middle Name</label>
        <input type="text" name="middle_name" id="middle_name">

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" id="dob" required>

        <label for="gender">Gender</label>
        <select name="gender" id="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label for="profession">Profession</label>
        <input type="text" name="profession" id="profession" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label for="city">City</label>
        <input type="text" name="city" id="city" required>

        <button type="submit" class="submit-btn">Create Profile</button>
        </br>
        <button type="button" class="submit-btn" onclick="window.location='index.php';">Already have an account?</button>

</div>
    </form>
</div>

</body>
</html>
