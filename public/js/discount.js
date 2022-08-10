$(document).ready(function () {
  discountProduct = $("#applies_to_product");
  categorySelect2 = $(".category-select2");

  categorySelect2.select2({
    allowClear: true,
    ajax: {
      url: categorySelect2.data("url"),
      data: function (params) {
        return {
          search: params.term,
          id: $(categorySelect2.data("target")).val(),
        };
      },
      dataType: "json",
      processResults: function (data) {
        return {
          results: data.results.map(function (item) {
            return {
              id: item.id,
              text: item.name,
              otherfield: item,
            };
          }),
        };
      },
      cache: true,
      delay: 250,
    },
    placeholder: "Select Category",
    // minimumInputLength: 1,
  });
  discountProduct.select2({
    allowClear: true,
    ajax: {
      url: discountProduct.data("url"),
      data: function (params) {
        return {
          search: params.term || "",
          id: $(discountProduct.data("target")).val(),
          page: params.page || 1,
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
      cache: true,
      delay: 250,
    },
    placeholder: "Select discount product",
    theme: "bootstrap4",
    // minimumInputLength: 1,
  });

  $(".generate-code").on("click", function () {
    var couponCode =
      Math.random().toString(36).substring(3, 6) +
      Math.random().toString(36).substring(10, 12);
    $("#discount_code").val(couponCode.toUpperCase());
  });

  // $('#applies_to_category').select2({
  //     placeholder: 'Select Category',
  //     allowClear :true
  // });

  $("#discount_type")
    .select2({
      placeholder: "Select Discount Type",
      allowClear: true,
    })
    .on("select2:select", function (e) {
      var el = $(this);
      var target = $("option:selected", el).data("target");
      var targetDiv = $(".discount-type-option");
      targetDiv.children().addClass("d-none").find("input").val(" ");
      if (typeof target !== "undefined") {
        $(target).removeClass("d-none");
      }
    })
    .on("select2:clear", function (e) {
      var targetDiv = $(".discount-type-option");
      targetDiv.children().addClass("d-none").find("input").val(null);
    });

  $(".applies-to").on("change", function (e) {
    var el = $(this);
    var target = el.data("target");
    var targetDiv = $(".applies-to-option");

    targetDiv
      .children()
      .addClass("d-none")
      .find("select")
      .val(null)
      .trigger("change");

    if (typeof target !== "undefined") {
      $(target)
        .removeClass("d-none")
        .find("select")
        .val(null)
        .trigger("change");
    }
  });

  $(".minimum-requirement").on("change", function (e) {
    var el = $(this);
    var target = el.data("target");
    var targetDiv = $(".minimum-requirement-option");
    targetDiv.children().addClass("d-none").find("input").val(null);

    if (typeof target !== "undefined") {
      $(target).removeClass("d-none").find("input").val(null);
    }
  });

  $(".shipping-charge").on("change", function () {
    var el = $(this);
    var target = $(el.data("target"));
    target.parent().children().addClass("d-none");
    target.removeClass("d-none");
  });

  $("#discountform").validate({
    debug: false,
    ignore: '.select2-search__field,:d-none:not("textarea,.files")',
    rules: {},
    errorPlacement: function (error, element) {
      // $(element).addClass('is-invalid')
      error.appendTo(element.parent()).addClass("text-danger");
    },
    submitHandler: function (e) {
      return true;
    },
  });

  $("#start_date").datetimepicker({
    format: "DD-MM-YYYY",
    keepOpen: false,
    showClear: true,
    showClose: true,

    icons: {
      time: "fa fa-clock",
      date: "fa fa-calendar",
      up: "fa fa-arrow-up",
      down: "fa fa-arrow-down",
    },
  });

  $("#end_date").datetimepicker({
    format: "DD-MM-YYYY",
    keepOpen: false,
    showClear: true,
    showClose: true,
    icons: {
      time: "fa fa-clock",
      date: "fa fa-calendar",
      up: "fa fa-arrow-up",
      down: "fa fa-arrow-down",
    },
    useCurrent: false, //Important! See issue #1075 ,
  });

  $("#start_date").on("change.datetimepicker", function (e) {
    $("#end_date").datetimepicker("minDate", e.date);
    $("#end_date").focus();
  });

  $("#end_date").on("change.datetimepicker", function (e) {
    $("#start_date").datetimepicker("maxDate", e.date);
    $("#start_date").focus();
  });
});
