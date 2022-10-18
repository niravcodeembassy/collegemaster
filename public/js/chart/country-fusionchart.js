FusionCharts.ready(function () {
  // var sale = countryWiseSale;
  var chartObj = new FusionCharts({
    type: "maps/worldwithcountries",
    renderAt: "chart-container",
    width: "600",
    height: "400",
    dataFormat: "json",
    dataSource: {
      chart: {
        caption: "Global Sales by Top Location",
        theme: "fusion",
        formatNumberScale: "0",
        numberSuffix: "%",
      },
      colorrange: {
        color: [
          {
            minvalue: "0",
            maxvalue: "100",
            code: "#D0DFA3",
            displayValue: "< 100M",
          },
          {
            minvalue: "100",
            maxvalue: "500",
            code: "#B0BF92",
            displayValue: "100-500M",
          },
          {
            minvalue: "500",
            maxvalue: "1000",
            code: "#91AF64",
            displayValue: "500M-1B",
          },
          {
            minvalue: "1000",
            maxvalue: "5000",
            code: "#A9FF8D",
            displayValue: "> 1B",
          },
        ],
      },
      data: [
        {
          id: "23",
          value: "3875",
        },
        {
          id: "118",
          value: "387",
        },
      ],
    },
  });
  chartObj.render();
});
