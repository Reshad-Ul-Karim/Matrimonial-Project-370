<?php
session_start();
include 'DBconnect.php'; // Ensure your database connection file is properly set up

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Query to get message requests and sender details
$sql = "SELECT r.request_id, r.sender_id, r.request_time, u.First_Name, u.Last_Name, u.Profile_Photo_URL
        FROM request r
        JOIN User u ON r.sender_id = u.user_id
        WHERE r.receiver_id = ? AND r.request_status = 'Pending'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 20px;
        }
        .profile {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #fff;
        }
        .profile img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-details {
            display: inline-block;
            vertical-align: top;
            margin-left: 10px;
        }
        button {
            padding: 5px 15px;
            margin-left: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .accept {
            background-color: #4CAF50;
            color: white;
        }
        .reject {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Message Requests</h1>
    <div>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                
                    <div class="profile-photo">
                       <img src="uploads/<?= htmlspecialchars($profile_photo_url) ?: 'default-profile.png'; ?>" alt="Profile Picture">
                    </div>
                    <div class="profile-details">
                        <p><?= htmlspecialchars($row['First_Name'] . ' ' . $row['Last_Name']) ?></p>
                        <p>Request sent on: <?= date('M d, Y H:i', strtotime($row['request_time'])) ?></p>
                        <form action="process_request.php" method="post">
                            <input type="hidden" name="request_id" value="<?= $row['request_id'] ?>">
                            <button type="submit" name="action" value="accept" class="accept">Accept</button>
                            <button type="submit" name="action" value="reject" class="reject">Reject</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No message requests found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
