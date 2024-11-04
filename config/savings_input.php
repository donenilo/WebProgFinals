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
    $savings_date = isset($_POST['savings_date']) ? $_POST['savings_date'] : null;
    $savings_description = isset($_POST['savings_description']) ? $_POST['savings_description'] : null;
    $savings_amount = isset($_POST['savings_amount']) ? $_POST['savings_amount'] : null;
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;
    $user_id = isset($_SESSION['User_id']) ? $_SESSION['User_id'] : null;

    if ($savings_date && $savings_description && $savings_amount && $category_id) {
        $sql = "INSERT INTO Savings (User_id, savings_date, savings_description, savings_amount, category_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssi", $user_id, $savings_date, $savings_description, $savings_amount, $category_id);
        if ($stmt->execute()) {
            header("Location: ../savings.php");
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Missing required fields.";
    }
}