<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    // echo "Please login first.";
    // header('Location: index.php');
    // exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Tracker Income</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <h2>Finance Tracker</h2>
            <ul>
                <li><a href="dashboard.php">📊 Dashboard</a></li>
                <li><a href="income.php">✏️ Tracking</a></li>
                <li><a href="income.php">📥 Income</a></li>
                <li><a href="expense.php">💸 Expense</a></li>
                <li class="active"><a href="goals.php">🎯 Goals</a></li> 
            </ul>
            <div class="sidebar-footer">
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Goals</h1>
            <!-- Content specific to the income page will go here -->
        </div>
    </div>
</body>
</html>