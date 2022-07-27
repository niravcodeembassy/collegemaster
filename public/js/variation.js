jQuery.validator.addClassRules("required", {
    required: true,
});
$.pluck = function (arr, key) {
    return $.map(arr, function (e) { return e[key]; })
}
$.only = function (arr) {
    return $.map(arr, function (e) { return {
        'id' : e.id,
        'text': e.text,
    } })
}

$(document).ready(function () {

   

    $(document).on('show.bs.modal' ,function (e) {

        var el = $(this);
        var clickEl = $(e.relatedTarget);
        var inputId = clickEl.next();
        $('#my-modal').attr('data-target','#'+inputId.attr('id')); 
     

        $('.modal-body').find('i').addClass('hidden');
        $('.modal-body').parents().find('.b-success').removeClass('b-success');

        if(inputId.val()) {
            $('img[data-id="'+ inputId.val() +'"]').trigger('click');
        }

    });

    $(document).on('hide.bs.modal' , function(e){
        $('#my-modal').removeAttr('data-target');
    });

    
    $(document).on('click' ,'.select-img' ,function (e) {

        var el = $(this);
        
        var target = $('#my-modal').attr('data-target');
        console.log(target);
        $('.modal-body').find('i').addClass('d-none');
        el.parents().find('.b-success').removeClass('b-success');
        el.prev().removeClass('d-none');
        el.addClass('b-success');
        $(target).val(el.data('id'));
        $(target).prev('img').attr('src' ,el.attr('src'));
        $(target).closest('.show-img').find('img').attr('src' ,el.attr('src'));
        console.log($(target).closest('.show-img'));
        

    });


    $(document).on("select2:select select2:unselect	select2:clear change", '.variants_tags', function (e) {
        var el = e.target;
        var list = null;
        var table = $('.variants_body');
        var select2List = $('.repeter-list .variants_tags');
        console.log($(e.currentTarget).select2('data'));

        // get all input values 
        var inputs = $.map(select2List, function (item, index) {
            var data = $(item).select2('data');
            console.log(data);
            if (data.length > 0) {
                return [$.only(data)];
            }
        });

        clearVariantsTable(table);
        table.closest('.card.table-card ').addClass('hidden')

        if (inputs.length > 0) {
            list = cartesian(inputs);
            table.closest('.card.table-card ').removeClass('hidden');
        }

        if (list === null) {
            return false
        }

        var allInput = $('#varinats_table').find('.required');

        html = $.map(list, function (last_item, indexs) {

            var html = $('#varinats_table').clone();

            var allInput = $(html).find('.required');

            allInput.map(function (index , el) {                 
                $(el).attr({ 'id' : $(el).data('id')+'_'+indexs });             
            });

            var diplytext = last_item.map(function(val , index){
                return '<span class="badge text-capitalize mb-1">'+val.text+'</span>' ;
            }).join('&nbsp;') ;
            
            html.find('.variants_name').html('').html('<b>' + diplytext + '</b>').next(':input')
                .val($.pluck(last_item, 'id').join(','));
            
            return html.find('tbody').html();


        }).join('\n');
        
        $('.variants_body').append(html);
           
    });

    // repeater 
    $('.repeater').repeater({
        show: function () {
            getselectTo('.variants_tags');
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement());
                $(document).find('.variants_tags').trigger('select2:clear');
            }   
        },
        ready: function () {
            getselectTo('.variants_tags');
        },
        isFirstItemUndeletable: true
    })

    $(document).on('change', '.variants_body input[name="is_variants[]"]', function (event) {       
        console.log( $(this).closest('td').find('input.variants_on_off')); 
             $(this).closest('td').find('input.variants_on_off').val('off');
        if (this.checked) {
            $(this).closest('td').find('input.variants_on_off').val('on');
        }
    });

    $(document).on('click','.remove-row' ,function(e){
        $(this).closest('tr').remove();
    });

    $(document).on('click', '.remove-variant-delete', function (event) {
        
        var el = $(this);
        var url = $(this).data('route');
        $.ajax({
            type: "GET",
            url: url
        }).done(function (result) {
            el.closest('tr').remove();
            success_massage(result.message);
            location.reload();
        }).fail(function (result) {
            data = result.responseJSON;
            error_massage(data.message)
        }).always(function (res) {
            $.unblockUI();
        });

    });

    $('form').on('submit' , function(){
        $("table :input").each(function() {
            if (this.value=="") {                
                $(this).addClass('border-danger');                
            }else{
                $(this).removeClass('border-danger');
            }  
        });
    });


    $('#variation_form').validate({
        debug: false ,
        // ignore: [''],
        ignore: '.select2-search__field,:hidden:not("textarea,.files,select,variants_name")',
        rules: {
            'variant_price[]' : {
                required : true
            }
        },
        errorPlacement: function (error, element) {            
            console.log(error, element);
            error.appendTo(element.parent()).addClass('text-danger');
        },
        submitHandler: function (e) {
            console.log($("#variation_form :input"));
            return true;
        }   
    });

    function getselectTo(param) {
        $(param).select2({
            theme: 'bootstrap4',
            ajax: {
                url: function () {
                    return $(this).data('url')
                },
                data: function (params) {
                    let target = $(this).data('target');
                    let val = $(this).closest('.repeter-list').find(target).val();
                    return {
                        search: params.term,
                        id: val
                    };
                },
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data.data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.name,
                                otherfield: item,
                            };
                        }),
                    }
                },
            },
            allowClear: true,
        });
        $('.optionnameselect2').select2({
            theme: 'bootstrap4',
            ajax: {
                url: function () {
                    return $(this).data('url')
                },
                data: function (params) {
                    return {
                        search: params.term,
                    };
                },
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data.data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.name,
                                otherfield: item,
                            };
                        }),
                    }
                },
            },
            allowClear: true,
        })
    }
    getselectTo('.variants_tags');

    function clearVariantsTable(table) {
        table.closest('table').addClass('hide'); // create table when add new data
        table.html('');
    }

    function cartesian(arg) {
        var r = [],  max = arg.length - 1;
        function helper(arr, i) {
            for (var j = 0, l = arg[i].length; j < l; j++) {
                var a = arr.slice(0); // clone arr
                a.push(arg[i][j]);
                if (i == max){
                    r.push(a);
                }else{
                    helper(a, i + 1);
                }
                    
            }
        }
        helper([], 0);
        return r;
    }
    
});

