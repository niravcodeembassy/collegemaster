
var list = document.getElementById('shortable');
var loaderss  = {
    showLoader : function() {
        loaders.show();
    } ,
    stopLoader : function() {
        loaders.hide();
    }
}


// var shortimageList = new Sortable(list, {
//     draggable: ".dz-preview.previewImge.dz-image-preview", // Specifies which items inside the element should be draggable
//     dataIdAttr: 'data-id',
//     ghostClass: '.message.dropzone.dz-clickable.dz-started',
// });


Dropzone.confirm = function (question, accepted, rejected) {
    console.log(question);
    message.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            accepted();
        }else {
            rejected()
        }
    });
};

// Dropzone.prototype.defaultOptions = { maxFiles: 10 } ;
Dropzone.autoDiscover = false;

var myDropzone = $('.dropzone').dropzone({
    url: $('#product_form').attr('action'),
    method : 'POST' ,
    headers: {
        "X-CSRF-TOKEN": $('[name="_token"]').val()
    },
    uploadMultiple: true,
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    parallelUploads: 20,
    autoProcessQueue: false,
    paramName: 'images',
    maxFilesize: 3,
    maxFiles : 20 ,
    previewTemplate: document.querySelector('#preview').innerHTML,
    dictFileTooBig: "File is too big ({{filesize}}MB). Max filesize: 3MB.",
    dictInvalidFileType: "You can't upload files of this type.",
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    addRemoveLinks: true,
    dictRemoveFileConfirmation: true,
    init: function () {
        var _this = this;

        $('#save_exit').attr("disabled", true);
        $('#save_add_variant').removeClass("disabled");


        if (!jQuery.isEmptyObject(mokup)) {

            $.each(mokup ,function (index , mockFile) {
                _this.emit("addedfile", mockFile, mockFile.image);
                _this.createThumbnailFromUrl(mockFile, _this.options.thumbnailWidth, _this.options.thumbnailHeight,
                    _this.options.thumbnailMethod, true, function (thumbnail) {
                        _this.emit('thumbnail', mockFile, thumbnail);
                    });
                _this.emit("success", mockFile);
                _this.emit("complete", mockFile);
                _this.files.push(mockFile);
            });

        }

        this.on("error", function (file, error, obj) {
            // I GET HERE WHEN USER CLICK ON "CANCEL"
            if (jQuery.isEmptyObject(obj)) {
                message.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: error,
                });
                // $.unblockUI;
                _this.removeFile(file)
            }

        })

        this.on('addedfile', function (file, dataUrl) {

            $('#save_exit').attr("disabled", false);
            $('#save_add_variant').addClass("disabled");



            // html template
            var f = file.previewTemplate;

            // create alt input
            $('<input/>', { type: 'text',name: 'alt[]', class: 'd-none','data-uuid': file.upload.uuid }).appendTo(f);
            $('<input/>', { type: 'text', name: 'images_id[]', class: 'd-none', value: file.id}).appendTo(f);
            $('<input/>', { type: 'text', name: 'file_id[]', class: 'd-none', value: file.upload.uuid}).appendTo(f);
            // add data-id based on current length
            $(f).attr({'data-id': _this.getAcceptedFiles().length });
            $(f).find('.fa.fa-eye').attr('data-image', file.dataURL); // preive image link in data attr



        });

        this.on("complete", function() {
            if (_this.getQueuedFiles().length == 0 &&  _this.getUploadingFiles().length == 0) {
                $('#save_exit').attr("disabled", true);
                $('#save_add_variant').removeClass("disabled");

            }else {
                $('#save_exit').attr("disabled", false);
                $('#save_add_variant').addClass("disabled");
            }
        });

        this.on('thumbnail', function (file, dataUrl) {

            var f = file.previewTemplate;

            $(f).find('.fa.fa-eye').attr({
                'data-image': file.dataURL,
                'data-uuid': file.upload.uuid
            });

        })

        this.on('removedfile', function (file) {
            //reindex data-id
            if (file.upload.progress != 100 ) {
                $('input[data-uuid=' + file.upload.uuid + ']').remove();
                _this.emit('complete',file);
                return true;
            }

            var data = {
                id: file.upload.id,
                date : new Date()
            }

            loaderss.showLoader();

            $.ajax({
                type: "POST",
                url: $('#shortable').data('remove-url'),
                data: {
                    id: file.upload.id,
                    date : new Date()
                }
            }).always(function(res){
                loaderss.stopLoader();
            })
            .done(function (res) {
                message.fire({
                    title: 'Success',
                    text: "Image remove successfully.",
                    type: 'success',
                }).then(function(){
                    console.log($("#shortable"));
                    $("#shortable").trigger('sortupdate');
                    _this.emit('complete',file);
                });
            }).fail(function (res) {

                var res = res.responseJSON ;

                message.fire({
                    title: 'Error',
                    text:  res.message ? res.message :"something went wrong please try again..",
                    type: 'error',
                }).then(function(){
                    $("#shortable").trigger('sortupdate');
                    _this.emit('complete',file);
                    location.reload();
                });
            });

        });

        this.on('sendingmultiple', function (file, xhr, formData) {
            // Append all form inputs to the formData Dropzone will POST
            console.log(file);

            var data = $('#product_form').serializeArray();

            // fore new upload file
            $.each(file, function (key, fi) {
                formData.append('uuid[]', fi.upload.uuid);
            });

            $.each(data, function (key, el) {
                formData.append(el.name, el.value);
            });

        });

        $('#product_form').on('submit', function (e) {
            e.preventDefault();
            loaderss.showLoader();
            _this.processQueue();
        });


    },
    success : function(file) {
        console.log(file);

        loaderss.stopLoader();
        // create alt input
        var f = file.previewTemplate;

        if (file.id) {

            file.upload.progress = 100 ;
            file.upload.id = file.id ;

            $('<input/>', {type: 'text', name: 'alt[]', class: 'd-none', 'data-uuid': file.upload.uuid , value: file.alt }).appendTo(f);
            $('<input/>', {type: 'text', name: 'images_id[]', class: 'd-none', value: file.id}).appendTo(f);
            $('<input/>', {type: 'text', name: 'file_id[]', class: 'd-none', value: file.upload.uuid}).appendTo(f);
            // add data-id based on current length
            $(f).attr({'data-id': file.position});

            $(f).find('.fa.fa-eye').attr({
                'data-image': file.image,
                'data-uuid': file.upload.uuid
            });

        }

    } ,
    successmultiple: function (file, done , obj) {

        loaderss.stopLoader();

        if(done.success == true) {

            if(done.files.length > 0) {
                $.each(done.files ,function (index, val) {
                    var el = $('#shortable').find("[data-uuid='" + val.uuid + "']").next('input');
                    el.val(val.image_id);
                    console.log(  el.val(val.image_id));
                    file[index].upload.is_delete = true ;
                    file[index].upload.image_id = val.image_id ;
                    file[index].upload.id = val.image_id ;
                });
            }

            message.fire({
                title: 'Success',
                text: "Image upload successfully.",
                type: 'success',
            }).then(function(){
                $("#shortable").trigger('sortupdate');
            });



        }

        // create alt input
    },
    errormultiple: function (file, error, obj) {

        loaderss.stopLoader();

        if (!jQuery.isEmptyObject(obj)) {
            messages = getServerErrorMessage(error);
            $('#ajax-message-form').html('').append(messages);
            this.removeAllFiles(true);
            // $.unblockUI();
            $('#save_product').removeAttr('disabled');
            $('#save_add_variant').removeClass("disabled");

        }
    }

});

