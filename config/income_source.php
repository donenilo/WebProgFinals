<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['User_id'])) {
    echo "Please login first.";
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['User_id'];
$category_type = "Income";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $income_source = isset($_POST['income_source']) ? $_POST['income_source'] : null;

    if ($income_source) {
        $sql = "INSERT INTO categories (User_id, category_name, category_type) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $income_source, $category_type);
        
        if($stmt->execute()){
            header("Location: ../income.php");    
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