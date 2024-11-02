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
    $income_date = isset($_POST['income_date']) ? $_POST['income_date'] : null;
    $income_description = isset($_POST['income_description']) ? $_POST['income_description'] : null;
    $income_amount = isset($_POST['income_amount']) ? $_POST['income_amount'] : null;
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;
    $user_id = isset($_SESSION['User_id']) ? $_SESSION['User_id'] : null;

    if ($income_date && $income_description && $income_amount && $category_id && $user_id) {
        $sql = "INSERT INTO Income (User_id, income_date, income_description, income_amount, category_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issdi", $user_id, $income_date, $income_description, $income_amount, $category_id);

        if ($stmt->execute()) {
            header("Location: ../income.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: Missing required fields.";
    }
}
?>