$(document).ready(function () {

    $("#shortable").sortable();

    $( "#shortable").on( "sortupdate", function( event, ui ) {
        $( this ).sortable( "refreshPositions" );

        var data = $(':input' , this).serializeArray();
        data.push({ name : 'date' , value : new Date() }) ;
        $.ajax({
            type: "POST",
            url: $('#shortable').data('position-url'),
            data: data
        }).done(function (res) {
            console.log(res);
        }).fail(function (res) {
            message.fire({
                title: 'Error',
                text: "something went wrong please try again.",
                type: 'error',
            });
        });
    });


    $('#show_image').on('show.bs.modal', function (event) {
        var el = $(event.relatedTarget) // Button that triggered the modal
        var img_url = el.attr('data-image');
        $('#sho-img').attr('src', img_url);
    });

    $(document).on('showBsModal', '#modal-alt-id', function (e, ObjData) {
        var el = $(e.relatedTarget) // Button that triggered the modal
        var curentAlt = $('input[data-uuid=' + ObjData.uuid + ']');
        $('#show-image').attr('src', ObjData.src);
        $('#alt_image').val(ObjData.alt);
        $('#alt_image_id').val(ObjData.id);
        $('#alt_image').attr('data-alt-uuid', ObjData.uuid);
        curentAlt.trigger('input');
        $('#modal-alt-id').modal('show');
    });

    $(document).on('click', '.btn-alt', function (e) {
        var $el = $(this);
        var $prev = $el.prev('span')
        var image = $prev.attr('data-image');
        var uuidEl = $prev.attr('data-uuid');
        var altel = $('input[data-uuid=' + uuidEl + ']');
        var alt = altel.val();
        var id = $(altel).next().val();
        console.log(id);
        var data = {
            src: image,
            alt: alt,
            uuid: uuidEl,
            id: id
        }
        $('#modal-alt-id').trigger('showBsModal', data);
    });

    $('#modal-alt-id').on('hidden.bs.modal', function (e) {
        var modal = $('#modal-alt-id');
        var data = $(':input', modal).val(null);
    })

    $('#alt_image').on('input propertychange paste', function (e) {
        var el = $(this);
        var uuid = el.attr('data-alt-uuid');
        // console.log($('input[data-uuid='+uuid+']'));
        $('input[data-uuid=' + uuid + ']').val(el.val());
    });


    $('#save_image_alt').click(function(e){

        var modal = $('#modal-alt-id');
        var data = $(':input', modal).serializeArray();
        var imageIdExist = $("#alt_image_id").val();

        if(!imageIdExist){
            $('#modal-alt-id').modal('toggle');
            return true ;
        }

        $.ajax({
            type: "POST",
            url: $('#save_image_alt').data('action'),
            data: data
        }).always(function(){
            $('#modal-alt-id').modal('toggle');
        })
        .fail(function(res){
            message.fire({
                title: 'Error',
                text: "something went wrong please try again.",
                type: 'error',
            });
        });

    });




});

function getServerErrorMessage(data) {
    var error_message = ' ';
    // get error as a string
    if (data.errors) {
        error_message = $.map(data.errors, function (elementOrValue, indexOrKey) {
            return elementOrValue[0];
        }).join('<br>');
    }

    var messages = '<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <strong>' + data.message + '</strong> <div>' + error_message + '</div> </div>';
    return messages;
}
