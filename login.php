<?php
session_start();
include_once "DBconnect.php"; // Database connection

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("location: users.php");
    exit();
}

// Check if the user_id is passed from the dashboard
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Query the database to fetch the user's details using the user_id
    $sql = mysqli_query($conn, "SELECT * FROM user WHERE user_id = {$user_id}");

    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);

        // Auto-login: Set the session variables
        $_SESSION['user_id'] = $row['uuser_id'];
        $_SESSION['email'] = $row['email']; // Store more session info if needed

        // Return a success message
        echo "success";
    } else {
        // Return an error if the user_id is invalid
        echo "Invalid user!";
    }
} else {
    echo "No user_id provided!";
}
?>
