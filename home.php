<?php
session_start(); // Start the session

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Assuming user's first name is stored in session when logged in
$userFirstName = $_SESSION['first_name'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <title>Home - Matrimonial</title>
</head>
<body>
    <header>
      <nav>
        <div class="nav_logo">
          <h1><a href="index.php">Matrimonial</a></h1>
        </div>
        <ul class="nav_link">
          <li><a href="home.php">Home</a></li>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>
    <main>
        <div class="login_box">
            <h1>Welcome, <?php echo htmlspecialchars($userFirstName); ?>!</h1>
            <p>This is your dashboard. From here, you can check your profile, update your details, and view other important information.</p>
            <!-- Additional content can be added here -->
        </div>
    </main>
</body>
</html>