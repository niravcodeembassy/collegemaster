$(document).ready(function () {
  var DATE_RANGE = [];

  var ajaxUrl = $("#material_daterangepicker").data("url");
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

  var pieChartCanvas = $("#material_pie_chart").get(0).getContext("2d");
  pieChartCanvas.height = 350;
  var pieData = donutData;
  var pieOptions = {
    maintainAspectRatio: false,
    responsive: false,
    tooltips: {
      enabled: true,
      mode: "single",
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
    donutData.datasets[0].data = data.quantity_sold;
    donutData.datasets[0].backgroundColor = data.color;
    chart.update();
  }

  //date range piker

  var DATE_RANGE = [];
  var start = moment().startOf("month");
  var end = moment().endOf("month");

  var first_date = start.format("YYYY-MM-DD");
  var last_date = end.format("YYYY-MM-DD");

  ajaxMaterialRequest(ajaxUrl, first_date, last_date);

  function cb(start, end) {
    $("#material_daterangepicker").val(
      start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
    );
  }

  $("#material_daterangepicker").daterangepicker(
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

  cb(start, end);

  $("#material_daterangepicker").on(
    "apply.daterangepicker",
    function (ev, picker) {
      $(".material_cancel").css("display", "block");
      var el = $(this);
      var url = el.data("url");
      DATE_RANGE[0] = picker.startDate.format("YYYY-MM-DD");
      DATE_RANGE[1] = picker.endDate.format("YYYY-MM-DD");

      ajaxMaterialRequest(url, DATE_RANGE[0], DATE_RANGE[1]);
    }
  );

  $("#material_daterangepicker").on(
    "cancel.daterangepicker",
    function (ev, picker) {
      $(this).val("");
      DATE_RANGE = [];
      picker.setStartDate({});
      picker.setEndDate({});
      $(".material_cancel").hide();
      ajaxMaterialRequest(ajaxUrl, first_date, last_date);
    }
  );

  $(document).on("click", ".material_cancel", function (e) {
    cb(start, end);
    DATE_RANGE = [];
    ajaxMaterialRequest(ajaxUrl, first_date, last_date);
    $(this).hide();
  });

  // cb(start, end);

  function ajaxMaterialRequest(url, start, end) {
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
          $(".material_heading").show();
        } else {
          $(".material_heading").hide();
        }
        addData(myChart, "# of payment", respons);
      })
      .fail(function (respons) {
        console.log(respons);
      });
  }
});
