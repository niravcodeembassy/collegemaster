$.validator.addMethod(
  "filesize",
  function (value, element, param) {
    if (element.files.length) {
      return this.optional(element) || element.files[0].size <= param;
    }
    return true;
  },
  "File size must be less than 5mb."
);

$(document).ready(function () {
  $(document).on("click", ".file-upload-browse", function () {
    var file = $(this).parents().find(".file-upload-default");
    file.trigger("click");
  });

  $(document).on("click", ".file-upload-clear", function () {
    $(".file-upload-default").val("");
    $(".file-upload-default").trigger("change");
  });

  $(document).on("change", ".file-upload-default", function () {
    var el = $(this);
    var preview = $("#preview");

    if (el.val() && el.valid()) {
      readURL(this);
      el.parent()
        .find(".form-control")
        .val(el.val().replace(/C:\\fakepath\\/i, ""));
      return true;
    }

    preview.attr("src", preview.data("default"));
    el.val("");
    el.parent()
      .find(".form-control")
      .val(el.val().replace(/C:\\fakepath\\/i, ""));
  });

  var readURL = function (input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $("#preview").attr("src", e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
    }
  };

  $(document).on("change", "#changeIcon", function (e) {
    var el = $(this);
    var target = el.data("target");
    if (e.icon != "empty") {
      $(target).val(e.icon);
    }
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
