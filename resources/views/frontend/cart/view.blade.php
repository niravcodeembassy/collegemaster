@extends('frontend.layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <div class="breadcrumb-area   pt-20 pb-20 mb-100" style="background-color: #f5f5f5;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="breadcrumb-title">Cart</h1>

                    <!--=======  breadcrumb list  =======-->

                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-list__item"><a href="{{ route('front.home') }}">HOME</a></li>
                        <li class="breadcrumb-list__item breadcrumb-list__item--active">Cart</li>
                    </ul>

                    <!--=======  End of breadcrumb list  =======-->

                </div>
            </div>
        </div>
    </div>
    <form id="checkoutform" name="checkoutform">
        <div class="shopping-cart-area mb-130">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-30">
                        <!--=======  cart table  =======-->
                        <div class="cart-table-container">
                            <table class="cart-table w-100 table" style="border: 1px solid #e7e7e7;">
                                <thead>
                                    <tr>
                                        <th class=" px-3 py-3" colspan="2">Product</th>
                                        <th class="product-name px-3 py-3"></th>
                                        <th class="product-price px-3 py-3">Price</th>
                                        <th class="product-quantity px-3 text-center">Quantity</th>
                                        <th class="product-subtotal px-3 text-center" width="15%">Attachment</th>
                                        <th class="product-subtotal px-3">Total</th>
                                        <th class="product-remove px-3 py-3">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-tbody">
                                    @include('frontend.cart.tbody', ['cartList' => $cartList])
                                </tbody>
                            </table>
                        </div>
                        <!--=======  End of cart table  =======-->
                    </div>
                    <div class="col-lg-6 offset-6 text-left text-lg-right">
                        <input type="hidden" id="home_url" value="{{ route('front.home') }}">
                        @if (count($cartList) == 0)
                            <a href="{{ route('front.home') }}" class="lezada-button home-form-btn lezada-button--medium">Go
                                to Home page</a>
                        @else
                            @auth
                                <a class="lezada-button checkout-form-btn lezada-button--medium" href="javascript:void(0)"
                                    data-cartlist="{{ json_encode($cartList) }}" data-url="{{ route('cart.gift') }}">Check
                                    Out</a>
                            @else
                                <a href="{{ route('login') }}" class="lezada-button lezada-button--medium"
                                    id="login-checkout">Check Out</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id="image-model" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-body" id="load-modal">

                </div>
                <div class="modal-footer">
                    <a name="" id="close_img_btn" class="lezada-button" href="#" data-dismiss="modal"
                        role="button">Close</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        a.lezada-button {
            padding: 5px 25px;
        }

        .table thead th {
            border-bottom: none;
        }

        .cart-table tr {
            /* border-bottom: 1px solid #ededed; */
            border-bottom: none;
        }

        #my-dropzone .message {
            font-family: "Segoe UI Light", "Arial", serif;
            font-weight: 600;
            color: #0087F7;
            font-size: 1.5em;
            letter-spacing: 0.05em;
        }

        .dropzone {
            border: 2px dashed #0087F7;
            background: white;
            border-radius: 5PX;
            min-height: 100px;
            padding: 10px 0;
            vertical-align: baseline;
        }

        .dropzone .dz-preview:hover .dz-details {
            bottom: 0;
            background: rgba(0, 0, 0, 0.5) !important;
            padding: 20px 0 0 0;
            cursor: move;
        }

        .dz-image {
            width: 150px;
            height: 150px;
        }

        .font-btn {
            color: white;
            font-size: 15px;
            position: relative;
            bottom: -25px;
            padding: 4px;
            /* text-align: center; */
            cursor: pointer !important;
        }

        .dz-remove {
            display: none !important;
        }

        /* switch toggle */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 25px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 17px;
            width: 17px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }


        input:checked+.slider {
            background-color: #252525
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #252525
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        p.gift_slip {
            padding-left: 60px;
            color: #ababab;
            line-height: 0px;
        }

        .gift_message label {
            padding-left: 0px;
        }

        .switch_second {
            margin-right: 0.5rem !important;
        }

        /* media query */
        @media only screen and (max-width: 480px) {
            p.gift_slip {
                padding-left: 0px;
                line-height: 20px;
            }

            .mr-2 {
                margin-right: 1.5rem !important;
            }
        }
    </style>
@endpush

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
@endpush
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
@endpush
@push('script')
    <script>
        $(document).ready(function(e) {
            // $(".enable_gift").each(function(list, item) {
            //   let check_id = $(item).attr('id');
            //   $('#' + check_id).change(function(e) {
            //     if ($(this).is(":checked")) {
            //       $(this).val('Yes');
            //       $(this).parent().parent().next().removeClass('d-none');
            //     } else {
            //       $(this).val('No');
            //       $(this).parent().parent().next().removeClass('d-block').addClass('d-none');
            //       $(this).parent().parent().next().find('textarea').val('');
            //       $(this).parent().parent().next().find('.gift_message').addClass('d-none');
            //       $(this).parent().parent().next().find('input[type="checkbox"]').prop('checked', false)
            //     }
            //   });
            // });

            // $(".enable_message").each(function(list, item) {
            //   let check_id = $(item).attr('id');
            //   $('#' + check_id).change(function(e) {
            //     if ($(this).is(":checked")) {
            //       $(this).val('Yes');
            //       $(this).parent().parent().children('.gift_message').removeClass('d-none');
            //     } else {
            //       $(this).val('No');
            //       $(this).parent().children('.gift_message_content').addClass('d-none');
            //       $(this).parent().children('.gift_message_content').find('textarea').val('');
            //     }
            //   });
            // });

            $(".enable_gift").each(function(list, item) {
                let check_id = $(item).attr('id');
                $(document.body).on('change', '#' + check_id, function() {
                    if ($(this).is(":checked")) {
                        $(this).val('Yes');
                        $(this).parent().parent().next().removeClass('d-none').addClass(
                            'd-block')
                    } else {
                        $(this).val('No');
                        $(this).parent().parent().next().removeClass('d-block')
                            .addClass('d-none');
                        $(this).parent().parent().next().find('textarea').val('');
                    }
                });
            });

            $(document).on("click", ".checkout-form-btn", function(event, data) {
                var el = data || $(this);

                var cartlist = JSON.parse(el.attr("data-cartlist"));
                var url = $(this).data("url");

                var c = [];
                $(".cart-table tbody tr.gift_message_area").each(function() {
                    var cart_id = $(this).find(".cart_id").val();
                    var enable_gift = $(this).find(".enable_gift").val();
                    var enable_message = $(this).find(".enable_message").val();
                    var order_gift_message = $(this).find(".order_gift_message").val();
                    var order_optional_note = $(this).find(".order_optional_note")
                        .val();

                    let obj = {
                        'cart_id': cart_id,
                        'order_has_gift': enable_gift,
                        'order_has_message': enable_message,
                        'gift_message': order_gift_message,
                        'optional_note': order_optional_note
                    };
                    c.push(obj);
                });
                cartlist.giftContent = c;

                $.ajax({
                    type: "post",
                    url: url,
                    data: {
                        'gift_content': c,
                    },
                }).done(function(res) {
                    window.location.href = res.back;
                }).fail(function(respons) {
                    console.log(respons)
                });
            });
        });
    </script>
@endpush
