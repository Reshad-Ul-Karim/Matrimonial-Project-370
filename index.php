<?php
ob_start(); // Turn on output buffering
session_start(); // Start the session

require_once("DBconnect.php");

// Check if the user is already logged in, redirect to home.php if true
if (isset($_SESSION['user_id'])) {
  header('Location: home.php');
  exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (!empty($email) && !empty($password)) {
      $sql = "SELECT user_id, Password FROM User WHERE Email = '$email'";
      $result = mysqli_query($conn, $sql);
      if ($result && mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          if (password_verify($password, $row['Password'])) {
              $_SESSION['user_id'] = $row['user_id'];
              $_SESSION['email'] = $email;
              header("Location: home.php");
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
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button[type="submit"] {
            background-color: #f76c6c;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
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
        <?php if ($error): ?>
              <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>