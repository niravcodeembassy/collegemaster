$(document).ready(function () {

    var $uploadCrop;

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $uploadCrop.croppie('bind', {
                    url: e.target.result,
                }).then(function () {
                    // $('#profile_modal').modal('show');
                });
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        boundary: {
            width: 300,
            height: 300
        },
        enableExif: true,
    });

    $('#uplode_btn').on('change', function () {
        $('#profile_modal').modal('show');
    });

    $('#profile_modal').on('shown.bs.modal', function () {
        var input = $('#uplode_btn').get(0);
        readFile(input);
    });

    $('.role-select-2').select2({
        placeholder: 'Search Role',
        allowClear: true
    });

    $('.upload-result').on('click', function (ev) {

        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport',
            format: 'base64'
        }).then(function (resp) {

            $.ajax({
                type: "post",
                url: $('#profile_url').val(),
                data: {
                    image: resp,
                    _token: function () {
                        return window.Laravel.csrfToken;
                    }
                },
            }).done(function (res) {
                console.log(res);
                $('img.avatar ,#showcropimg').attr('src', res.image_url);

                message.fire({
                    type: 'success',
                    text: 'Image has been updated successfully.',
                })

                // swal("Success",res.message);
            }).always(function (res) {

                $('#profile_modal').modal('hide');
                $('#profile_modal').modal('hide');
                $('#imgSrcInput').remove();

            }).fail(function (res) {
                if ($(document).is('input[name="_method"]')) {
                    swal("Sorry - you're browser doesn't support the FileReader API");
                } else {
                    $('img.avatar ,#showcropimg').attr('src', resp);
                    $('<input>', {
                        name: 'imgsrc',
                        id: 'imgSrcInput',
                        value: resp,
                        type: 'hidden'
                    }).prependTo('form');
                }

            });

        });

    });

});
