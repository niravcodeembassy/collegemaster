$(document).ready(function () {
  var last_six_month_sales = JSON.parse(sixMonthSale);

  var salesChartData = {
    labels: last_six_month_sales.month,
    datasets: [
      {
        label: "Order",
        fill: "start",
        lineTension: 0.4,
        // borderColor: "rgba(60,141,188,0.8)",
        backgroundColor: last_six_month_sales.color[0],
        pointRadius: false,
        pointColor: "#3b8bba",
        pointStrokeColor: "rgba(60,141,188,1)",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(60,141,188,1)",
        data: last_six_month_sales.month_sales,
      },
    ],
  };

  var stackedBarSalesChartCanvas = $("#sixMonthSalesChart")
    .get(0)
    .getContext("2d");
  var stackedBarSalesChartData = $.extend(true, {}, salesChartData);

  var stackedBarSalesChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
      display: false,
    },
    plugins: {
      filler: {
        propagate: false,
      },
      title: {
        display: false,
        text: (ctx) => "Fill: " + ctx.chart.data.datasets[0].fill,
      },
    },
    interaction: {
      intersect: false,
    },
  };

  new Chart(stackedBarSalesChartCanvas, {
    type: "line",
    data: stackedBarSalesChartData,
    options: stackedBarSalesChartOptions,
  });
});
