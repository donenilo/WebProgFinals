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
    <div class="sidebar">
        <h2>Finance Tracker</h2>
        <ul>
            <li><a href="dashboard.php">📊 Dashboard</a></li>
            <li><a href="income.php">✏️ Tracking</a></li>
            <li><a href="income.php">📥 Income</a></li>
            <li><a href="expense.php">💸 Expense</a></li>
            <li><a href="#">🎯 Goals</a></li> 
        </ul>
        <div class="sidebar-footer">
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
  </div>

    <div class="main-content-profile">
        <div class="profile-header">
            <div class="profile-info">
                <img src="profile-avatar.png" alt="Profile Avatar" class="avatar">
                <div class="user-details">
                    <h2 id="usernameDisplay">Username</h2>
                    <p id="emailDisplay">useremail@account.com</p>
                </div>
            </div>
        </div>

        <div class="profile-settings">
            <h3>Change your password</h3>
            <form id="changePasswordForm">
                <input type="password" name="current_password" placeholder="Enter your current password" required>
                <input type="password" name="new_password" placeholder="Enter your new password" required>
                <input type="password" name="confirm_password" placeholder="Confirm your new password" required>
                <button type="submit">Update Password</button>
            </form>

            <button class="delete-account-btn" id="deleteAccountBtn">Delete Account</button>
        </div>
    </div>
</body>
</html>