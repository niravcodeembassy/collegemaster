$(document).ready(function () {
  var day_wise_sale = JSON.parse(dayWiseSale);
  var DaySalesChartData = {
    labels: day_wise_sale.day,
    datasets: [
      {
        label: "Order",
        backgroundColor: day_wise_sale.color[0],
        borderColor: "rgba(60,141,188,0.8)",
        pointRadius: false,
        pointColor: "#3b8bba",
        pointStrokeColor: "rgba(60,141,188,1)",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(60,141,188,1)",
        data: day_wise_sale.day_sales,
      },
    ],
  };

  var stackedBarDaySalesChartCanvas = $("#dayWiseSalesChart")
    .get(0)
    .getContext("2d");
  var stackedBarDaySalesChartData = $.extend(true, {}, DaySalesChartData);

  var stackedBarDaySalesChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  };

  new Chart(stackedBarDaySalesChartCanvas, {
    type: "bar",
    data: stackedBarDaySalesChartData,
    options: stackedBarDaySalesChartOptions,
  });
});
