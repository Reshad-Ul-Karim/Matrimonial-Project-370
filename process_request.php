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

    if ($action == 'accept') {
        $status = 'Accepted';

        // Get sender and receiver IDs for the accepted request
        $query = "SELECT sender_id, receiver_id FROM request WHERE request_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $request_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $sender_id = $row['sender_id'];
            $receiver_id = $row['receiver_id'];

            // Now that the request is accepted, the sender and receiver can chat.
            // No need for additional tables. The chat interface should be updated based on the 'Accepted' status of this request.
        }
        $stmt->close();

    } elseif ($action == 'reject') {
        $status = 'Rejected';
    } else {
        // Redirect or error message if action is not valid
        header('Location: message_requests.php');
        exit();
    }

    // Update the request status based on the action
    $sql = "UPDATE request SET request_status = ? WHERE request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $status, $request_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Request $action successfully.";
    } else {
        echo "Error updating request.";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the message requests page
    header('Location: message_requests.php');
    exit();
}
?>
