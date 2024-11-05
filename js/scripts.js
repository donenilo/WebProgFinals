// // Get PHP variables Will transition to inline script instead of external
// console.log("<?php echo $Tremaining; ?>");
// console.log("<?php echo $TExpense; ?>");
// document.addEventListener('DOMContentLoaded', function () {
// const remainingBalance = parseFloat("<?php echo $Tremaining; ?>");
// const totalSpent = parseFloat("<?php echo $TExpense; ?>");  

// new Chart("myChart", {
//     type: "pie",
//     data: {
//       labels: ["Total Spent", "Remaining Balance"],
//       datasets: [{
//         backgroundColor: ["#b91d47", "#00FF00"],
//         data: [totalSpent, remainingBalance]
//       }]
//     },
//     options: {
//       title: {
//         display: true,
//         text: "Balance Chart"
//       }
//     }
//   });
// });

// const aValues = ["", "", "", "", "",""];
// const bValues = [19, 38, 57, 38, 57, 57];
// const barColors1 = ["black", "black","black","black","black", "black"];

// new Chart("yourChart", {
// type: "bar",
// data: {
//     labels: aValues,
//     datasets: [{
//     backgroundColor: barColors1,
//     data: bValues
//     }]
// },
// options: {
//     legend: {display: false},
//     title: {
//       display: true,
//       text: "Chart data will be shown here"
//     }
// }
// });



//edit function

// Example function to populate the edit modal
function openEditModal(incomeId, incomeDate, incomeDescription, incomeAmount, categoryId) {
    document.getElementById('edit_income_id').value = incomeId;
    document.getElementById('editDate').value = incomeDate;
    document.getElementById('editIncomeDescription').value = incomeDescription;
    document.getElementById('editIncomeAmount').value = incomeAmount;
    document.getElementById('editIncomeSource').value = categoryId;
    
    // Show the modal
    var editModal = new bootstrap.Modal(document.getElementById('editFunctionModal'));
    editModal.show();
}