<?php
session_start();
include 'DBconnect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['request_id'], $_POST['action'])) {
    $request_id = $_POST['request_id'];
    $action = $_POST['action']; // 'accept' or 'reject'
    $status = ($action == 'accept') ? 'Accepted' : 'Rejected';

    // Update the request status
    $sql = "UPDATE request SET request_status = ? WHERE request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $request_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0 && $action == 'accept') {
        // Fetch the sender_id and receiver_id from the request
        $query = "SELECT sender_id, receiver_id FROM request WHERE request_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $sender_id = $row['sender_id'];
            $receiver_id = $row['receiver_id'];

            // Add both users to chat_users if not already present
            $users = [$sender_id, $receiver_id];
            foreach ($users as $user_id) {
                $insertIfNotExists = "INSERT INTO chat_users (user_id)
                                      SELECT * FROM (SELECT ?) AS tmp
                                      WHERE NOT EXISTS (
                                          SELECT user_id FROM chat_users WHERE user_id = ?
                                      ) LIMIT 1;";
                $insertStmt = $conn->prepare($insertIfNotExists);
                $insertStmt->bind_param("ss", $user_id, $user_id);
                $insertStmt->execute();
            }
        }
    }
    $stmt->close();
    $conn->close();

    // Redirect back to the message requests page
    header('Location: message_requests.php');
    exit();
}
?>
