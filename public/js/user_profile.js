// Active Tab

$(function() {

    if($('#id').length == 1) {
         return true ;
    }

    //    $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
    //      localStorage.setItem('lastTab', $(this).attr('href'));
    //    });
    //    var lastTab = localStorage.getItem('lastTab');

    //    if (lastTab ) {
    //      $('[href="' + lastTab + '"]').tab('show');
    //    }

 });

 // Profile Validation
 $(document).ready(function () {

      var $uploadCrop;

         function readFile(input) {
             if (input.files && input.files[0]) {

                 var reader = new FileReader();

                 reader.onload = function (e) {
                     $('.upload-demo').addClass('ready');
                     $uploadCrop.croppie('bind', {
                         url: e.target.result,
                     }).then(function(){
                         // $('#profile_modal').modal('show');
                     });

                 }
                 reader.readAsDataURL(input.files[0]);
             }
             else {

                 swal("Sorry - you're browser doesn't support the FileReader API");
             }
         }

         $uploadCrop = $('#upload-demo').croppie({
             viewport: {
                 width: 200,
                 height: 200,
                 type: 'circle'
             },  boundary: {
                 width: 300,
                 height: 300
             } ,
             enableExif: true,
         });

         $('#uplode_btn').on('change', function () {
             $('#profile_modal').modal('show');
         });

         $('#profile_modal').on('shown.bs.modal', function(){
             var input = $('#uplode_btn').get(0) ;
             readFile(input);
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
                         data: {image: resp,
                             _token: function () {
                                 return window.Laravel.csrfToken;
                             }},
                     }).done(function (res) {
                         console.log(res);
                         $('img.avatar ,#showcropimg').attr('src',res.image_url);

                         message.fire({
                             type : 'success' ,
                             text : 'Image has been updated successfully.' ,
                         })

                         // swal("Success",res.message);
                     }).always(function (res) {

                         $('#profile_modal').modal('hide');
                         $('#profile_modal').modal('hide');
                         $('#imgSrcInput').remove();

                     }).fail(function (res) {
                         if($(document).is('input[name="_method"]')) {
                             swal("Sorry - you're browser doesn't support the FileReader API");
                         }else{
                             $('img.avatar ,#showcropimg').attr('src',resp);
                             $('<input>',{
                                 name : 'imgsrc' ,
                                 id : 'imgSrcInput',
                                 value : resp ,
                                 type : 'hidden'
                             }).prependTo('form');
                         }

                     }) ;

                 console.log(resp);
             });
         });

     $('#update_profile_form').validate({
         debug: false,
         ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
         rules: {
            email : {
                 required: true,
                 remote: {
                     url: $('#update_profile_form').attr('data-url'),
                     type: "post",
                     data: {
                         _token: function () {
                             return window.Laravel.csrfToken;
                         },
                         id: function ()
                         {
                            return $('#update_profile_form').attr('data-id');
                         },
                     }
                 }
            }
         },
         messages: {},
         errorPlacement: function (error, element) {
             error.appendTo(element.parent()).addClass('text-danger');
         },
         submitHandler: function (e) {
             return true;
         }
     })

    $('#change_password_form').validate({
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
        rules: {
             old_password: {
                 required: true,
                 remote: {
                     url: $('#change_password_form').attr('data-url'),
                     type: "post",
                     data: {
                         _token: function () {
                             return window.Laravel.csrfToken;
                         },
                         form_field: function () {
                             return $("#old_password").val();
                         },
                         id: function ()
                         {
                             return $('#change_password_form').attr('data-id');
                         },
                     }
                 }
             },
             new_password: {
                 required: true,
                 minlength: 6,
             },
             comfirm_password: {
                 required: true,
                 equalTo:"#new_password"
             }
         },
         messages: {
             old_password: {
                remote:"Old Password does not match",
             }
         },
         errorPlacement: function (error, element) {
             // $(element).addClass('is-invalid')
             error.appendTo(element.parent()).addClass('text-danger');
         },
         submitHandler: function (e) {
             return true;
         }
     });

     //  $('#change_password_form').validate({
     //     debug: false,
     //     ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
     //     rules: {
     //         old_password: {
     //             required: true,
     //             remote: {
     //                 url: $('#change_password_form').attr('data-url'),
     //                 type: "post",
     //                 data: {
     //                     _token: function () {
     //                         return window.Laravel.csrfToken;
     //                     },
     //                     id: function ()
     //                     {
     //                         return $('#change_password_form').attr('data-id');
     //                     },
     //                 }
     //             }
     //         },
     //         new_password: {
     //             required: true,
     //             minlength: 6,
     //         },
     //         comfirm_password: {
     //             required: true,
     //             equalTo:"#new_password"
     //         }
     //     },
     //     messages: {
     //         old_password: {
     //            remote:"Old Password does not match",
     //         }
     //     },
     //     errorPlacement: function (error, element) {
     //         // $(element).addClass('is-invalid')
     //         error.appendTo(element.parent()).addClass('text-danger');
     //     },
     //     submitHandler: function (e) {
     //         return true;
     //     }
     // });



 });
