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
    $category_name = $_POST['category_name'];
    $goal_amount = $_POST['goal_amount'];
    $target_date = $_POST['target_date'];
    $user_id = $_SESSION['User_id'];
    $category_type = "Savings"; 

    // Start transaction
    $conn->begin_transaction();

    if (!isset($category_name) || !isset($goal_amount) || !isset($target_date)) {
        echo "Error: Missing required fields.";
        exit();
    }

    else{
    try {
        $sql = "INSERT INTO Categories (User_id, category_name, category_type) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $category_name, $category_type);
        $stmt->execute();
        
        $new_category_id = $stmt->insert_id;
        
        $sql_goal = "INSERT INTO SavingsGoals (User_id, category_id, goal_amount, target_date) VALUES (?, ?, ?, ?)";
        $stmt_goal = $conn->prepare($sql_goal);
        $stmt_goal->bind_param("iids", $user_id, $new_category_id, $goal_amount, $target_date);
        $stmt_goal->execute();

        $conn->commit();

        header("Location: ../savings.php");

    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $stmt->close();
    $stmt_goal->close();
}
}
else {
    echo "Error: Missing required fields.";
}
$conn->close();
?>