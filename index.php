<?php
ob_start(); // Turn on output buffering
session_start(); // Start the session

require_once("DBconnect.php");

// Check if the user is already logged in, redirect to home.php if true
if (isset($_SESSION['user_id'])) {
  header('Location: dashboard.php');
  exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (!empty($email) && !empty($password)) {
    // Check for admin credentials
    if ($email === "admin@gmail.com" && $password === "biyaconfirm") {
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        exit;
    }
      $sql = "SELECT user_id, Password FROM User WHERE Email = '$email'";
      $result = mysqli_query($conn, $sql);
      if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          if (password_verify($password, $row['Password'])) {
              $_SESSION['user_id'] = $row['user_id'];
              $_SESSION['email'] = $email;
              header("Location: dashboard.php");
              exit;
          } else {
              $error = 'Invalid password!';
          }
      } else {
          $error = 'No user found with that email address!';
      }
  } else {
      $error = 'Please fill in both email and password!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Matrimonial Hub</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Product+Sans&display=swap');
        
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Product Sans', Arial, sans-serif;
        }

        /* Video Styling */
        #bg-video {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            background-size: cover;
        }

        .container {
            max-width: 500px;
            margin: 100px auto;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.9); /* Transparent white background */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 2;
            position: relative;
        }

        h2 {
            font-size: 24px;
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
            font-size: 18px;
        }

        input[type="email"], input[type="password"] {
            width: calc(100% - 20px);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #c2155b;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #ad1457;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        p {
            text-align: center;
        }

        a {
            color: #c2155b;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Background Video -->
    <video autoplay muted loop id="bg-video">
        <source src="weddingbackground1.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="container">
        <h2>Login to Matrimonial Hub</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="index.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" class="btn">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
