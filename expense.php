<?php
include 'config/db_connection.php';
session_start();

if (!isset($_SESSION['User_id'])) {
    echo "Please login first.";
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['User_id'];

// Fetch categories where User_id = ? and category_type = 'Expense'
$query = "SELECT category_id, category_name FROM Categories WHERE User_id = $user_id and category_type = 'Expense';";
$result = mysqli_query($conn, $query);
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
    <div class="container">
        <nav class="sidebar">
            <h2>Finance Tracker</h2>
            <ul>
            <li><a href="dashboard.php"><img src="assets/chartbar.png"> Dashboard</a></li>
                <li><a href="income.php"><img src="assets/notepencil.png"> Tracking</a></li>
                <li><a href="income.php"><img src="assets/creditcard-add.png"> Income</a></li>
                <li class="active"><a href="expense.php"><img src="assets/dollar signs.png"> Expense</a></li>
                <li><a href="savings.php"><img src="assets/savings.png"> Savings</a></li> 
            </ul>
            <div class="sidebar-footer">
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <h1 class="hexpense">Expense</h1>
            <div class="expense_table_display">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><img src="assets/rectangle32.png">Date</th>
                            <th scope="col"><img src="assets/rectangle35.png">Description</th>
                            <th scope="col"><img src="assets/rectangle39.png">Amount</th>
                            <th scope="col"><img src="assets/rectangle40.png">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // insert query to get the expense data
                        $query = "SELECT E.expense_id, E.User_id, E.expense_date, E.expense_description, E.expense_amount, C.category_name FROM Expense AS E JOIN Categories AS C ON E.category_id = C.category_id WHERE E.User_id = $user_id;";
                        $result = mysqli_query($conn, $query);
                        if (!$result) {
                            die("Query failed: " . mysqli_error($conn));
                        }
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='table-expense'>";
                            echo "<td class='table-expense'>" . $row["expense_date"] . "</td>";
                            echo "<td class='table-expense'>" . $row["expense_description"] . "</td>";
                            echo "<td class='table-expense'>" . $row["expense_amount"] . "</td>";
                            echo "<td class='table-expense'>" . $row["category_name"] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class = "edit-btn">
                    <button type = "button" class="btn btn-primary" data-bs-toggle="modal">Edit</button>
                </div>
            </div>
            <div class="expense_category_display">
            <div class="quick_add-expense">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newExpenseModal"><img src="assets/rectangle42.png"> New Expense </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newExpenseCategoryModal"><img src="assets/rectangle42.png"> New Expense Category </button>
            </div>
        </div>
    </div>
    <!-- New Expense Modal -->
    <form action="config/expense_input.php" method="POST">
        <div class="modal fade" id="newExpenseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Expense</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="expenseDate">Date</label>
                            <input type="date" class="form-control" id="expenseDate" name="expense_date" placeholder="Enter expense date">
                        </div>
                        <div class="form-group">
                            <label for="expenseDescription">Description</label>
                            <input type="text" class="form-control" id="expenseDescription" name="expense_description" placeholder="Enter expense description">
                        </div>
                        <div class="form-group">
                            <label for="expenseAmount">Expense</label>
                            <input type="number" class="form-control" id="expenseAmount" name="expense_amount" placeholder="Enter expense amount">
                        </div>
                        <div class="form-group">
                            <label for="expenseCategory">Category</label>
                            <select class="form-control" name="category_id" id="expenseCategory" required>
                                <?php foreach ($categories as $category):  ?>
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

    <!-- New Expense Category Modal -->
    <form action="config/expense_category.php" method="POST">
        <div class="modal fade" id="newExpenseCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Expense Category</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text" name="expense_category" class="form-control" id="categoryName" placeholder="Enter category name">
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
   
    <!-- Categories Section -->
    <div class="categories-section">
        <div class="categories-header">
            <h3>Categories</h3>
        </div>
        <div class="categories-list">
            <?php
            $query = "SELECT C.category_name, SUM(E.expense_amount) AS total_amount 
                    FROM Expense AS E 
                    JOIN Categories AS C ON E.category_id = C.category_id 
                    WHERE C.category_type = 'Expense' AND E.User_id = $user_id 
                    GROUP BY E.category_id;";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
            }
            // Output each category with total expenses
            while ($row = $result->fetch_assoc()) {
                echo "<div class='category-item'>";
                echo "<span class='category-name'>" . htmlspecialchars($row["category_name"]) . " </span>";
                echo "<span class='category-amount'> ₱" . number_format($row["total_amount"], 2) . "</span>";
                echo "</div>";
            }
            ?>
        </div>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
