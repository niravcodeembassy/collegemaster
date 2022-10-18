$(document).ready(function () {
  var day_wise_revenue = JSON.parse(dayWiseRevenue);
  var dayRevenueChartData = {
    labels: day_wise_revenue.day,
    datasets: [
      {
        label: "Revenue",
        backgroundColor: day_wise_revenue.color[0],
        borderColor: "rgba(60,141,188,0.8)",
        pointRadius: false,
        pointColor: "#3b8bba",
        pointStrokeColor: "rgba(60,141,188,1)",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(60,141,188,1)",
        data: day_wise_revenue.day_revenue,
      },
    ],
  };

  var stackedBarDayRevenueChartCanvas = $("#dayWiseRevenueChart")
    .get(0)
    .getContext("2d");
  var stackedBarDayRevenueChartData = $.extend(true, {}, dayRevenueChartData);

  var stackedBarDayRevenueChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
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
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  };

  new Chart(stackedBarDayRevenueChartCanvas, {
    type: "bar",
    data: stackedBarDayRevenueChartData,
    options: stackedBarDayRevenueChartOptions,
  });
});
