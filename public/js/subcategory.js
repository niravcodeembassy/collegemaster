$(document).ready(function () {
  const url = $("#name").attr("data-url");

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
  categorySelect2.on("select2:select", function (e) {
    var el = $(this);
    subCategorySelect2.val(null).trigger("change");
  });

  $("#categoriesForm").validate({
    debug: false,
    ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
    rules: {
      name: {
        required: true,
        remote: {
          url: url,
          data: {
            id: function (el) {
              return $("#name").attr("data-id");
            },
            category_id: function () {
              return $(".category-select2").val();
            },
          },
        },
      },
    },
    errorPlacement: function (error, element) {
      // $(element).addClass('is-invalid')
      error.appendTo(element.parent()).addClass("text-danger");
    },
  });

  ClassicEditor.create(document.querySelector("#description"), {
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
});
