<?php
session_start();
include('DBconnect.php'); // Make sure this points to the correct database

if (isset($_POST['send_request'])) {
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $request_id = bin2hex(random_bytes(10)); // Generate a random request ID
    $request_status = 'Pending';
    $request_time = date('Y-m-d H:i:s'); // Current time in MySQL datetime format

    $sql = "INSERT INTO request (request_id, sender_id, receiver_id, request_status, request_time) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssss", $request_id, $sender_id, $receiver_id, $request_status, $request_time);
        $stmt->execute();
        echo "<script>alert('Request sent successfully!');</script>";
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement.');</script>";
    }
    $conn->close();
    header("Location: submit_preferences.php"); // Redirect to a confirmation page or back to profiles
    exit();
}
?>
