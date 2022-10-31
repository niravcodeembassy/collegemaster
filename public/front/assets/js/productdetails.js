$(document).ready(function () {
  $(document).on("change", ".change-combination", function () {
    var el = $(this);
    var collection = productCombination; // product combination
    var optionAndValue = $("select.change-combination"); //collection data

    $selectedVal = $(el).find(":selected");
    var option = $selectedVal.data("option");
    var optionValue = $selectedVal.data("optionvalue").toString();

    var selectBoxval = {}; //

    $.each(optionAndValue, function (indexOrKey, el) {
      if ($(el).val()) {
        $selectedVal = $(el).find(":selected");
        let option = $selectedVal.data("option");
        let optionValue = $selectedVal.data("optionvalue").toString();
        selectBoxval[option] = optionValue;
      }
    });

    var objectLength = Object.keys(selectBoxval).length;

    var varient_url = $("#varient_url").val();
    showLoader();

    $.ajax({
      url: varient_url,
      method: "POST",
      data: {
        selectBoxval: selectBoxval,
        option: option,
        optionValue: optionValue,
        objectLength: objectLength,
        product_id: $("#product_id").val(),
      },
    })
      .always(function (respons) {
        stopLoader();
      })
      .done(function (respons) {
        if (objectLength == 2) {
          $("#block-varient").html(respons);
          $(".discounted").text($("#new_main_price").text());
          $(".discounted-price").text($("#new_discounted_price").text());
          $(".discount-percentage").text($("#product_varient_discount").text());
          $(".shop-product__buttons")
            .children("a")
            .attr("data-cart", $("#product_varient_details").text());
          var product_image = $("#product_varient_image").text();
          if (product_image != null) {
            var varient_image = $("#slick_id_" + product_image)
              .parent("div")
              .parent("div")
              .attr("data-slick-index");

            if (varient_image != null) {
              $(".lazy").slick("slickGoTo", varient_image);
            }
          }
          let isMobile = window.matchMedia(
            "only screen and (max-width: 912px)"
          ).matches;
          if (isMobile) {
            $("html, body").animate(
              {
                scrollTop: $(".slick-initialized").offset().top,
              },
              1000
            );
          }

          /*---------- SCROLL TO TOP ON VARINET SELCETION ----------*/

          /*---------- END DHARM ----------*/
        } else {
          $("#block-varient").html(respons);
        }
      })
      .fail(function (respons) {
        var data = respons.responseJSON;
        toast.fire({
          type: "error",
          title: "Error",
          text: data.message
            ? data.message
            : "something went wrong please try again !",
        });
      });

    return;
    // alert('vin');
    // select product combination

    //both option value dose not selectd then return true
    // if (optionAndValue.length !== Object.keys(selectBoxval).length) {
    //     return true;
    // }

    // find seleted varint and out of storck
    let productVarinat = collection.filter(function (coll) {
      let variant = jQuery.extend({}, coll);
      delete variant.inventory_quantity;
      delete variant.variant_id;
      console.log(shallowEqual(variant, selectBoxval));
      return shallowEqual(variant, selectBoxval);
      return JSON.stringify(variant) === JSON.stringify(selectBoxval);
    });

    productVarinat = productVarinat.slice(0, 1).shift();

    if (
      productVarinat !== undefined &&
      productVarinat.inventory_quantity == 0
    ) {
      $.toast({
        heading: "Error",
        text: "available stock is 0",
        showHideTransition: "slide",
        icon: "error",
        loaderBg: "#f96868",
        position: "top-right",
        stack: 1,
        afterHidden: function () {
          // el.val("");
        },
      });
      $("#changeEvent").css({
        "pointer-events": "none",
        cursor: "not-allowed",
        opacity: 0.2,
      });
      return true;
    }

    // has no variant found in combination
    if (productVarinat == undefined) {
      $.toast({
        heading: "Error",
        text: "Variant is not available.",
        showHideTransition: "slide",
        icon: "error",
        loaderBg: "#f96868",
        position: "top-right",
        stack: 1,
        afterHidden: function () {
          // el.val("");
        },
      });
      $("#changeEvent").css({
        "pointer-events": "none",
        cursor: "not-allowed",
        opacity: 0.2,
      });
      return true;
    }
    $("#changeEvent").removeAttr("style");

    window.location.href = url + "?variant=" + productVarinat.variant_id;
    // collection.attr('data-variant', JSON.stringify(productVarinat));
  });

  $(document).on("click", ".add-to-cart", function (event, data) {
    var el = data || $(this);

    var cartData = JSON.parse(el.attr("data-cart"));

    var ele = $(".change-combination");
    var qty = $("#producQty");
    var url = $(".shop-product-url").data("url");
    var collection = productCombination; // product combination
    var optionAndValue = $("select.change-combination"); //collection data

    $selectedVal = $(ele).find(":selected");
    var option = $selectedVal.data("option");
    var optionValue = $selectedVal.data("optionvalue");

    var selectBoxval = {}; //

    $.each(optionAndValue, function (indexOrKey, ele) {
      if ($(ele).val()) {
        $selectedVal = $(ele).find(":selected");
        let option = $selectedVal.data("option");
        let optionValue = $selectedVal.data("optionvalue").toString();
        selectBoxval[option] = optionValue;
      }
    });

    var objectLength = Object.keys(selectBoxval).length;

    if (objectLength != 2) {
      $.toast({
        heading: "Warning",
        text: "Please Select Variant.",
        showHideTransition: "slide",
        icon: "warning",
        loaderBg: "#f96868",
        position: "top-right",
        stack: 1,
        afterHidden: function () {
          // el.val("");
        },
      });

      return false;
    }

    cartData.cartnotes = $("#personalization").val();

    cartData.qty = $("#producQty").val();

    var url = el.data("url");

    showLoader();

    $.ajax({
      type: "post",
      url: url,
      data: cartData,
    })
      .done(function (res) {
        $(".cart-count").text(res.count);
        $(".cart-product-wrapper").html(res.html);

        $.toast({
          heading: "Success",
          text: "Item successfully added to your cart.",
          showHideTransition: "slide",
          icon: "success",
          loaderBg: "#f96868",
          position: "top-right",
          afterHidden: function () {
            window.location.href = res.back;
          },
        });

        console.log("back", res.back);
        // window.location.href = res.back;
      })
      .always(function () {
        stopLoader();
      })
      .fail(function () {});
  });

  $(document).on("click", ".add-to-cart-remove", function (e) {
    e.preventDefault();
    var el = $(this);
    var cartData = el.attr("data-id");
    var url = el.attr("data-url");
    showLoader();
    $.ajax({
      type: "post",
      url: url,
      data: {
        id: cartData,
      },
    })
      .always(function () {
        stopLoader();
      })
      .done(function (res) {
        $(".cart-count").text(res.count);
        $(".cart-product-wrapper").html(res.html);
        if ($("#checkoutform").length) {
          $("#checkoutform").valid();
        }
      })
      .fail(function () {});
  });

  $(document).on("click", ".add-to-cart-remove-view", function (e) {
    e.preventDefault();
    var el = $(this);

    var cartData = el.attr("data-id");
    var url = el.attr("data-url");
    showLoader();
    $.ajax({
      type: "post",
      url: url,
      data: {
        id: cartData,
      },
    })
      .always(function () {
        stopLoader();
      })
      .done(function (res) {
        if (res.count == 0) {
          var home_route = $("#home_url").val();
          $(".checkout-form-btn").attr("href", home_route);
          $(".checkout-form-btn").text("Go to Home page");
          $("#login-checkout").attr({ href: home_route });
          $("#login-checkout").text("Go to Home page");
        }
        $(".cart-count").text(res.count);
        $("#cart-tbody").html(res.html);
        if ($("#checkoutform").length) {
          $("#checkoutform").valid();
        }
      })
      .fail(function () {});
  });

  $(document).on("change", ".add-to-cart-update-view", function (e, data) {
    var data = $.extend(
      {},
      {
        show: true,
      },
      data
    );

    var el = $(this);
    var url = el.data("url");
    var show = data.show;
    var cartData = JSON.parse(el.attr("data-cart"));
    cartData.qty = el.val();

    showLoader();

    $.ajax({
      type: "post",
      url: url,
      data: cartData,
    })
      .always(function () {
        stopLoader();
      })
      .done(function (res) {
        $(".cart-count").text(res.count);
        $("#cart-tbody").html(res.html);
        if (show) {
          $.toast({
            heading: "Success",
            text: "Item successfully added to your cart.",
            showHideTransition: "slide",
            icon: "success",
            loaderBg: "#f96868",
            position: "top-right",
          });
        }

        $("#checkoutform").valid();
      })
      .always(function () {
        stopLoader();
        $(".pro-qty").append('<a href="#" class="inc qty-btn">+</a>');
        $(".pro-qty").prepend('<a href="#" class= "dec qty-btn">-</a>');
      })
      .fail(function () {});
  });

  function shallowEqual(object1, object2) {
    const keys1 = Object.keys(object1);
    const keys2 = Object.keys(object2);

    if (keys1.length !== keys2.length) {
      return false;
    }

    for (let key of keys1) {
      if (object1[key] !== object2[key]) {
        return false;
      }
    }

    return true;
  }

  //show popup image
  $(document).on("click", ".load-image-popup", function (e) {
    var el = $(this);
    let url = el.data("url");

    // window.loaders.show();

    $.ajax({
      url: url,
    })
      .always(function (respons) {
        $("#load-modal").html("");
      })
      .done(function (respons) {
        $("#load-modal").html(respons.html);
        loadDropZone();
        $("#image-model").modal("toggle");
      })
      .fail(function (respons) {
        var data = respons.responseJSON;
        toast.fire({
          type: "error",
          title: "Error",
          text: data.message
            ? data.message
            : "something went wrong please try again !",
        });
      });
  });

  $(document).on("hidden.bs.modal", "#image-model", function () {
    $(".add-to-cart-update-view").trigger("change", {
      show: false,
    });
    setTimeout(function () {
      window.location.reload();
    }, 3000);
    $("#load-modal").html("");
  });

  $("#checkoutform").validate({
    debug: false,
    ignore: '.select2-search__field,:hidden:not("textarea,.files,.attachment")',
    rules: {},
    errorPlacement: function (error, element) {
      var el = $(element).closest("td").find(".errors");
      console.log(el);
      error.appendTo(el).addClass("text-danger");
    },
    submitHandler: function (e) {
      return true;
    },
  });

  $(document).on("click", ".checkout-form-btn", function (e) {
    e.preventDefault();
    var el = $(this);
    if ($("#checkoutform").valid()) {
      // alert('f');
      window.location.href = el.attr("href");
    }
    return false;
  });
});

