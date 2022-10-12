$(document).ready(function () {
  //select2
  let $rolePermission = $("#country_id");

  $rolePermission.select2({
    theme: "bootstrap4",
    allowClear: true,
    ajax: {
      url: function () {
        return $(this).data("url");
      },
      data: function (params) {
        return {
          search: params.term,
        };
      },
      dataType: "json",
      processResults: function (data) {
        return {
          results: data.data.map(function (item) {
            return {
              id: item.id,
              text: item.name,
              otherfield: item,
            };
          }),
        };
      },
      //cache: true,
      delay: 250,
    },
  });
});

var ajaxUrl = $("#country_pie_chart").data("link");

$(document).on("select2:select", "#country_id", function (event) {
  country = event.params.data.text;
  ajaxCountryRequest(ajaxUrl, country);
});

$(document).on("select2:unselect", "#country_id", function (event) {
  ajaxCountryRequest(ajaxUrl, "India");
});


ajaxCountryRequest(ajaxUrl, "India");
//pie chart
var donutData = {
  labels: [],
  datasets: [
    {
      data: [],
      backgroundColor: [],
    },
  ],
};

var pieChartCanvas = $("#country_pie_chart").get(0).getContext("2d");
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
  type: "pie",
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

function ajaxCountryRequest(url, country) {
  $.ajax({
    type: "get",
    url: url,
    data: {
      country: country,
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
