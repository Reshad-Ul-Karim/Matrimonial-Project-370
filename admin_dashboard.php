<?php
session_start();
require_once("DBconnect.php"); // Your DB connection file

// Redirect to login page if the admin is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: admin_login.php');
    exit;
}

$error = '';
$success = '';
$search = '';

// Check if the search bar is used
if (isset($_POST['search_user'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $query = "SELECT user_id, First_Name, Last_Name, Religion, DOB, Ethnicity, Account_Status, Profile_Photo_URL 
              FROM User 
              WHERE First_Name LIKE '%$search%' OR Last_Name LIKE '%$search%'";
} else {
    // Fetch Users from Database
    $query = "SELECT user_id, First_Name, Last_Name, Religion, DOB, Ethnicity, Account_Status, Profile_Photo_URL 
              FROM User";
}

$result = mysqli_query($conn, $query);

// Change Account Status
if (isset($_POST['change_status'])) {
    $user_id = $_POST['user_id'];
    $new_status = $_POST['new_status'];

    $query = "UPDATE User SET Account_Status = '$new_status' WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $query)) {
        $success = "Status changed successfully.";
        header("Refresh:0"); // Refresh the page to immediately reflect changes
    } else {
        $error = "Error changing status: " . mysqli_error($conn);
    }
}

// Delete User Profile
if (isset($_POST['delete_profile'])) {
    $user_id = $_POST['user_id'];

    $query = "DELETE FROM User WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $query)) {
        $success = "Profile deleted successfully.";
        header("Refresh:0"); // Refresh the page to immediately reflect changes
    } else {
        $error = "Error deleting profile: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Product+Sans&display=swap');

        body {
            font-family: 'Product Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffe4e1;
        }

        header {
            background: linear-gradient(90deg, #f7886cd6 0%, rgba(255, 42, 0, 0.784) 100%);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        header h1 {
            margin: 0;
        }

        .admin-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #f76c6c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f76c6c;
        }

        th {
            background-color: #f76c6c;
            color: white;
        }

        .profile-card {
            display: flex;
            align-items: center;
        }

        .profile-card img {
            margin-right: 15px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        button {
            background-color: #f76c6c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
        }

        button:hover {
            background-color: #ff9999;
        }

        .success {
            color: green;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #f76c6c;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Style for search bar */
        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container input {
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #f76c6c;
        }

        .search-container button {
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #f76c6c;
            color: white;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- Admin Dashboard Header -->
    <header>
        <h1>Admin Dashboard</h1>
        <form action="logout.php" method="post">
            <button type="submit">Log Out</button>
        </form>
    </header>

    <!-- Admin Container for Registered Profiles -->
    <div class="admin-container">
        <h2>Registered Profiles</h2>

        <!-- Success or Error Messages -->
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php elseif ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Search Bar -->
        <div class="search-container">
            <form action="admin_dashboard.php" method="post">
                <input type="text" name="search" placeholder="Search by name..." value="<?php echo $search; ?>">
                <button type="submit" name="search_user">Search</button>
            </form>
        </div>

        <!-- Profile Table -->
        <table>
            <thead>
                <tr>
                    <th>Profile Photo</th>
                    <th>Name</th>
                    <th>Religion</th>
                    <th>Ethnicity</th>
                    <th>Age</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): 
                    $age = date_diff(date_create($row['DOB']), date_create('now'))->y;
                ?>
                    <tr>
                        <!-- Profile Photo -->
                        <td class="profile-card">
                            <img src="<?php echo $row['Profile_Photo_URL']; ?>" alt="Profile Photo">
                        </td>
                        <td><?php echo $row['First_Name'] . ' ' . $row['Last_Name']; ?></td>
                        <td><?php echo $row['Religion']; ?></td>
                        <td><?php echo $row['Ethnicity']; ?></td>
                        <td><?php echo $age; ?></td>
                        <td><?php echo $row['Account_Status']; ?></td>
                        <td>
                            <!-- Change Account Status Form -->
                            <form action="admin_dashboard.php" method="post" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                <select name="new_status">
                                    <option value="Active" <?php echo ($row['Account_Status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="Inactive" <?php echo ($row['Account_Status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                                <button type="submit" name="change_status">Change Status</button>
                            </form>

                            <!-- Delete Profile Form -->
                            <form action="admin_dashboard.php" method="post" style="display:inline;" onsubmit="return confirmDelete();">
                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                <button type="submit" name="delete_profile">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Matrimonial Hub. All Rights Reserved.</p>
    </footer>



    <script>
        function confirmDelete() {
            console.log('Delete button clicked');
            return confirm('Are you sure you want to delete this profile?');
        }
    </script>

</body>

</html>
