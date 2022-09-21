$(document).ready(function () {
  ClassicEditor.create(document.querySelector("#content"), {
    heading: {
      options: [
        {
          model: "paragraph",
          title: "Paragraph",
          class: "ck-heading_paragraph",
        },
        {
          model: "heading1",
          view: "h1",
          title: "Heading 1",
          class: "ck-heading_heading1",
        },
        {
          model: "heading2",
          view: "h2",
          title: "Heading 2",
          class: "ck-heading_heading2",
        },
        {
          model: "heading3",
          view: "h3",
          title: "Heading 3",
          class: "ck-heading_heading2",
        },
      ],
    },
  }).catch((error) => {
    console.error(error);
  });
  ClassicEditor.create(document.querySelector("#short_content"), {
    heading: {
      options: [
        {
          model: "paragraph",
          title: "Paragraph",
          class: "ck-heading_paragraph",
        },
        {
          model: "heading1",
          view: "h1",
          title: "Heading 1",
          class: "ck-heading_heading1",
        },
        {
          model: "heading2",
          view: "h2",
          title: "Heading 2",
          class: "ck-heading_heading2",
        },
        {
          model: "heading3",
          view: "h3",
          title: "Heading 3",
          class: "ck-heading_heading2",
        },
      ],
    },
  }).catch((error) => {
    console.error(error);
  });

  ClassicEditor.create(document.querySelector("#additional_description"), {
    toolbar: ["bold", "heading", "italic", "numberedList", "bulletedList"],
  })
    .then((editor) => {})
    .catch((error) => {
      console.error(error);
    });

  $("#product_form").validate({
    debug: false,
    ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
    rules: {},
    messages: {},
    errorPlacement: function (error, element) {
      error.appendTo(element.parent()).addClass("text-danger");
    },
    submitHandler: function (e) {
      e.submit();
    },
  });

  categorySelect2 = $(".category-select2");
  subCategorySelect2 = $(".sub-category-select2");
  bytogetherSelect2 = $(".buy-together-select2");
  hsncode = $(".hsncode-select2");

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
    placeholder: "Select Category",
    theme: "bootstrap4",
    // minimumInputLength: 1,
  });

  subCategorySelect2.select2({
    allowClear: true,
    ajax: {
      url: subCategorySelect2.data("url"),
      data: function (params) {
        return {
          search: params.term,
          id: $(subCategorySelect2.data("target")).val(),
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
    placeholder: "Select Sub Category",
    theme: "bootstrap4",
    // minimumInputLength: 1,
  });

  bytogetherSelect2.select2({
    // allowClear: true,
    theme: "bootstrap4",
    ajax: {
      url: bytogetherSelect2.data("url"),
      data: function (params) {
        return {
          search: params.term || "",
          id: $(bytogetherSelect2.data("target")).val(),
          page: params.page || 1,
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
    placeholder: "Select buy together product",
    // minimumInputLength: 1,
  });

  hsncode.select2({
    allowClear: true,
    ajax: {
      url: hsncode.data("url"),
      data: function (params) {
        return {
          search: params.term,
          id: $(hsncode.data("target")).val(),
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
    placeholder: "Select HSN code",
    theme: "bootstrap4",
    // minimumInputLength: 1,
  });

  categorySelect2.on("select2:select", function (e) {
    var el = $(this);
    subCategorySelect2.val(null).trigger("change");
  });

  $("#title").on("keydown keyup", function (e) {
    // alert('keypress');
    var el = $(this);
    var textdata = el.val();
    var slug = convertToSlug(textdata);
    $("#meta_slug").val(slug);
  });

  $(".tax-row").on("change keyup", function (e) {
    var el = $(this);
    var mrp_amount = $("#mrp_amount");
    var offer_price = $("#offer_price");
    var taxable_price = $("#taxable_price");
    var tax_type = $("input[name=tax_type]:checked").val();
    var taxable_percentage = $("#taxable_percentage").val();

    var new_taxable_price = 0.0;

    if (offer_price.val() && taxable_percentage > 0 && offer_price.val() > 0) {
      new_taxable_price = parseFloat(
        OnCalcGST(offer_price.val(), taxable_percentage, tax_type)
      );
      taxable_price.val(new_taxable_price);
      return true;
    }

    if (mrp_amount.val() && taxable_percentage > 0) {
      new_taxable_price = parseFloat(
        OnCalcGST(mrp_amount.val(), taxable_percentage, tax_type)
      );
    }

    taxable_price.val(new_taxable_price);
  });
});

function OnCalcGST(price, taxRate = 0, priceIncludeTax, round = true) {
  var price = parseFloat(price);
  var taxRate = parseFloat(taxRate);

  taxRate = taxRate / 100;

  if (priceIncludeTax == "1") {
    var amount = price * (1 - 1 / (1 + taxRate));
    amount = price - amount;
  } else {
    var amount = price * taxRate;
    amount = price + amount;
  }

  amount = parseFloat(amount);

  if (round) {
    amount = amount.toFixed(2);
  }

  return amount;
}

var convertToSlug = function convertToSlug(Text) {
  var data = Text.toLowerCase()
    .replace(/[^\w ]+/g, "")
    .replace(/ +/g, "-");
  return data;
};
