<?php  
session_start();
include_once "DBconnect.php";

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit();
}

// Use prepared statement to fetch user details safely
$user_id = $_SESSION['user_id']; // Assume user_id is sanitized at the time of session creation
$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
        
        <img src="uploads/<?php echo htmlspecialchars($row['Profile_Photo_URL']) ?: 'default-profile.png'; ?>" alt="Profile Picture"><!-- NEED TO CHANGE ACCORDINGLY -->
          <div class="details">
            <span><?php echo htmlspecialchars($row['First_Name']) . " " . htmlspecialchars($row['Last_Name']); ?></span>
            <p><?php echo htmlspecialchars($row['Account_Status']); ?></p>
          </div>
        </div>
      </header>
      <div class="search">
        <span class="text">Select a user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
        <!-- User list will be populated here -->
      </div>
    </section>
  </div>

  <script src="javascript/users.js"></script>
</body>
</html>


