<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['User_id'])) {
    echo "Please login first.";
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['User_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expense_date = isset($_POST['expense_date']) ? $_POST['expense_date'] : null;
    $expense_description = isset($_POST['expense_description']) ? $_POST['expense_description'] : null;
    $expense_amount = isset($_POST['expense_amount']) ? $_POST['expense_amount'] : null;
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;
    $user_id = isset($_SESSION['User_id']) ? $_SESSION['User_id'] : null;

    if ($expense_date && $expense_description && $expense_amount && $category_id && $user_id) {
        $query = "INSERT INTO Expense (User_id, expense_date, expense_description, expense_amount, category_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issdi", $user_id, $expense_date, $expense_description, $expense_amount, $category_id);

        if ($stmt->execute()) {
            header("Location: ../expense.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    else {
        echo "Error: Missing required fields.";
    }
}
?>