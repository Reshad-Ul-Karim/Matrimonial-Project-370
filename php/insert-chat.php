<?php 
session_start();

if (isset($_SESSION['user_id'])) {
    include_once "config.php";
    $outgoing_id = $_SESSION['user_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    if (!empty($message)) {
        // Check if both user IDs exist in the chat_users table
        $checkUserStmt = $conn->prepare("SELECT COUNT(*) FROM chat_users WHERE user_id = ? OR user_id = ?");
        $checkUserStmt->bind_param("ss", $incoming_id, $outgoing_id);  // 'ss' for strings
        $checkUserStmt->execute();
        $checkUserStmt->bind_result($userCount);
        $checkUserStmt->fetch();
        $checkUserStmt->close();

        if ($userCount < 2) {
            echo "One or both user IDs do not exist.";
            exit();
        }

        // Encrypt the message
        $encryption_key = 'your-secret-encryption-key';  // Make sure this key is consistent across all files
        $encrypted_message = openssl_encrypt($message, 'AES-128-ECB', $encryption_key);
        
        if ($encrypted_message === false) {
            echo "Message encryption failed.";
            exit();
        }

        // Insert the encrypted chat message
        $stmt = $conn->prepare("INSERT INTO chat_messages (incoming_msg_id, outgoing_msg_id, msg) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        
        $stmt->bind_param("sss", $incoming_id, $outgoing_id, $encrypted_message);  // 'sss' for strings
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo "Message sent successfully!";
        } else {
            echo "Message failed to send. Error: " . htmlspecialchars($stmt->error);
        }
        
        $stmt->close();
    } else {
        echo "Message is empty.";
    }
} else {
    header("location: login.php");
}
?>
