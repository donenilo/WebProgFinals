<?php
include 'config/db_connection.php';
session_start();

if (!isset($_SESSION['User_id'])) {
    echo "Please login first.";
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['User_id'];


// For modal drop down list
// fetch categories where User_id = ? and category_type = 'Savings'
$query = "SELECT category_id, category_name FROM Categories WHERE User_id = $user_id and category_type = 'Savings';";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
// output data of each row
$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Tracker Income</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <h2>Finance Tracker</h2>
            <ul>
                <li><a href="dashboard.php"><img src="assets/chartbar.png"> Dashboard</a></li>
                <li><a href="income.php"><img src="assets/notepencil.png"> Tracking</a></li>
                <li><a href="income.php"><img src="assets/creditcard-add.png"> Income</a></li>
                <li><a href="expense.php"><img src="assets/dollar signs.png"> Expense</a></li>
                <li class="active"><a href="savings.php"><img src="assets/savings.png"> Savings</a></li> 
            </ul>
            <div class="sidebar-footer">
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a> 
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Savings</h1>

            <div class="savings">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newSavingsModal"> New Savings </button>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Description</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Goal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // insert query to get the savings data
                        $query = "SELECT S.savings_id, S.User_id, S.savings_date, S.savings_description, S.savings_amount, C.category_name FROM Savings AS S JOIN Categories AS C ON S.category_id = C.category_id WHERE S.User_id = $user_id;";
                        $result = mysqli_query($conn, $query);  
                        if(!$result) {  
                            die("query failed".mysqli_error($conn));
                        }
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["savings_date"] . "</td>";
                            echo "<td>" . $row["savings_description"] . "</td>";
                            echo "<td>" . $row["savings_amount"] . "</td>";
                            echo "<td>" . $row["category_name"] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>