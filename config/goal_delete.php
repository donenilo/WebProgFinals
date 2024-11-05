<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['User_id'])) {
    echo "Please login first.";
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['User_id'];

if (isset($_GET['goal_id'])) {
    $goal_id = $_GET['goal_id'];

    // Prepare the delete statement
    $sql = "DELETE FROM Goals WHERE goal_id = ? AND User_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $goal_id, $_SESSION['User_id']);

    if ($stmt->execute()) {
        echo "Goal record deleted successfully.";
    } else {
        echo "Error deleting record: {$conn->error}";
    }

    $stmt->close();
    $conn->close();

    header('Location: ../goals.php');
    exit();
} else {
    echo "Invalid request method.";
}