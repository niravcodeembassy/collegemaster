$(document).ready(function () {
  var DATE_RANGE = [];

  function record(response) {
    $(".total_customer").text(response.customers);
    $(".total_order").text(response.orders);
    $(".revenue").text(response.revenue);
  }

  //date range piker
  var start = moment().startOf("month");
  var end = moment().endOf("month");

  // var first_date = start.format("YYYY-MM-DD");
  // var last_date = end.format("YYYY-MM-DD");

  // ajaxRequest(ajaxUrl, first_date, last_date);

  function cb(start, end) {
    $("#order_rangepicker").val(
      start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
    );
  }

  $("#order_rangepicker").daterangepicker(
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

  $("#order_rangepicker").on("apply.daterangepicker", function (ev, picker) {
    $(".order_cancel").css("display", "block");
    var el = $(this);
    var url = el.data("url");
    DATE_RANGE[0] = picker.startDate.format("YYYY-MM-DD");
    DATE_RANGE[1] = picker.endDate.format("YYYY-MM-DD");

    ajaxRequest(url, DATE_RANGE[0], DATE_RANGE[1]);
  });

  $("#order_rangepicker").on("cancel.daterangepicker", function (ev, picker) {
    showLoader();
    $(this).val("");
    DATE_RANGE = [];
    picker.setStartDate({});
    picker.setEndDate({});
    $(".order_cancel").hide();
    $("#order_rangepicker").val("");
    // ajaxRequest(ajaxUrl, first_date, last_date);
    record(defaultFilter);
    stopLoader();
  });

  $(document).on("click", ".order_cancel", function (e) {
    showLoader();
    cb(start, end);
    DATE_RANGE = [];
    $("#order_rangepicker").val("");
    // ajaxRequest(ajaxUrl, first_date, last_date);
    $(this).hide();
    record(defaultFilter);
    stopLoader();
  });

  // cb(start, end);

  function ajaxRequest(url, start, end) {
    showLoader();
    $.ajax({
      type: "get",
      url: url,
      data: {
        startDate: start,
        endDate: end,
      },
    })
      .always(function (respons) {
        stopLoader();
      })
      .done(function (respons) {
        record(respons);
      })
      .fail(function (respons) {
        console.log(respons);
      });
  }
});