function loadDropZone() {
  Dropzone.confirm = function (question, accepted, rejected) {
    message
      .fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      })
      .then((result) => {
        if (result.value) {
          accepted();
        }
      });
  };

  // Dropzone.prototype.defaultOptions = { maxFiles: 10 } ;
  Dropzone.autoDiscover = false;

  var myDropzone = $(".dropzone").dropzone({
    url: $("#product_form").attr("action"),
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": $('[name="_token"]').val(),
    },
    uploadMultiple: true,
    parallelUploads: 1,
    autoProcessQueue: true,
    paramName: "images",
    // maxFilesize: 0.5,
    // maxFiles: attachment,
    previewTemplate: document.querySelector("#preview").innerHTML,
    dictFileTooBig: "File is too big ({{filesize}}MB). Max filesize: 500kb.",
    dictInvalidFileType: "You can't upload files of this type.",
    acceptedFiles: ".jpeg,.jpg",
    addRemoveLinks: true,
    dictRemoveFileConfirmation: true,
    init: function () {
      var _this = this;

      $("#save_exit").attr("disabled", true);
      $("#save_add_variant").removeClass("disabled");

      if (!jQuery.isEmptyObject(mokup)) {
        $.each(mokup, function (index, mockFile) {
          _this.emit("addedfile", mockFile, mockFile.image);
          _this.createThumbnailFromUrl(
            mockFile,
            _this.options.thumbnailWidth,
            _this.options.thumbnailHeight,
            _this.options.thumbnailMethod,
            true,
            function (thumbnail) {
              _this.emit("thumbnail", mockFile, thumbnail);
            }
          );
          _this.emit("success", mockFile);
          _this.emit("complete", mockFile);
          _this.files.push(mockFile);
        });
      }

      this.on("error", function (file, error, obj) {
        // I GET HERE WHEN USER CLICK ON "CANCEL"
        if (jQuery.isEmptyObject(obj)) {
          // $.unblockUI;
          _this.removeFile(file);
        }
      });

      this.on("addedfile", function (file, dataUrl) {
        $("#save_exit").attr("disabled", false);
        $("#save_add_variant").addClass("disabled");

        // html template
        var f = file.previewTemplate;

        // create alt input
        $("<input/>", {
          type: "text",
          name: "alt[]",
          class: "d-none",
          "data-uuid": file.upload.uuid,
        }).appendTo(f);
        $("<input/>", {
          type: "text",
          name: "images_id[]",
          class: "d-none",
          value: file.id,
        }).appendTo(f);
        $("<input/>", {
          type: "text",
          name: "file_id[]",
          class: "d-none",
          value: file.upload.uuid,
        }).appendTo(f);
        // add data-id based on current length
        $(f).attr({
          "data-id": _this.getAcceptedFiles().length,
        });
        $(f).find(".fa.fa-eye").attr("data-image", file.dataURL); // preive image link in data attr
      });

      this.on("complete", function (file) {
        console.log("file", file);
        if (
          _this.getQueuedFiles().length == 0 &&
          _this.getUploadingFiles().length == 0 &&
          !file.hasOwnProperty("fromRemove")
        ) {
          $.toast({
            heading: "Success",
            text: "Image uploaded successfully.",
            showHideTransition: "slide",
            icon: "success",
            loaderBg: "#f96868",
            position: "top-right",
            // afterHidden: function () {
            //   $("body #close_img_btn").trigger("click");
            // },
          });
          // setTimeout(function () {
          //   window.location.reload();
          // }, 5000);
        }
      });

      this.on("thumbnail", function (file, dataUrl) {
        var f = file.previewTemplate;

        $(f).find(".fa.fa-eye").attr({
          "data-image": file.dataURL,
          "data-uuid": file.upload.uuid,
        });
      });

      this.on("removedfile", function (file) {
        //reindex data-id
        if (file.upload.progress != 100) {
          $("input[data-uuid=" + file.upload.uuid + "]").remove();
          file.fromRemove = true;
          _this.emit("complete", file);
          return true;
        }

        var data = {
          id: file.upload.id,
          date: new Date(),
        };

        // loaderss.showLoader();

        $.ajax({
          type: "POST",
          url: $("#shortable").data("remove-url"),
          data: {
            id: file.upload.id,
            date: new Date(),
          },
        })
          .always(function (res) {
            // loaderss.stopLoader();
          })
          .done(function (res) {
            $.toast({
              heading: "Success",
              text: "Image deleted successfully.",
              showHideTransition: "slide",
              icon: "success",
              loaderBg: "#f96868",
              position: "top-right",
              afterHidden: function () {
                file.fromRemove = true;
                _this.emit("complete", file);
              },
            });
            // setTimeout(function () {
            //   window.location.reload();
            // }, 5000);

            // toast.fire({
            //     title: 'Success',
            //     text: "Image remove successfully.",
            //     type: 'success',
            // }).then(function () {
            //     _this.emit('complete', file);
            // });
          })
          .fail(function (res) {
            var res = res.responseJSON;

            $.toast({
              heading: "Success",
              text: res.message
                ? res.message
                : "something went wrong please try again..",
              showHideTransition: "slide",
              icon: "success",
              loaderBg: "#f96868",
              position: "top-right",
              afterHidden: function () {
                file.fromRemove = true;
                _this.emit("complete", file);
                location.reload();
              },
            });

            // toast.fire({
            //     title: 'Error',
            //     text: res.message ? res.message : "something went wrong please try again..",
            //     type: 'error',
            // }).then(function () {
            //     _this.emit('complete', file);
            //     location.reload();
            // });
          });
      });

      this.on("sendingmultiple", function (file, xhr, formData) {
        // Append all form inputs to the formData Dropzone will POST
        console.log(file);

        var data = $("#product_form").serializeArray();

        // fore new upload file
        $.each(file, function (key, fi) {
          formData.append("uuid[]", fi.upload.uuid);
        });

        $.each(data, function (key, el) {
          formData.append(el.name, el.value);
        });
      });
    },
    success: function (file) {
      // loaderss.stopLoader();
      // create alt input
      var f = file.previewTemplate;

      if (file.id) {
        file.upload.progress = 100;
        file.upload.id = file.id;

        $("<input/>", {
          type: "text",
          name: "alt[]",
          class: "d-none",
          "data-uuid": file.upload.uuid,
          value: file.alt,
        }).appendTo(f);
        $("<input/>", {
          type: "text",
          name: "images_id[]",
          class: "d-none",
          value: file.id,
        }).appendTo(f);
        $("<input/>", {
          type: "text",
          name: "file_id[]",
          class: "d-none",
          value: file.upload.uuid,
        }).appendTo(f);
        // add data-id based on current length
        $(f).attr({
          "data-id": file.position,
        });

        $(f).find(".fa.fa-eye").attr({
          "data-image": file.image,
          "data-uuid": file.upload.uuid,
        });
      }
    },
    successmultiple: function (file, done, obj) {
      // loaderss.stopLoader();

      if (done.success == true) {
        if (done.files.length > 0) {
          $.each(done.files, function (index, val) {
            var el = $("#shortable")
              .find("[data-uuid='" + val.uuid + "']")
              .next("input");
            el.val(val.image_id);
            console.log(el.val(val.image_id));
            file[index].upload.is_delete = true;
            file[index].upload.image_id = val.image_id;
            file[index].upload.id = val.image_id;
          });
        }
      }

      // create alt input
    },
    errormultiple: function (file, error, obj) {
      // loaderss.stopLoader();
      console.log(file, error, obj);

      if (!jQuery.isEmptyObject(obj)) {
        messages = getServerErrorMessage(error);
        $("#ajax-message-form").html("").append(messages);
        this.removeAllFiles(true);
        // $.unblockUI();
      }
    },
  });
}

function getServerErrorMessage(data) {
  var error_message = " ";
  // get error as a string
  if (data.errors) {
    error_message = $.map(data.errors, function (elementOrValue, indexOrKey) {
      return elementOrValue[0];
    }).join("<br>");
  }

  var messages =
    '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <strong>' +
    data.message +
    "</strong> <div>" +
    error_message +
    "</div> </div>";
  return messages;
}
