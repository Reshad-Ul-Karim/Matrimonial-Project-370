<?php
    session_start();
    include_once "DBconnect.php";
    $outgoing_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM chat_users WHERE NOT user_id = '{$outgoing_id}'";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>