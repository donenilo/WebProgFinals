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
            <h1 class="hsavings">Savings</h1>
            <h4>Recent Transactions</h4>
            <div class="tsavings">
                <!-- Savings Table -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><img src="assets/rectangle32.png">Date</th>
                            <th scope="col"><img src="assets/rectangle35.png">Description</th>
                            <th scope="col"><img src="assets/rectangle39.png">Amount</th>
                            <th scope="col"><img src="assets/goal.png">Goal</th>
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
            <h4>Goals</h4>
            <div class="tgoals">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col"><img src="assets/goal.png">Goal</th>
                            <th scope="col"><img src="assets/images 1.png">Target Amount</th>
                            <th scope="col"><img src="assets/rectangle39.png">Saved Amount</th>
                            <th scope="col"><img src="assets/rectangle32.png">Target Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // insert query to get the goal data
                        $query = "SELECT C.category_name AS 'Goal', SG.goal_amount AS 'Target Amount', COALESCE(SUM(S.savings_amount), 0) AS 'Saved Amount', SG.target_date AS 'Target Date'FROM Categories AS C JOIN SavingsGoals AS SG ON C.category_id = SG.category_id LEFT JOIN Savings AS S ON C.category_id = S.category_id WHERE C.category_type = 'Savings' GROUP BY C.category_id, SG.goal_amount, SG.target_date;";
                        $result = mysqli_query($conn, $query);
                        if (!$result) {
                            die("Query failed: " . mysqli_error($conn));
                        }
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["Goal"] . "</td>";
                            echo "<td>" . $row["Target Amount"] . "</td>";
                            echo "<td>" . $row["Saved Amount"] . "</td>";
                            echo "<td>" . $row["Target Date"] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="quick_add">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newSavingsModal"><img src="assets/rectangle39.png"> New Savings </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newGoalModal"><img src="assets/goal.png"> New Goal </button>
            </div>
        </div>
    </div>
    <!-- New Savings Modal -->
    <form action="config/savings_input.php" method="POST">
        <div class="modal fade" id="newSavingsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Savings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="savings_date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="savings_date" name="savings_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="savings_description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="savings_description" name="savings_description" required>
                        </div>
                        <div class="mb-3">
                            <label for="savings_amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="savings_amount" name="savings_amount" required>
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- New Goal Modal --> 
    <form action="config/savings_goal.php" method="POST">
        <div class="modal fade" id="newGoalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Goal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Goal Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="goal_amount" class="form-label">Goal Amount</label>
                            <input type="number" class="form-control" id="goal_amount" name="goal_amount" required>
                        </div>
                        <div class="mb-3">
                            <label for="target_date" class="form-label">Target Date</label>
                            <input type="date" class="form-control" id="target_date" name="target_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </form>                
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
