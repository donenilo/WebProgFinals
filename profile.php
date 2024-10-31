<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    // echo "Please login first.";
    // header('Location: index.php');
    // exit();
}

// $user_id = $_SESSION['user_id'];
$user_id = 1;

$query = "SELECT * FROM users WHERE user_id = 1";

$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$username = $user['Username'];
$email = $user['Email'];

if(!$result) {
    die("query failed".mysqli_error($conn));
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Finance Tracker</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="scripts/scripts.js" defer></script>
</head>
<body>
<div class="container">
    <nav class="sidebar">
        <h2>Finance Tracker</h2>
        <ul>
            <li><a href="dashboard.php">📊 Dashboard</a></li>
            <li><a href="income.php">✏️ Tracking</a></li>
            <li class="active"><a href="income.php">📥 Income</a></li>
            <li><a href="expense.php">💸 Expense</a></li>
            <li><a href="goals.php">🎯 Goals</a></li> 
        </ul>
        <div class="sidebar-footer">
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>


    <!-- Main Content -->
    <div class="main-content">
        <h1>Income</h1>
        <div class="profile">
            <h2>Profile</h2>
            <div class="profile-info">
                <p><strong>Username:</strong> <?php echo $username; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
            </div>
        <h3>Update Password</h3>
        <form action="update_password.php" method="POST">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Update Password</button>
        </form>
    </div>
</div>

</body>
</html>