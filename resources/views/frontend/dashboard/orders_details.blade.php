@extends('frontend.layouts.app')
@section('content')

  @include('frontend.layouts.banner', [
      'pageTitel' => 'INVOICE' ?? '',
  ])
  @php
    $address = json_decode($order->address);
    $shipping = $address->shipping_address;
    // dd($shipping);
    $billing = $address->billing_address;
  @endphp
  <section class="section-b-space mt-60">
    <div class="container ">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8 mb-8">
            <h5 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted"> Order No : {{ $order->order_number }}</span>
              <div>
                <a href="{{ route('order.inv', $order->id) }}" class="text-strong mr-5" style="cursor: pointer;"> <i class="fa fa-print"></i> View Invoice </a>
                <span class="badge  badge-secondary badge-pill">{{ $order->created_at->format('m-d-Y H:i:s') }} (IST)</span>
              </div>
            </h5>
            <ul class="list-group mb-3  b-0">
              @php
                $subTotal = 0;
              @endphp
              @foreach ($order->items as $item)
                @php

                  $attributes = [];
                  $raw_data = [];

                  if ($item->attribute != null) {
                      $attributes = json_decode($item->attribute, true);
                  }
                  if ($item->raw_data != null) {
                      $raw_data = json_decode($item->raw_data, true);
                  }
                  $subTotal += $raw_data['final_price_total'] ?? 0;
                  $qty = $item->qty;

                  $json_data = json_decode($item->raw_data);

                  $image_id = $json_data->image_id;
                  $product_id = $json_data->product_id;
                  $image_url = null;
                  if (isset($image_id)) {
                      $img = App\Model\ProductImage::select('image_url')->find($image_id);
                      if (isset($img->image_url)) {
                          $image_url = asset('storage/' . $img->image_url);
                      } else {
                          $image_url = asset('storage/' . $img->image_url);
                      }
                  } else {
                      $image_url = asset('storage/category/default.png');
                  }
                  $sku = App\Model\Product::select('sku')->find($product_id);

                @endphp
                <li class="list-group-item d-flex justify-content-between lh-condensed order-table">
                  <img src="{{ $image_url }}" title="{{ $item->name }}" alt="{{ $item->name }}" style="width: 160px; height:160px;" class="mr-4">
                  <div class="product-details" style="margin-right: 134px">
                    <h6 class="my-0 f-18 p-name" title="{{ $item->name }}">{{ Str::words($item->name, 10, '...') }}</h6>
                    @if (count($attributes) > 0)
                      <div class="options">
                        @foreach ($attributes as $key => $attribute)
                          <small class="text-muted f-12">{{ strtoupper($key) }} : {{ $attribute }}</small>
                          @if (!$loop->last)
                          @endif
                          @if (!$loop->last)
                            </br>
                          @endif
                        @endforeach
                      </div>
                    @endif

                    <small class="text-muted f-12">SKU : <b>{{ $sku->sku }}</b> </small>
                    <br>
                    <small class="text-muted f-12">QTY : {{ str_replace('.00', ' ', $qty) }} </small>
                    <br>
                    <small class="text-muted f-12">PRICE : {!! Helper::showPrice($raw_data['qty_price'] ?? 0, $order->currency, $order->currency) !!}</small>


                    @if ((isset($raw_data['notes']) && $raw_data['notes'] != '') || (isset($raw_data['order_has_gift']) && isset($raw_data['gift_message']) && $raw_data['gift_message'] != ''))
                      <hr>
                      @if (isset($raw_data['notes']) && $raw_data['notes'] != '')
                        <small class="text-muted" style="margin-top: 5px;"><span class="text-uppercase">Notes</span> : {{ $raw_data['notes'] ?? '' }}</small><br>
                      @endif

                      @if (isset($raw_data['order_has_gift']) && $raw_data['order_has_gift'] == 'Yes')
                        <small class="text-muted" style="margin-top: 3px;"><span class="text-uppercase">Order Has Gift </span> : <span class="mx-2 dot bg-success"></span> Price does not display</small>
                        <br>
                      @endif

                      @if (isset($raw_data['order_has_gift']) && $raw_data['order_has_gift'] == 'No')
                        <small class="text-muted" style="margin-top: 3px;"><span class="text-uppercase">This Order Has Gift :</span><span class="mx-2 dot bg-danger"></span></small>
                        <br>
                      @endif

                      @if (isset($raw_data['gift_message']) && $raw_data['gift_message'] != '')
                        <small class="text-muted" style="margin-top: 3px;"><span class="text-uppercase">Gift Message</span> : {{ $raw_data['gift_message'] ?? '' }}</small>
                        <br>
                      @endif
                      @if (isset($raw_data['optional_note']) && $raw_data['optional_note'] != '')
                        <small class="text-muted" style="margin-top: 3px;"><span class="text-uppercase">Optional Note </span>: {{ $raw_data['optional_note'] ?? '' }}</small>
                        <br>
                      @endif
                    @endif
                  </div>
                  @if (in_array($order->order_status, ['order_placed', 'pick_not_receive', 'work_in_progress', 'correction']) && !$item->images->count() > 0)
                    <div data-url="{{ route('cart.load.popup.ordered', ['item' => $item->id]) }}" class="text-center load-image-popup">
                      @include('svg.upload', ['width' => '30px'])
                    </div>
                  @endif
                  @if ($item->images->count())
                    <div class="d-flex flex-column align-items-center">
                      @include('svg.right', ['width' => '30px'])
                      <span class="text-success text-center" style="font-size: 11px;line-height:initial">
                        you have rich maximum limit of upload
                      </span>
                    </div>
                  @endif
                </li>
              @endforeach
              @if ($order->subtotal)
                <li class="list-group-item d-flex justify-content-between lh-condensed s-total">
                  <div class="offset-7">
                    <h6 class="my-0">Subtotal</h6>
                  </div>
                  <span class="text-muted ">{!! Helper::showPrice($order->subtotal, $order->currency) !!}</span>
                </li>
              @endif

              @if ($order->discount && $order->discount > 0)
                <li class="list-group-item d-flex justify-content-between lh-condensed discount">
                  <div class="offset-7">
                    <h6 class="my-0">Discount </h6>
                    @if ($order->discount_code)
                      <span> Coupon Code : {{ $order->discount_code }} </span>
                    @endif
                  </div>
                  <span class="text-muted ">{!! Helper::showPrice($order->discount, $order->currency) !!}</span>
                </li>
              @endif

              @if ($order->shipping_charge)
                <li class="list-group-item d-flex justify-content-between lh-condensed shipping">
                  <div class="offset-7">
                    <h6 class="my-0">Shipping charge</h6>
                  </div>
                  <span class="text-muted ">{!! Helper::showPrice($order->shipping_charge, $order->currency) !!}</span>
                </li>
              @endif


              @if ($order->total)
                <li class="list-group-item d-flex justify-content-between lh-condensed total">
                  <div class="offset-7">
                    <h6 class="my-0">Grand Total</h6>
                  </div>
                  <span class="text-muted "><b> {!! Helper::showPrice($order->total ?? 0, $order->currency) !!}</b></span>
                </li>
              @endif

            </ul>

            {{-- <style>
              /* width */
              ::-webkit-scrollbar {
                width: 2px;
              }

              /* Track */
              ::-webkit-scrollbar-track {
                background: #f1f1f1;
              }

              /* Handle */
              ::-webkit-scrollbar-thumb {
                background: #888;
              }

              /* Handle on hover */
              ::-webkit-scrollbar-thumb:hover {
                background: #555;
              }

              .form-control:focus {
                box-shadow: none !important;
                border-color: none !important;
              }
            </style>
            <ul class="list-group mb-3  b-0" style="border-bottom: 1px solid rgba(0,0,0,.125)">

              <div style="max-height: 240px;overflow-y: scroll;" id="msg_block">
                @foreach ($orderMsg as $item)
                  @php
                    $admin = App\Admin::find($item->customer_id);

                  @endphp
                  @if ($item->type == 'admin')
                    <li class="list-group-item d-flex justify-content-between lh-condensed" style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
                      <div>
                        @if ($admin != null)
                          @if ($admin->profile_image != null)
                            <img width="35px" src='{{ asset('storage/' . $admin->profile_image) }}' style="border-radius: 50px;box-shadow:0px 1px #888888" />
                          @else
                            <img width="35px" src='https://collagemaster.com/storage/default/default.png' style="border-radius: 50px;box-shadow:0px 1px #888888" />
                          @endif
                        @else
                          <img width="35px" src='https://collagemaster.com/storage/default/default.png' style="border-radius: 50px;box-shadow:0px 1px #888888" />
                        @endif
                        <pre class="my-0 chat-replay-message">{{ $item->msg }}</pre>
                      </div>
                    </li>
                  @endif
                  @if ($item->type == 'adminImg')
                    <li class="list-group-item d-flex justify-content-between lh-condensed" style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
                      <div>
                        @php
                          $adminimg = App\Model\OrderChatAttachment::where('chat_id', $item->id)->get();
                        @endphp
                        @foreach ($adminimg as $img)
                          <a href="{{ route('admin.orders.msg.attachment', ['id' => $img->id]) }}"><img src="{{ asset('storage/dowload.png') }}" alt="" style="width:25px;position: absolute;margin-left: 44px;margin-top: -19px;"></a>
                          <img src="{{ asset('storage/' . $img->attachment) }}" alt="" style="width:100px;height:100px;">
                        @endforeach
                        <!--<a href="{{ route('admin.orders.msg.attachment', ['id' => $item->id]) }}"-->
                        <!--    id="{{ $item->id }}">-->
                        <!--    <h6 class="my-0 chat-replay-message"><i-->
                        <!--            class="ion-android-download"></i></h6>-->
                        <!--</a>-->
                      </div>
                    </li>
                  @endif

                  @if ($item->type == 'customer')
                    <li class="list-group-item d-flex justify-content-between lh-condensed" style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
                      <div class="text-right" style="width:100%">

                        <pre class="my-0 chat-message"> {{ $item->msg }}</pre>
                      </div>
                    </li>
                  @endif
                  @if ($item->type == 'custImg')
                    <li class="list-group-item d-flex justify-content-between lh-condensed" style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
                      <div class="text-right" style="width:100%">
                        <!--<a href="{{ route('admin.orders.msg.attachment', ['id' => $item->id]) }}"-->
                        <!--    id="{{ $item->id }}">-->
                        <!--    <h6 class="my-0 chat-message"><i class="ion-android-download"></i></h6>-->
                        <!--</a>-->
                        @php
                          $cutsimg = App\Model\OrderChatAttachment::where('chat_id', $item->id)->get();
                        @endphp
                        @foreach ($cutsimg as $img)
                          <a href="{{ route('admin.orders.msg.attachment', ['id' => $img->id]) }}"><img src="{{ asset('storage/dowload.png') }}" alt="" style="width:25px;position: absolute;margin-left: 44px;margin-top: -19px;"></a>
                          <img src="{{ asset('storage/' . $img->attachment) }}" alt="" style="width:100px;height:100px;">
                        @endforeach
                      </div>
                    </li>
                  @endif
                @endforeach
              </div>
              <li class="list-group-item d-flex justify-content-between lh-condensed" style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">

                <div style="width:100%">
                  <form name="orderMsgForm" id="orderMsgForm">
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">
                    <div class="form-group">
                      <input type="file" class="form-control" name="attachment[]" id="attachment" style="padding:3px!important;display: none" multiple>
                      <span style="width:50px;position: absolute;left: 600px;top: 36px;font-weight:600" id="no_of_files">0 Files Attached</span>
                      <img id="msg_img" src="{{ asset('storage/chat_img/img_avatar.png') }}" style="width:50px;border-radius:50%;position: absolute;left: 668px;top: 36px;" />
                    </div>
                    <div class="form-group">

                      <textarea class="form-control" name="message" placeholder="Write your query regarding to order..." cols="30" rows="10"></textarea>

                    </div>
                    <button class="btn btn-md btn-info mb-2 float-right" id="msg_send_btn" type="submit"> Send<i class="ion-android-send ml-2 "></i></button> <br>
                    <div id="error_element" class="text-danger"></div>
                    <div id="response_div" class="text-primary"></div>

                  </form>
                </div>
              </li>

            </ul> --}}

            <h5 class="card-title w-100 text-muted my-3">Contact Information </h5>
            <div class="card shadow-none border">
              <div class="card-body">
                <span class="text-muted "> Name : {{ $order->user->name ?? '' }} </span> <br>
                <span class="text-muted "> Email : {{ $order->user->email ?? '' }} </span> <br>
                <span class="text-muted "> Phone : {{ $order->user->phone ?? '' }} </span>
              </div>
            </div>

          </div>
          <div class="col-md-4 ">


            <h5 class="card-title w-100 text-muted my-3">Shipping Address</h5>
            <div class="card shadow-none border">
              <div class="card-body">
                @if ($shipping->email)
                  <span class="text-muted"> <strong>Email</strong> : {{ $shipping->email }}</span> <br>
                @endif
                @if ($shipping->mobile)
                  <span class="text-muted "> <strong>Mobile</strong> : {{ $shipping->mobile }}</span> <br>
                @endif
                @if ($shipping->address_one)
                  <span class="text-muted text-uppercase">{{ $shipping->address_one }}</span> <br>
                @endif
                @if ($shipping->address_two)
                  <span class="text-muted text-uppercase"> {{ $shipping->address_two }}</span> <br>
                @endif
                <span class="text-muted text-uppercase"> {{ $shipping->city ?? '' }} - {{ $shipping->postal_code ?? '' }} </span> <br>
                <span class="text-muted text-uppercase">{{ $shipping->state ?? '' }} - {{ $shipping->country ?? '' }}</span> <br>
              </div>
            </div>
            @if (isset($address->billing_address) && count((array) $address->billing_address))
              <h5 class="card-title text-muted mt-2">Billing Address</h5>
              <div class="card shadow-none border">
                <div class="card-body">
                  @if ($billing->billing_email)
                    <span class="text-muted"> <strong>Email</strong> : {{ $billing->billing_email }}</span> <br>
                  @endif
                  @if ($billing->billing_mobile)
                    <span class="text-muted"> <strong>Mobile</strong> : {{ $billing->billing_mobile }}</span> <br>
                  @endif
                  @if ($billing->billing_address_one)
                    <span class="text-muted text-uppercase">{{ $billing->billing_address_one }}</span> <br>
                  @endif
                  @if ($billing->billing_address_two)
                    <span class="text-muted text-uppercase"> {{ $billing->billing_address_two }}</span> <br>
                  @endif
                  <span class="text-muted text-uppercase"> {{ $billing->billing_city ?? '' }} - {{ $billing->billing_postal_code ?? '' }} </span> <br>
                  <span class="text-muted text-uppercase">{{ $billing->billing_state ?? '' }} - {{ $billing->billing_country ?? '' }}</span> <br>
                </div>
              </div>
            @endif

            <h5 class="card-title w-100 text-muted my-3">Payment Details </h5>
            <div class="card shadow-none border">
              <div class="card-body">
                {{-- @dump($order); --}}
                <span class="text-muted "> Payment Method
                </span> <br>
                <span class="text-muted"> {{ $order->payment_type == 'cash' ? 'COD' : $order->payment_type }}</span> <br>
                <hr>

                <span class="text-muted "> Transaction Id </span> <br>
                <span class="text-muted"> {{ $order->transaction_id ?? '------------' }} </span> <br>

                {{-- <hr>
                <span class="text-muted "> Payment Status </span> <br>
                <span class="text-muted"> {{ $order->payment_status }}</span> <br> --}}
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
  </section>
  <div id="image-model" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-body" id="load-modal">

        </div>
        <div class="modal-footer">
          <a name="" id="close_img_btn" class="lezada-button" href="#" data-dismiss="modal" role="button">Close</a>
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

    #my-dropzone .message {
      font-family: "Segoe UI Light", "Arial", serif;
      font-weight: 600;
      color: #0087F7;
      font-size: 1.5em;
      letter-spacing: 0.05em;
    }

    span.dot {
      height: 10px;
      width: 10px;
      border-radius: 50%;
      display: inline-block;
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
  <script>
    $('#msg_img').click(function() {
      $('#attachment').trigger('click');
    });

    $('#attachment').change(function() {
      const selectedFile = document.getElementById('attachment').files;
      if (selectedFile.length > 0) {
        $('#no_of_files').text(selectedFile.length + ' Files Attached')
      } else {
        $('#no_of_files').text('0 Files Attached');
      }
    });

    var objDiv = document.getElementById("msg_block");
    objDiv.scrollTo(0, objDiv.scrollHeight);

    $(document).ready(function() {
      // provider create
      $('#orderMsgForm').on('submit', function(e) {
        $('#msg_send_btn').text('...');
        $('#msg_send_btn').attr('disabled', true);

        e.preventDefault();

        var formData = new FormData(this);
        $.ajax({
          url: '{{ route('orders.msg') }}',
          type: 'post',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == "success") {
              $('#orderMsgForm')[0].reset();
              $('#response_div').text(response.message)
              $('#no_of_files').text('0 Files Attached');

              $('#response_div').html(
                '<br><div class="alert alert-success" role="alert"><i class="mdi mdi-block-helper mr-2"></i>Message Successfully Send</div>'
              )
              $('#msg_send_btn').html('Send <i class="ion-android-send ml-2"></i>');
              $('#msg_send_btn').attr('disabled', false);
              $('#msg_block').append(
                '<li class="list-group-item d-flex justify-content-between lh-condensed" style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important"><div class="text-right" style="width:100%"><h6 class="my-0 chat-message">Hello</h6></div></li>'
              )
              $('#msg_block').html(response.html);
              objDiv.scrollTo(0, objDiv.scrollHeight);
            } else if (response.status == "error") {
              $('#msg_send_btn').html('Send <i class="ion-android-send ml-2"></i>');
              $('#msg_send_btn').attr('disabled', false);

              var err_msg = "";
              $.each(response.message, function(key, value) {
                err_msg += value + "<br>";
              });

              $('#response_div').html(
                '<br><div class="alert alert-danger" role="alert"><i class="mdi mdi-block-helper mr-2"></i>Please upload file having extensions .jpeg/.jpg/.png/.zip only.</div>'
              )


            }
          }
        });
      });
    });
  </script>
@endpush
