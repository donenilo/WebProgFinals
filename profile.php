<?php
include 'config/db_connection.php';
session_start();

if (!isset($_SESSION['User_id'])) {
    echo "Please login first.";
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['User_id'];

$query = "SELECT * FROM users WHERE user_id = $user_id";

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <script src="scripts/scripts.js" defer></script>
</head>
<body>
<div class="container">
    <nav class="sidebar">
        <h2>Finance Tracker</h2>
        <ul>
            <li><a href="dashboard.php"><img src="assets/chartbar.png"> Dashboard</a></li>
            <li><a href="income.php"><img src="assets/notepencil.png"> Tracking</a></li>
            <li><a href="income.php"><img src="assets/creditcard-add.png"> Income</a></li>
            <li><a href="expense.php"><img src="assets/dollar signs.png"> Expense</a></li>
            <li><a href="savings.php"><img src="assets/savings.png"> Savings</a></li> 
        </ul>
        <div class="sidebar-footer">
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>


    <!-- Main Content -->
     <div class = "holder">

        <div class="profile-section">
                <div class = "profile_icon">
                    <img class="profile_icon" src="assets/profile_icon.png" alt="User Icon">
                </div>
                <div class="profile-info">
                    <p class="username">Username: <?php echo $username; ?></p> <br>
                    <p class="email">Email: <?php echo $email; ?></p>
                </div>                   
        </div>


        <div class = "form-section">
            <div class="form-left">
                <h3>Change Your Password</h3>
            </div>

            <div class="form-right">
            <form action="update_password.php" method="POST">

                    <div class="form-group">
                        <label for="current_password">Current Password:</label>
                        <div class= "password-wrapper">
                        <input type="password" id="current_password" placeholder="Enter your current password" name="current_password" required>
                        <button type="button" class="reveal-btn" onclick="togglePassword('current_password')">
                        <img src="assets/eye.png" alt="Show/Hide" class="reveal-icon">
                        </button>
                        </div>                       
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password:</label>
                        <div class= "password-wrapper">
                        <input type="password" id="new_password" placeholder="Enter your new password" name="new_password" required>
                        <button type="button" class="reveal-btn" onclick="togglePassword('new_password')">
                        <img src="assets/eye.png" alt="Show/Hide" class="reveal-icon">
                        </button>
                        </div>                       
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password:</label>
                        <div class= "password-wrapper">
                        <input type="password" id="confirm_password" placeholder="Confirm your new password" name="confirm_password" required>
                        <button type="button" class="reveal-btn" onclick="togglePassword('confirm_password')">
                        <img src="assets/eye.png" alt="Show/Hide" class="reveal-icon">
                        </button>
                        </div>                      
                    </div>

                    <button class="update-btn" type="submit">Update Password</button>
            </form>
            </div> 
        </div>

    </div>
    

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">

    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
    }

</script>
</body>
</html>