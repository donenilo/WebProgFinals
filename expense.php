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
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <h2>Finance Tracker</h2>
            <ul>
                <li><a href="dashboard.php">📊 Dashboard</a></li>
                <li><a href="income.php">✏️ Tracking</a></li>
                <li><a href="income.php">📥 Income</a></li>
                <li class="active"><a href="expense.php">💸 Expense</a></li>
                <li><a href="goals.php">🎯 Goals</a></li> 
            </ul>
            <div class="sidebar-footer">
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Expense</h1>
            <div class="expense_table_display">
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
                        // insert query to get the expense data
                        $query = "SELECT E.expense_id, E.User_id, E.expense_date, E.expense_description, E.expense_amount, C.category_name FROM Expense AS E JOIN Categories AS C ON E.category_id = C.category_id WHERE E.User_id = $user_id;";
                        $result = mysqli_query($conn, $query);
                        if (!$result) {
                            die("Query failed: " . mysqli_error($conn));
                        }
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["expense_date"] . "</td>";
                            echo "<td>" . $row["expense_description"] . "</td>";
                            echo "<td>" . $row["expense_amount"] . "</td>";
                            echo "<td>" . $row["category_name"] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="expense_category_display">

            </div>
            <div class="quick_add">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newExpenseModal"> New Expense </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newExpenseCategoryModal"> New Expense Category </button>
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
    <form>
        <div class="modal fade" id="newExpenseCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Expense Category</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" placeholder="Enter category name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="addCategory()">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>