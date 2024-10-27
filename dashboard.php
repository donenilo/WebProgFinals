<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Tracker Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="scripts/scripts.js"></script>
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <h2>Finance Tracker</h2>
            <ul>
                <li class="active"><a href="#">📊 Dashboard</a></li>
                <li><a href="#">✏️ Tracking</a></li>
                <li><a href="#">📥 Income</a></li>
                <li><a href="#">💸 Expense</a></li>
                <li><a href="#">🎯 Goals</a></li> 
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
                    <h2 id="total-balance">₱0.00</h2>
                </div>
                <div class="card income">
                    <p>Total Income</p>
                    <h2 id="total-income">₱0.00</h2>
                </div>
                <div class="card expense">
                    <p>Total Expense</p>
                    <h2 id="total-expense">₱0.00</h2>
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
            <div class="quick-add">
                <button class="btn btn-income" onclick="openPopup('income')">⬆️ New Income</button>
                <button class="btn btn-expense" onclick="openPopup('expense')">💲 New Expense</button>
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

    <!-- Popup Forms
    <div class="popup" id="popup-income">
        <h2>Add New Income</h2>
        <input type="number" id="income-amount" placeholder="Enter Income Amount">
        <button onclick="addIncome()">Add Income</button>
        <button onclick="closePopup('income')">Cancel</button>
    </div>

    <div class="popup" id="popup-expense">
        <h2>Add New Expense</h2>
        <input type="number" id="expense-amount" placeholder="Enter Expense Amount">
        <button onclick="addExpense()">Add Expense</button>
        <button onclick="closePopup('expense')">Cancel</button>
    </div> -->

    <script src="scripts.js"></script>
</body>
</html>
