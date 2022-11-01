$(document).ready(function () {
  var ajaxUrl = $("#country_daterangepicker").data("url");

  //pie chart
  var donutData = {
    labels: [],
    datasets: [
      {
        data: [],
        backgroundColor: [],
        borderWidth: 1,
        hoverOffset: 4,
      },
    ],
  };

  var pieChartCanvas = $("#country_pie_chart").get(0).getContext("2d");
  pieChartCanvas.height = 350;
  var pieData = donutData;
  var pieOptions = {
    maintainAspectRatio: false,
    responsive: false,
    plugins: {
      legend: {
        display: true,
        position: "right",
        align: "start",
        labels: {
          usePointStyle: true,
          pointStyle: "rectRounded",
          filter: (legendItem, data) => {
            const label = legendItem.text;
            const isLargeNumber = (element) => element == label;
            const labelIndex = data.labels.findIndex(isLargeNumber);
            const qtd = data.datasets[0].data[labelIndex];
            legendItem.text = `${legendItem.text} : $${qtd}`;
            return true;
          },
        },
      },
      tooltip: {
        callbacks: {
          label: function (context) {
            let label = context.label || "";
            if (label) {
              label += ": ";
            }
            if (context.parsed !== null) {
              label += new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
              }).format(context.parsed);
            }
            return label;
          },
        },
      },
    },
  };

  const config = {
    type: "doughnut",
    data: pieData,
    options: pieOptions,
  };

  var myChart = new Chart(pieChartCanvas, config);

  function addData(chart, label, data) {
    donutData.labels = data.labels;
    donutData.datasets[0].data = data.count;
    donutData.datasets[0].backgroundColor = data.color;
    chart.update();
  }

  var DATE_RANGE = [];
  var start = moment().startOf("month");
  var end = moment().endOf("month");

  // var first_date = start.format("YYYY-MM-DD");
  // var last_date = end.format("YYYY-MM-DD");

  ajaxRequest(ajaxUrl);

  function cb(start, end) {
    $("#country_daterangepicker").val(
      start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
    );
  }

  $("#country_daterangepicker").daterangepicker(
    {
      autoUpdateInput: false,
      locale: {
        format: "DD/MM/YYYY",
        cancelLabel: "Clear",
      },
      startDate: start,
      endDate: end,
      ranges: {
        Today: [moment(), moment()],
        Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
        "Last 7 Days": [moment().subtract(6, "days"), moment()],
        "Last 30 Days": [moment().subtract(29, "days"), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")],
        "Last Month": [
          moment().subtract(1, "month").startOf("month"),
          moment().subtract(1, "month").endOf("month"),
        ],
      },
    },
    cb
  );

  $("#country_daterangepicker").on(
    "apply.daterangepicker",
    function (ev, picker) {
      $(".country_cancel").css("display", "block");
      var el = $(this);
      var url = el.data("url");
      DATE_RANGE[0] = picker.startDate.format("YYYY-MM-DD");
      DATE_RANGE[1] = picker.endDate.format("YYYY-MM-DD");

      if (picker.chosenLabel != "Custom Range") {
        $("#country_daterangepicker").val(picker.chosenLabel);
      }

      ajaxRequest(url, DATE_RANGE[0], DATE_RANGE[1]);
    }
  );

  $("#country_daterangepicker").on(
    "cancel.daterangepicker",
    function (ev, picker) {
      $(this).val("");
      DATE_RANGE = [];
      picker.setStartDate({});
      picker.setEndDate({});
      $(".country_cancel").hide();
      ajaxRequest(ajaxUrl);
    }
  );

  $(document).on("click", ".country_cancel", function (e) {
    DATE_RANGE = [];
    ajaxRequest(ajaxUrl);
    $("#country_daterangepicker").val("");
    $(this).hide();
  });

  function ajaxRequest(url, start = "", end = "") {
    $.ajax({
      type: "get",
      url: url,
      data: {
        startDate: start,
        endDate: end,
      },
    })
      .always(function (respons) {})
      .done(function (respons) {
        if (respons.count.length == 0) {
          $(".country_heading").show();
        } else {
          $(".country_heading").hide();
        }
        addData(myChart, "# of payment", respons);
      })
      .fail(function (respons) {
        console.log(respons);
      });
  }
});
