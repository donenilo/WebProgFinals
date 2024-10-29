<?php
include 'db_connection.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

$query = "INSERT INTO users (username, email, password_hash) VALUES ('$username', '$email', '$password')";

if ($conn->query($query) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>
