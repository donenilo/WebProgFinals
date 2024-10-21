// scripts.js

// Login Form Validation
const loginForm = document.querySelector('form[action="../login_handler.php"]');
if (loginForm) {
  loginForm.addEventListener('submit', (e) => {
    const username = loginForm.querySelector('input[name="username"]').value;
    const password = loginForm.querySelector('input[name="password"]').value;

    if (!username || !password) {
      e.preventDefault();
      alert("Please fill out all fields.");
    }
  });
}

// Signup Form Validation
const signupForm = document.querySelector('form[action="../signup_handler.php"]');
if (signupForm) {
  signupForm.addEventListener('submit', (e) => {
    const username = signupForm.querySelector('input[name="username"]').value;
    const email = signupForm.querySelector('input[name="email"]').value;
    const password = signupForm.querySelector('input[name="password"]').value;

    if (!username || !email || !password) {
      e.preventDefault();
      alert("Please fill out all fields.");
    } else if (password.length < 6) {
      e.preventDefault();
      alert("Password must be at least 6 characters long.");
    }
  });
}

// Quick Add Income/Expense Popup Logic
const openIncomePopup = document.querySelector('.open-income-popup');
const openExpensePopup = document.querySelector('.open-expense-popup');
const incomePopup = document.querySelector('#incomePopup');
const expensePopup = document.querySelector('#expensePopup');
const closeButtons = document.querySelectorAll('.close-popup');

// Open and close popup modals - NOTE: EXPERIMENTAL - NOT YET COMPLETE
// if (openIncomePopup) {
//   openIncomePopup.addEventListener('click', () => {
//     incomePopup.style.display = 'block';
//   });
// }

// if (openExpensePopup) {
//   openExpensePopup.addEventListener('click', () => {
//     expensePopup.style.display = 'block';
//   });
// }

// closeButtons.forEach((button) => {
//   button.addEventListener('click', () => {
//     button.parentElement.style.display = 'none';
//   });
// });

// // Close popups when clicking outside of them
// window.addEventListener('click', (e) => {
//   if (e.target === incomePopup) incomePopup.style.display = 'none';
//   if (e.target === expensePopup) expensePopup.style.display = 'none';
// });

// Polling Function for Real-time Dashboard Updates
function pollDashboardData() {
  fetch('../api/get_dashboard_data.php')
    .then((response) => response.json())
    .then((data) => {
      document.querySelector('.total-balance').textContent = `₱${data.totalBalance}`;
      document.querySelector('.total-income').textContent = `₱${data.totalIncome}`;
      document.querySelector('.total-expense').textContent = `₱${data.totalExpense}`;

      updateBalanceChart(data.remainingBalance, data.totalExpense);
    })
    .catch((error) => console.error('Error fetching dashboard data:', error));
}

// Update Pie Chart with new data
function updateBalanceChart(remaining, expense) {
  const chart = Chart.getChart('balanceChart'); 
  chart.data.datasets[0].data = [remaining, expense];
  chart.update();
}

// Poll every 5 seconds for real-time updates
setInterval(pollDashboardData, 5000);


// Fetch and display user data on the profile page
document.addEventListener('DOMContentLoaded', () => {
  fetch('../api/get_user_data.php')
    .then((response) => response.json())
    .then((data) => {
      document.getElementById('usernameDisplay').textContent = data.username;
      document.getElementById('emailDisplay').textContent = data.email;
    })
    .catch((error) => console.error('Error fetching user data:', error));
});

// Handle password change
const changePasswordForm = document.getElementById('changePasswordForm');
changePasswordForm.addEventListener('submit', (e) => {
  e.preventDefault();
  
  const formData = new FormData(changePasswordForm);
  fetch('../api/change_password.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert('Password updated successfully!');
      } else {
        alert(data.message || 'Password update failed.');
      }
    })
    .catch((error) => console.error('Error updating password:', error));
});

// Handle account deletion
const deleteAccountBtn = document.getElementById('deleteAccountBtn');
deleteAccountBtn.addEventListener('click', () => {
  if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
    fetch('../api/delete_account.php', { method: 'POST' })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert('Account deleted successfully.');
          window.location.href = '../logout.php';
        } else {
          alert(data.message || 'Account deletion failed.');
        }
      })
      .catch((error) => console.error('Error deleting account:', error));
  }
});