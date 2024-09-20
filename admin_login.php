<?php
ob_start(); // Turn on output buffering
session_start(); // Start the session

require_once("DBconnect.php");

// Check if the user is already logged in, redirect to admin.php if true
if (isset($_SESSION['user_id'])) {
    header('Location: admin_dashboard.php');
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Select query to check the username and password
        $sql = "SELECT Admin_id, Username, Password FROM admin WHERE Username = '$email' AND Password = '$password'";
        $result = mysqli_query($conn, $sql);

        // Check if the query returns any rows
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Set session variables for the logged-in user
            $_SESSION['user_id'] = $row['Admin_id'];
            $_SESSION['email'] = $email;

            // Redirect to the admin dashboard
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $error = 'Invalid username or password!';
        }
    } else {
        $error = 'Please fill in both username and password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Product+Sans&display=swap');
        
        body {
            font-family: 'Product Sans', sans-serif;
            background-color: #ffe4e1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h1 {
            color: #f76c6c;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #f76c6c;
            border-radius: 5px;
        }

        button {
            background-color: #f76c6c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #ff9999;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h1>Admin Login</h1>

        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="admin_login.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
