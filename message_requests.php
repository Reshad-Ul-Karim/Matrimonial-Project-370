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
$stmt->bind_param("s", $user_id);
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
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #444;
            font-size: 36px;
            margin-bottom: 30px;
        }
        .header-right {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 10px;
        }
        .header-right a {
            background-color: #f76c6c;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 50px;
        }
        .header-right a:hover {
            background-color: #ff9999;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .profile {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fafafa;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }
        .profile img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }
        .profile-details {
            flex-grow: 1;
        }
        .profile-details p {
            margin: 5px 0;
            font-size: 16px;
        }
        .profile-details p:first-child {
            font-weight: bold;
            font-size: 18px;
        }
        button {
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
        }
        .accept {
            background-color: #28a745;
            color: white;
            transition: background-color 0.3s ease;
        }
        .accept:hover {
            background-color: #218838;
        }
        .reject {
            background-color: #dc3545;
            color: white;
            transition: background-color 0.3s ease;
        }
        .reject:hover {
            background-color: #c82333;
        }
        .no-requests {
            text-align: center;
            font-size: 18px;
            padding: 50px;
            color: #666;
        }
    </style>
</head>
<body>

    <!-- Go to Dashboard button -->
    <div class="header-right">
        <a href="dashboard.php">Go to Dashboard</a>
    </div>

    <h1>Message Requests</h1>

    <div class="container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="profile">
                    <img src="uploads/<?= htmlspecialchars($row['Profile_Photo_URL']) ?: 'default-profile.png'; ?>" alt="Profile Picture">
                    <div class="profile-details">
                        <p><?= htmlspecialchars($row['First_Name'] . ' ' . $row['Last_Name']) ?></p>
                        <p>Request sent on: <?= date('M d, Y H:i', strtotime($row['request_time'])) ?></p>
                    </div>
                    <form action="process_request.php" method="post" style="display: flex;">
                        <input type="hidden" name="request_id" value="<?= $row['request_id'] ?>">
                        <button type="submit" name="action" value="accept" class="accept">Accept</button>
                        <button type="submit" name="action" value="reject" class="reject">Reject</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-requests">No message requests found.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
