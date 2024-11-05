<?php
//database connection
include 'config/db_connection.php';
session_start();

//login validation
if (!isset($_SESSION['User_id'])) {
    echo "Please login first.";
    header('Location: index.php');
    exit();
}
//user_id declaration
$user_id = $_SESSION['User_id'];

// Fetch categories where User_id = ? and category_type = 'Income'
$sql = "SELECT category_id, category_name FROM Categories WHERE User_id = $user_id AND category_type = 'Income';";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
// output data of each row
$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row; // Store each category in an array
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
    <!-- Sidebar -->
    <div class="container">
        <nav class="sidebar">
            <h2>Finance Tracker</h2>
            <ul>
                <li><a href="dashboard.php"><img src="assets/chartbar.png"> Dashboard</a></li>
                <li><a href="income.php"><img src="assets/notepencil.png"> Tracking</a></li>
                <li class="active"><a href="income.php"><img src="assets/creditcard-add.png"> Income</a></li>
                <li><a href="expense.php"><img src="assets/dollar signs.png"> Expense</a></li>
                <li><a href="savings.php"><img src="assets/savings.png"> Savings</a></li> 
            </ul>
            <div class="sidebar-footer">
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Income Table -->
            <h1 class="hincome">Income</h1>
            <div class="income_table_display">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Description</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        // insert query to get the income data
                        $query = "SELECT 
                        I.income_id, 
                        I.User_id, 
                        I.income_date, 
                        I.income_description, 
                        I.income_amount, 
                        C.category_name 
                        FROM Income AS I JOIN Categories AS C ON I.category_id = C.category_id 
                        WHERE I.User_id = $user_id;";
                        $result = mysqli_query($conn, $query);  
                        if(!$result) {  
                            die("query failed".mysqli_error($conn));
                        }
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["income_date"] . "</td>";
                            echo "<td>" . $row["income_description"] . "</td>";
                            echo "<td>" . $row["income_amount"] . "</td>";
                            echo "<td>" . $row["category_name"] . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
            </div>
            <!-- Income Source Table -->
            <div class="income_sources">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Income Source</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT CONCAT(C.category_name, ': ', SUM(I.income_amount)) AS 'Income Source' FROM Income AS I JOIN Categories AS C ON I.category_id = C.category_id WHERE C.category_type = 'Income' AND I.User_id = $user_id GROUP BY I.category_id;";
                        $result = mysqli_query($conn, $query);
                        if (!$result) {
                            die("Query failed: " . mysqli_error($conn));
                        }
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["Income Source"] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            </div>
            <div class="quick_add">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newIncomeModal"> New Income </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newIncomeSourceModal"> New Income Source </button>
            </div>
        </div>
    </div>
    <!-- New Income Modal -->
    <form action="config/income_input.php" method="POST">
        <div class="modal fade" id="newIncomeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Input Income Details</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Date">Date</label>
                            <input type="date" class="form-control" name="income_date" placeholder="Enter date">
                        </div>
                        <div class="form-group">
                            <label for="incomeDescription">Income Description</label>
                            <input type="text" class="form-control" name="income_description" placeholder="Enter income source description">                            </div>
                        <div class="form-group">
                            <label for="incomeAmount">Income Amount</label>
                            <input type="number" class="form-control" name="income_amount" placeholder="Enter income source amount">
                        </div>
                        <div class="form-group">
                            <label for="incomeSource">Income Source</label>
                            <select id="form-control" name="category_id" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- New Income Source Modal -->
    <form action="config/income_source.php" method="POST">
        <div class="modal fade" id="newIncomeSourceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="incomeSourceName">Income Source Name</label>
                            <input type="text" name="income_source"class="form-control" id="incomeSourceName" placeholder="Enter income source name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button submit" class="btn btn-success">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

