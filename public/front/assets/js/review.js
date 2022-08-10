//Ajax load More
var page = 1;

$(document).on("click", ".review_load", function () {
  page++;
  var url = $(this).data("url");
  showLoader();
  $.ajax({
    url: url + "?page=" + page,
    type: "get",
    datatype: "html",
    beforeSend: function () {
      $(".ajax-load").show();
    },
  })
    .done(function (data) {
      stopLoader();
      if (data.html == "") {
        $.toast({
          heading: "Review",
          text: "No More Review Found",
          showHideTransition: "slide",
          icon: "info",
          loaderBg: "#f96868",
          position: "top-right",
        });
        return;
      }
      $(".ajax-load").hide();
      $("#review-data").append(data.html);
    })
    .fail(function (jqXHR, ajaxOptions, thrownError) {
      alert("server not responding...");
    });
});
