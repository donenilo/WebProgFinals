<?php
include 'db_connection.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

$query = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
$query->bind_param("sss", $username, $email, $password);

if ($query->execute() === TRUE) {
    header("Location: ../index.php");
} else {
    echo "Error: {$query->error}";
}
// Add query to check for duplicate usernames and emails - Note: incomplete code
$query = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
$query->bind_param("ss", $username, $email);
$query->execute();
$query->store_result();

// Add error handling for duplicate usernames and emails
switch ($query->errno) {
    case 1062: // 1062 is the error code for duplicate entry
        echo "Error: Username or email already exists.";
        break;
    default:
        echo "Error: {$query->error}";
}

$conn->close();
