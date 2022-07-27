$(document).ready(function () {

    $('.coupon-btn').on('click', function (e) {
        const el = $(this);
        const url = el.data('url');
        const coupon_code = $('#coupon_code').val();
        if (!coupon_code) {
            toast.fire({
                icon: 'error',
                title: 'Please apply a coupon code.'
            });
            return;
        }
        let newUlr = url + '?discount_code=' + coupon_code;
        $('.checkout-payment-method').find(':input').removeAttr('data-rule-required',false);

        if($('#checkout').valid()) {
            $('#checkout').attr('action',newUlr);
            $('#checkout').submit();
        }else{
            $('.checkout-payment-method').find(':input').attr('data-rule-required',true);
        }
        // window.location.href = newUlr
    });

    $('.remove-coupon-btn').on('click', function (e) {
        const el = $(this);
        const url = el.data('url');
        const coupon_code = $('#coupon_code').val();
        window.location.href = url;
    });

    $('#checkout').validate({
        debug: false,
        ignore: '.nice-select-search,.select2-search__field,:hidden:not("textarea,.files,.radio,#state,#billing_state")',
        rules: {
            billing_state: {
                required: function (element) {
                    return $("#different_billing_address").is(":checked");
                }
            }
        },
        errorPlacement: function (error, element) {
            console.log(error, element, $(element).hasClass('.radio'));
            if ($(element).hasClass('radio')) {
                error.appendTo($('.checkout-radio-error')).addClass('text-danger');
            } else if ($(element).is('#state')) {
                error.appendTo($('.select-state').html('')).addClass('text-danger');
            } else if ($(element).is('#billing_state')) {
                error.appendTo($('.billing-select-state').html('')).addClass('text-danger');
            }
            else {
                error.appendTo(element.parent()).addClass('text-danger');
            }
        },
        submitHandler: function (e) {
            return true;
        }
    });

});
