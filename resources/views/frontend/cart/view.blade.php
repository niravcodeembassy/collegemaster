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
            <li class="breadcrumb-list__item"><a href="{{ url('/') }}">HOME</a></li>
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
              <a href="{{ route('front.home') }}" class="lezada-button home-form-btn lezada-button--medium">Go to Home page</a>
            @else
              @auth
                <a href="{{ route('checkout') }}" class="lezada-button checkout-form-btn lezada-button--medium">Check Out</a>
              @else
                <a href="{{ route('login') }}" class="lezada-button lezada-button--medium" id="login-checkout">Check Out</a>
              @endauth
            @endif
          </div>


        </div>
      </div>
    </div>
  </form>
  <div id="image-model" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-body" id="load-modal">

        </div>
        <div class="modal-footer">
          <a name="" id="close_img_btn" class="btn-link" href="#" data-dismiss="modal" role="button">Close</a>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('style')
  <style>
    .table thead th {
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
  </style>
@endpush

@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
@endpush
@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
@endpush
