
$(document).ready(function () {

    const url = $('#name').attr('data-url');

    categorySelect2 = $('.category-select2');
    categorySelect2.select2({
        allowClear: true,
        ajax: {
            url: categorySelect2.data('url'),
            data: function (params) {
                return {
                    search: params.term,
                    id: $(categorySelect2.data('target')).val()
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
            cache: true,
            delay: 250
        },
        placeholder: 'Select Category',
        theme: 'bootstrap4'
        // minimumInputLength: 1,
    });
    categorySelect2.on('select2:select', function (e) {
        var el = $(this);
        subCategorySelect2.val(null).trigger('change');
    })

    $('#categoriesForm').validate({
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
        rules: {
            name: {
                required: true,
                remote: {
                    url: url,
                    data: {
                        id : function (el) {
                            return $('#name').attr('data-id');
                        },
                        category_id : function () {
                            return $('.category-select2').val();
                        }
                    }
                }
            }
        },
        errorPlacement: function (error, element) {
            // $(element).addClass('is-invalid')
            error.appendTo(element.parent()).addClass('text-danger');
        }
    });

});