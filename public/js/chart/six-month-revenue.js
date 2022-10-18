$(document).ready(function () {
  var last_six_month_revenue = JSON.parse(sixMonthRevenue);
  var revenueChartData = {
    labels: last_six_month_revenue.month,
    datasets: [
      {
        label: "Revenue",
        fill: "start",
        lineTension: 0.4,
        // borderColor: "rgba(60,141,188,0.8)",
        backgroundColor: last_six_month_revenue.color[0],
        pointRadius: false,
        pointColor: "#3b8bba",
        pointStrokeColor: "rgba(60,141,188,1)",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(60,141,188,1)",
        data: last_six_month_revenue.month_revenue,
      },
    ],
  };

  var stackedBarRevenueChartCanvas = $("#sixMonthRevenueChart")
    .get(0)
    .getContext("2d");
  var stackedBarRevenueChartData = $.extend(true, {}, revenueChartData);

  var stackedBarRevenueChartOptions = {
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
      tooltip: {
        callbacks: {
          label: function (context) {
            let label = context.dataset.label || "";

            if (label) {
              label += ": ";
            }
            if (context.parsed.y !== null) {
              label += new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
              }).format(context.parsed.y);
            }
            return label;
          },
        },
      },
    },
    interaction: {
      intersect: false,
    },
  };

  new Chart(stackedBarRevenueChartCanvas, {
    type: "line",
    data: stackedBarRevenueChartData,
    options: stackedBarRevenueChartOptions,
  });
});
