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
    $goal = isset($_POST['goal']) ? $_POST['goal'] : null;
    $target_date = isset($_POST['target_date']) ? $_POST['target_date'] : null;
    $target_amount = isset($_POST['target_amount']) ? $_POST['target_amount'] : null;
    $user_id = isset($_SESSION['User_id']) ? $_SESSION['User_id'] : null;

    if ($goal && $target_date && $target_amount) {
        $sql = "INSERT INTO Savingsgoals (User_id, goal, target_date, target_amount) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $user_id, $goal, $target_date, $target_amount);
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
?>