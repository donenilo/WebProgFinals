<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    // echo "Please login first.";
    // header('Location: index.php');
    // exit();

    // insert query to get the income data
    // $query = "SELECT I.income_id, I.User_id, I.income_date, I.income_description, I.income_amount, C.category_name FROM Income AS I JOIN Categories AS C ON Income.category_id = C.category_id WHERE I.User_id = $user_id;";
    // $result = mysqli_query($conn, $query);  
    // $income = mysqli_fetch_assoc($result);
    // $income_id = $income['I.income_id'];
    // $income_date = $income['I.income_date'];
    // $income_description = $income['I.income_description'];
    // $income_amount = $income['I.income_amount'];
    // $category_name = $income['C.category_name'];

    // if(!$result) {  
    //     die("query failed".mysqli_error($conn));
    // }


}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Tracker Income</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <h2>Finance Tracker</h2>
            <ul>
                <li><a href="dashboard.php">📊 Dashboard</a></li>
                <li><a href="income.php">✏️ Tracking</a></li>
                <li class="active"><a href="income.php">📥 Income</a></li>
                <li><a href="expense.php">💸 Expense</a></li>
                <li><a href="goals.php">🎯 Goals</a></li> 
            </ul>
            <div class="sidebar-footer">
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Income</h1>
            <div class="income_table_display">
            
            </div>
            <div class="income_sources">

            </div>
            <div class="quick_add">>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newIncomeModal"> New Income </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newIncomeSourceModal"> New Income Source </button>
            </div>
        </div>
    </div>
    <!-- New Income Modal -->
    <form>
        <div class="modal fade" id="newIncomeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Input Income Details</h5>
                    </div>
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="Date">Date</label>
                                <input type="date" class="form-control" id="incomeSourceDate" placeholder="Enter date">
                            </div>
                            <div class="form-group">
                                <label for="incomeDescription">Income Description</label>
                                <input type="text" class="form-control" id="incomeSourceDescription" placeholder="Enter income source description">
                            </div>
                            <div class="form-group">
                                <label for="incomeAmount">Income Amount</label>
                                <input type="number" class="form-control" id="incomeSourceAmount" placeholder="Enter income source amount">
                            </div>
                            <div class="form-group">
                                <label for="incomeSource">Income Source</label>
                                <select class="form-control" id="incomeSourceCategory">
                                    <!-- Placeholders only, not yet connected with database -->
                                    <option value="Salary">Salary</option>
                                    <option value="Business">Business</option>
                                    <option value="Investment">Investment</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- New Income Source Modal -->
    <form>
        <div class="modal fade" id="newIncomeSourceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="incomeSourceName">Income Source Name</label>
                            <input type="text" class="form-control" id="incomeSourceName" placeholder="Enter income source name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>