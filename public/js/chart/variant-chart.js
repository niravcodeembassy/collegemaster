$(document).ready(function () {
  var DATE_RANGE = [];

  var ajaxUrl = $("#variant_daterangepicker").data("url");
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

  var pieChartCanvas = $("#variant_pie_chart").get(0).getContext("2d");
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
            legendItem.text = `${legendItem.text} : ${qtd}`;
            return true;
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
    var lab = data.labels.map(function (item) {
      let variant = JSON.parse(item);
      var value = Object.values(variant);
      let text = "";
      value.forEach(myFunction);
      function myFunction(item, index) {
        if (index == 0) {
          text += item;
        } else {
          text += ": " + item + "";
        }
      }
      return text;
    });
    donutData.labels = lab;
    donutData.datasets[0].data = data.quantity_sold;
    donutData.datasets[0].backgroundColor = data.color;
    chart.update();
  }

  //date range piker

  var DATE_RANGE = [];
  var start = moment().startOf("month");
  var end = moment().endOf("month");

  // var first_date = start.format("YYYY-MM-DD");
  // var last_date = end.format("YYYY-MM-DD");

  ajaxRequest(ajaxUrl);

  function cb(start, end) {
    $("#variant_daterangepicker").val(
      start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
    );
  }

  $("#variant_daterangepicker").daterangepicker(
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

  $("#variant_daterangepicker").on("apply.daterangepicker",function (ev, picker) {
      $(".variant_cancel").css("display", "block");
      var el = $(this);
      var url = el.data("url");
      DATE_RANGE[0] = picker.startDate.format("YYYY-MM-DD");
      DATE_RANGE[1] = picker.endDate.format("YYYY-MM-DD");

      if(picker.chosenLabel != 'Custom Range'){
        $("#variant_daterangepicker").val(picker.chosenLabel);
      }
      ajaxRequest(url, DATE_RANGE[0], DATE_RANGE[1]);
    }
  );

  $("#variant_daterangepicker").on(
    "cancel.daterangepicker",
    function (ev, picker) {
      $(this).val("");
      DATE_RANGE = [];
      picker.setStartDate({});
      picker.setEndDate({});
      $(".variant_cancel").hide();
      ajaxRequest(ajaxUrl);
    }
  );

  $(document).on("click", ".variant_cancel", function (e) {
    DATE_RANGE = [];
    $('#variant_daterangepicker').val('');
    ajaxRequest(ajaxUrl);
    $(this).hide();
  });

  function ajaxRequest(url,  start='', end='') {
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
        if (respons.quantity_sold.length == 0) {
          $(".variant_heading").show();
        } else {
          $(".variant_heading").hide();
        }
        addData(myChart, "# of payment", respons);
      })
      .fail(function (respons) {
        console.log(respons);
      });
  }
});
