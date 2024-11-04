<?php
include 'config/db_connection.php';
session_start();

if (!isset($_SESSION['User_id'])) {
    echo "Please login first.";
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['User_id'];


// Fetch total income, expense, savings, and remaining balance
$query = "SELECT 
    u.User_id,
    COALESCE(i.total_income, 0) AS total_income,
    COALESCE(e.total_expense, 0) AS total_expense,
    COALESCE(s.total_savings, 0) AS total_savings,
    (COALESCE(i.total_income, 0) 
    - COALESCE(e.total_expense, 0) 
    - COALESCE(s.total_savings, 0)) AS total_remaining_balance
FROM 
    Users u
LEFT JOIN (
    SELECT User_id, SUM(income_amount) AS total_income
    FROM Income
    GROUP BY User_id
) i ON u.User_id = i.User_id
LEFT JOIN (
    SELECT User_id, SUM(expense_amount) AS total_expense
    FROM Expense
    GROUP BY User_id
) e ON u.User_id = e.User_id
LEFT JOIN (
    SELECT User_id, SUM(savings_amount) AS total_savings
    FROM Savings
    GROUP BY User_id
) s ON u.User_id = s.User_id
WHERE 
    u.User_id = ?;
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$TIncome = $user['total_income'];
$TExpense = $user['total_expense'];
$TSavings = $user['total_savings'];
$TRemaining = $user['total_remaining_balance'];
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Tracker Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <h2>Finance Tracker</h2>
            <ul>
                <li class="active"><a href="dashboard.php"><img src="assets/chartbar.png"> Dashboard</a></li>
                <li><a href="income.php"><img src="assets/notepencil.png"> Tracking</a></li>
                <li><a href="income.php"><img src="assets/creditcard-add.png"> Income</a></li>
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
            <h1>Dashboard</h1>

            <!-- Balance Cards -->
            <div class="card-container">
                <div class="card balance">
                    <p>Total Balance</p>
                    <h2 id="total-balance"><?php echo $TRemaining; ?></h2>
                </div>
                <div class="card savings">
                    <p>Total Savings</p>
                    <h2 id="total-savings"><?php echo $TSavings; ?></h2>
                </div>
                <div class="card income">
                    <p>Total Income</p>
                    <h2 id="total-income"><?php echo $TIncome; ?></h2>
                </div>
                <div class="card expense">
                    <p>Total Expense</p>
                    <h2 id="total-expense"><?php echo $TExpense; ?></h2>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts">
                <div class="chart">
                    <h3>Balance Chart</h3>
                    <canvas id="balanceChart"></canvas>
                </div>
            </div>

            <!-- Goals Tracking Placeholder -->
            <div class="goals-placeholder">
                <h3>Goals Tracking</h3>
                <p>Goals data will be shown here...</p>
            </div>

            <!-- Quick Add Section -->
            <div class="quick_add">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newIncomeModal">⬆️ New Income</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newExpenseModal">💲 New Expense</button>
            </div>

            <!-- Recent Transactions -->
            <div class="transactions">
                <h3>Recent Transactions</h3>
                <ul id="transaction-list">
                    <!-- Transactions will be dynamically added here -->
                </ul>
            </div>
        </div>
    </div>

    <!-- PHP for fetching income categories -->
    <?php
    $sql = "SELECT category_id, category_name FROM Categories WHERE User_id = $user_id AND category_type = 'Income';";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row; 
    }
    ?>

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

    <!-- PHP for fetching expense categories -->

    <?php
    // Fetch categories where User_id = ? and category_type = 'Expense'
    $query = "SELECT category_id, category_name FROM Categories WHERE User_id = $user_id and category_type = 'Expense';";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    ?>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
