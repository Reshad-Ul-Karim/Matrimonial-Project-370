<?php 
  session_start();
  include_once "DBconnect.php";

  // Check if user is logged in, otherwise redirect to login
  if(!isset($_SESSION['user_id'])){
    header("location: login.php");
    exit();
  }

  // Check if user_id is provided, otherwise redirect to users page
  if(!isset($_GET['user_id']) || empty($_GET['user_id'])){
    header("location: users.php");
    exit();
  }

  // Sanitize the incoming user_id
  $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
  
  // Prepare SQL query to get user details
  $sql = mysqli_prepare($conn, "SELECT * FROM User WHERE user_id = ?");
  mysqli_stmt_bind_param($sql, "s", $user_id);
  mysqli_stmt_execute($sql);
  $result = mysqli_stmt_get_result($sql);

  // Check if the user exists
  if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
  } else {
    header("location: users.php");
    exit();
  }
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <a href="accepted_requests.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        
        <!-- Display profile photo or default image -->
        <img src="uploads/<?php echo !empty($row['Profile_Photo_URL']) ? htmlspecialchars($row['Profile_Photo_URL']) : 'default-profile.png'; ?>" alt="Profile Picture">
        
        <div class="details">
          <span><?php echo htmlspecialchars($row['First_Name']) . " " . htmlspecialchars($row['Last_Name']); ?></span>
          <p><?php echo htmlspecialchars($row['Account_Status']); ?></p>
        </div>
      </header>
      <div class="chat-box">
        <!-- Messages will be loaded here by JavaScript -->
      </div>
      <form action="#" class="typing-area">
        <!-- Hidden input for the user id -->
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo htmlspecialchars($user_id); ?>" hidden>
        <!-- Message input -->
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <!-- Send button -->
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <!-- Include JavaScript to handle chat functionality -->
  <script src="javascript/chat.js"></script>
</body>
</html>
