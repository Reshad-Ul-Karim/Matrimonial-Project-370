<?php
// Assuming the $query is correctly initialized and $conn is your database connection

while ($row = mysqli_fetch_assoc($query)) {
    // Use prepared statements to ensure data integrity and security
    $stmt = $conn->prepare("SELECT * FROM chat_messages WHERE (incoming_msg_id = ? OR outgoing_msg_id = ?) AND (outgoing_msg_id = ? OR incoming_msg_id = ?) ORDER BY msg_id DESC LIMIT 1");
    $stmt->bind_param("iiii", $row['user_id'], $row['user_id'], $outgoing_id, $outgoing_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row2 = $result->fetch_assoc();
    } else {
        // Return an error if the user_id is invalid
        echo "No Chats yet!";
    }
    
    $result = $result->num_rows > 0 ? $row2['msg'] : "No message available";
    $msg = strlen($result) > 28 ? substr($result, 0, 28) . '...' : $result;
    
    if (isset($row2['outgoing_msg_id'])) {
        $you = $outgoing_id == $row2['outgoing_msg_id'] ? "You: " : "";
    } else {
        $you = "";
    }
    
    $offline = $row['status'] == "Offline now" ? "offline" : "";
    $hid_me = $outgoing_id == $row['user_id'] ? "hide" : "";
    
    $output .= '<a href="chat.php?user_id='. $row['user_id'] .'">
                    <div class="content">
                    <img src="uploads/459164878_1037422197838809_7961970929058206066_n.jpg'. $row['img'] .'" alt="">
                    <div class="details">
                        <span>'. $row['fname']. " " . $row['lname'] .'</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';
}
?>
