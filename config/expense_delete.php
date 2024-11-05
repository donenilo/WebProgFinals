<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['User_id'])) {
    echo "Please login first.";
    header('Location: ../index.php');
    exit();
}

$user_id = $_SESSION['User_id'];

if (isset($_GET['expense_id'])) {
    $expense_id = $_GET['expense_id'];

    // Prepare the delete statement
    $sql = "DELETE FROM Expense WHERE expense_id = ? AND User_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $expense_id, $_SESSION['User_id']);

    if ($stmt->execute()) {
        echo "Expense record deleted successfully.";
    } else {
        echo "Error deleting record: {$conn->error}";
    }

    $stmt->close();
    $conn->close();

    header('Location: ../expense.php');
    exit();
} else {
    echo "Invalid request method.";
}