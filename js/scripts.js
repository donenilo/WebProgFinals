const xValues = ["Remaining Balance", "Total Spent"];
const yValues = [35.2,56.8];
const barColors = [
  "#b91d47",
  "#00aba9"
];

new Chart("myChart", {
    type: "pie",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: barColors,
        data: yValues
      }]
    },
    options: {
      title: {
        display: true,
        text: "Balance Chart"
      }
    }
  });

const aValues = ["", "", "", "", "",""];
const bValues = [19, 38, 57, 38, 57, 57];
const barColors1 = ["black", "black","black","black","black", "black"];

new Chart("yourChart", {
type: "bar",
data: {
    labels: aValues,
    datasets: [{
    backgroundColor: barColors1,
    data: bValues
    }]
},
options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Chart data will be shown here"
    }
}
});
