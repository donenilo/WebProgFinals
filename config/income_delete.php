<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['User_id'])) {
    echo "Please login first.";
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['User_id'];

if (isset($_GET['income_id'])) {
    $income_id = $_GET['income_id'];

    // Prepare the delete statement
    $sql = "DELETE FROM Income WHERE income_id = ? AND User_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $income_id, $_SESSION['User_id']);

    if ($stmt->execute()) {
        echo "Income record deleted successfully.";
    } else {
        echo "Error deleting record: {$conn->error}";
    }

    $stmt->close();
    $conn->close();

    header('Location: ../income.php');
    exit();
} else {
    echo "Invalid request method.";
}