<?php 
session_start();
if(isset($_SESSION['user_id'])){
    include_once "DBconnect.php";
    $outgoing_id = $_SESSION['user_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);

    $output = "";

    // Fetch messages between outgoing_id and incoming_id
    $stmt = $conn->prepare("SELECT chat_messages.*, chat_users.img 
                            FROM chat_messages 
                            LEFT JOIN chat_users ON chat_users.user_id = chat_messages.outgoing_msg_id
                            WHERE (incoming_msg_id = ? AND outgoing_msg_id = ?)
                            OR (incoming_msg_id = ? AND outgoing_msg_id = ?) 
                            ORDER BY msg_id");
    $stmt->bind_param("ssss", $outgoing_id, $incoming_id, $incoming_id, $outgoing_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            // Decrypt the message
            $encryption_key = 'your-secret-encryption-key'; // Replace with your actual key
            $decrypted_message = openssl_decrypt($row['msg'], 'AES-128-ECB', $encryption_key);
            
            if($row['outgoing_msg_id'] === $outgoing_id){
                // Outgoing message
                $output .= '<div class="chat outgoing">
                            <div class="details">
                                <p>'. htmlspecialchars($decrypted_message) .'</p>
                            </div>
                            </div>';
            } else {
                // Incoming message with user image
                $output .= '<div class="chat incoming">
                <div class="details">
                    <p>'. htmlspecialchars($decrypted_message) .'</p>
                </div>
              </div>';
  
            }
        }

        // Mark messages as read where incoming_msg_id = $outgoing_id and outgoing_msg_id = $incoming_id
        $update_stmt = $conn->prepare("UPDATE chat_messages SET read_status = 'read' 
                                       WHERE incoming_msg_id = ? AND outgoing_msg_id = ? AND read_status = 'unread'");
        $update_stmt->bind_param("ss", $outgoing_id, $incoming_id);
        $update_stmt->execute();
    } else {
        $output .= '<div class="text">No messages are available. Once you send a message, they will appear here.</div>';
    }

    echo $output;
} else {
    header("location: login.php");
}
?>
