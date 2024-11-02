<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['User_id'])) {
    echo "Please login first.";
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['User_id'];
$category_type = "Expense";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expense_category = isset($_POST['expense_category']) ? $_POST['expense_category'] : null;

    if ($expense_category) {
        $sql = "INSERT INTO categories (User_id, category_name, category_type) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $expense_category, $category_type);
        
        if($stmt->execute()){
            header("Location: ../expense.php");
        }
        else{
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Missing required fields.";
    }
}
?>