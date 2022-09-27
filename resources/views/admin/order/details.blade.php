@extends('admin.layouts.app')

@section('title', $title)

@section('content')
  @component('component.heading',
      [
          'page_title' => '',
          'icon' => 'ik ik-shopping-bag',
          'tagline' => '',
          'action' => route('admin.order.index'),
          'action_icon' => 'fa fa-arrow-left',
          'text' => 'Back',
      ])
  @endcomponent
  {{-- @dump($order) --}}

  @php
    $address = json_decode($order->address);
    $shipping = $address->shipping_address;
    // dd($shipping);
    $billing = $address->billing_address;
  @endphp
  <div class="row">
    <div class="col-md-8 mb-8">
      <h5 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Order No : {{ $order->order_number }}</span>
        <span class="badge badge-secondary badge-pill">{{ $order->created_at->format('d-m-Y') }}</span>
      </h5>
      <ul class="list-group mb-3 shadow-none b-0">

        @foreach ($order->items as $item)
          @php
            $item = json_decode($item->raw_data);
            $attributes = [];
            if ($item->attribute != null) {
                $attributes = json_decode($item->attribute, true);
            }
            $qty = $item->qty;

            $image_id = $item->image_id;
            $product_id = $item->product_id;
            $image_url = null;
            if (isset($item->image_id)) {
                $img = App\Model\ProductImage::select('image_url')->find($image_id);
                if (isset($img->image_url)) {
                    $image_url = asset('storage/' . $img->image_url);
                } else {
                    $image_url = asset('storage/category/default.png');
                }
            } else {
                $image_url = asset('storage/category/default.png');
            }
            $sku = App\Model\Product::select('sku')->find($product_id);

          @endphp
          <li class="list-group-item d-flex justify-content-between lh-condensed">
            <img src="{{ $image_url }}" alt="" style="width: 160px" class="mr-4">
            <div style="margin-left:20px">
              <h6 class="my-0 f-18" title="{{ $item->name }}">{{ Str::words($item->name, 10, '...') }}</h6>
              @if (count($attributes) > 0)
                <div class="">
                  @foreach ($attributes as $key => $attribute)
                    <span class="text-muted">{{ $key }} : {{ $attribute }}</span>
                    @if (!$loop->last)
                    @endif
                    @if (!$loop->last)
                      </br>
                    @endif
                  @endforeach
                </div>
              @endif

              @if (isset($item->notes) && $item->notes != '')
                <div class="text-muted" style="margin-top: 10px;"><b>Notes</b> : {{ $item->notes }}</div>
              @endif

              @if (isset($item->gift_message) && $item->gift_message != '')
                <div class="text-muted" style="margin-top: 5px;"><b>Gift Message</b> : {{ $item->gift_message }}</div>
              @endif


              <small class="text-muted f-12">SKU : <b>{{ $sku->sku }}</b> </small>
              <br>
              <small class="text-muted f-12">Quantity : {{ str_replace('.00', ' ', $qty) }} </small>
              <br>
              <span class="text-muted f-14 ">{!! Helper::showPrice($item->qty_price, $order->currency, $order->currency) !!}</span>

            </div>
          </li>
        @endforeach

        @if ($order->subtotal)
          <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div class="offset-7">
              <h6 class="my-0">Subtotal</h6>
            </div>
            <span class="text-muted ">{!! Helper::showPrice($order->subtotal, $order->currency) !!}</span>
          </li>
        @endif


        @if ($order->discount && $order->discount != '0.00')
          <li class="list-group-item d-flex justify-content-between lh-condensed">
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
          <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div class="offset-7">
              <h6 class="my-0">Shipping charge</h6>
            </div>
            <span class="text-muted ">{!! Helper::showPrice($order->shipping_charge, $order->currency) !!}</span>
          </li>
        @endif


        {{-- @if ($order->tax)
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div class="offset-7">
                    <h6 class="my-0">Tax</h6>
                </div>
                <span class="text-muted ">{!! Helper::showPrice($order->tax,$order->currency) !!}</span>
            </li>
            @endif --}}


        @if ($order->total)
          <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div class="offset-7">
              <h6 class="my-0">Grand Total</h6>
            </div>
            <span class="text-muted "><b> {!! Helper::showPrice($order->total ?? 0, $order->currency) !!}</b></span>
          </li>
        @endif
      </ul>

      <h5 class="card-title w-100 text-muted my-3">Contact Information </h5>
      <div class="card shadow-none border">
        <div class="card-body">
          <span class="text-muted "> Name : {{ $order->user->name ?? '' }} </span> <br>
          <span class="text-muted "> Email : {{ $order->user->email ?? '' }} </span> <br>
          <span class="text-muted "> Phone : {{ $order->user->phone ?? '' }} </span>
        </div>
      </div>
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
      </style> --}}

      @php
        $chat = App\Model\OrderChat::where('order_id', $order->id)->get();
      @endphp
      {{-- <ul class="list-group mb-3  b-0" style="border-bottom: 1px solid rgba(0,0,0,.125)">

        <div style="max-height: 240px;overflow-y: scroll;" id="msg_block">
          @foreach ($chat as $item)
            @php
              $user = App\User::find($item->customer_id);
            @endphp
            @if ($item->type == 'customer')
              <li class="list-group-item d-flex justify-content-between lh-condensed" style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
                <div>
                  @if ($user->profile_image != null)
                    <img width="35px" src='{{ $user->profile_src }}' style="border-radius: 50px;box-shadow:0px 1px #888888" />
                  @else
                    <img width="35px" src='https://collagemaster.com/storage/default/default.png' style="border-radius: 50px;box-shadow:0px 1px #888888" />
                  @endif
                  <pre class="my-0 chat-replay-message">{{ $item->msg }}</pre>
                </div>
              </li>
            @endif
            @if ($item->type == 'adminImg')
              <li class="list-group-item d-flex justify-content-between lh-condensed" style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
                <div class="text-right" style="width:100%">
                  @php
                    $adminimg = App\Model\OrderChatAttachment::where('chat_id', $item->id)->get();
                  @endphp
                  @foreach ($adminimg as $img)
                    <a href="{{ route('admin.orders.msg.attachment', ['id' => $img->id]) }}"><img src="{{ asset('storage/dowload.png') }}" alt="" style="width:25px;position: absolute;margin-left: 38px;margin-top: 31px;"></a>
                    <img src="{{ asset('storage/' . $img->attachment) }}" alt="" style="width:100px;height:100px;">
                  @endforeach
                  <!--<a href="{{ route('admin.orders.msg.attachment', ['id' => $item->id]) }}"-->
                  <!--    id="{{ $item->id }}">-->
                  <!--    <h6 class="my-0 chat-message"><i class="fa fa-download"></i></h6>-->
                  <!--</a>-->
                </div>
              </li>
            @endif

            @if ($item->type == 'admin')
              <li class="list-group-item d-flex justify-content-between lh-condensed" style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
                <div class="text-right" style="width:100%">
                  <pre class="my-0 chat-message"> {{ $item->msg }}</pre>
                </div>
              </li>
            @endif
            @if ($item->type == 'custImg')
              <li class="list-group-item d-flex justify-content-between lh-condensed" style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
                <div>
                  @php
                    $cutsimg = App\Model\OrderChatAttachment::where('chat_id', $item->id)->get();
                  @endphp
                  @foreach ($cutsimg as $img)
                    <a href="{{ route('admin.orders.msg.attachment', ['id' => $img->id]) }}"><img src="{{ asset('storage/dowload.png') }}" alt="" style="width:25px;position: absolute;margin-left: 38px;margin-top: 31px;"></a>
                    <img src="{{ asset('storage/' . $img->attachment) }}" alt="" style="width:100px;height:100px;">
                  @endforeach
                  <!--<a href="{{ route('admin.orders.msg.attachment', ['id' => $item->id]) }}"-->
                  <!--    id="{{ $item->id }}">-->
                  <!--    <h6 class="my-0 chat-replay-message"><i class="fa fa-download"></i></h6>-->
                  <!--</a>-->
                </div>
              </li>
            @endif
          @endforeach
        </div>
        <li class="list-group-item d-flex justify-content-between lh-condensed" style="border-bottom: 0px;border-top:1px solid #e0e0e0">

          <div style="width:100%">
            <form name="orderMsgForm" id="orderMsgForm">
              @csrf
              <input type="hidden" name="id" value="{{ $order->id }}">
              <input type="hidden" name="user_id" value="{{ $order->user_id }}">
              <div class="form-group">
                <input type="file" class="form-control" name="attachment[]" id="attachment" style="padding:3px!important;display: none" multiple>
                <span style="width:50px;position: absolute;left: 540px;top: 36px;font-weight:600" id="no_of_files">0 Files Attached</span>

                <img id="msg_img" src="{{ asset('storage/chat_img/img_avatar.png') }}" style="width:50px;border-radius:50%;position: absolute;left: 614px;top: 36px;" />

              </div>
              <div class="form-group" style="display: flex">

                <textarea class="form-control" name="message" placeholder="Write your query regarding to order..." cols="30" rows="10" required></textarea>

              </div>
              <button class="btn btn-md btn-info float-right" id="msg_send_btn" type="submit"> Send <i class="fa fa-paper-plane"></i></button> <br>

              <div id="error_element" class="text-danger"></div>
              <div id="response_div" class="text-primary"></div>

            </form>
          </div>
        </li>
      </ul> --}}
    </div>
    <div class="col-md-4 ">


      <h5 class="card-title w-100 text-muted my-3">Shipping Address</h5>
      <div class="card shadow-none border">
        <div class="card-body">
          @if ($shipping->email)
            <span class="text-muted "> <strong>Email</strong> : {{ $shipping->email }}</span> <br>
          @endif
          @if ($shipping->mobile)
            <span class="text-muted "> <strong>Mobile</strong> : {{ $shipping->mobile }}</span> <br>
          @endif
          @if ($shipping->address_one)
            <span class="text-muted ">{{ $shipping->address_one }}</span> <br>
          @endif
          @if ($shipping->address_two)
            <span class="text-muted "> {{ $shipping->address_two }}</span> <br>
          @endif

          <span class="text-muted "> {{ $shipping->city ?? '' }} - {{ $shipping->postal_code ?? '' }} </span> <br>
          <span class="text-muted ">{{ $shipping->state ?? '' }} - {{ $shipping->country ?? '' }}</span> <br>
        </div>
      </div>

      @if (isset($address->billing_address) && count((array) $address->billing_address))
        <h5 class="card-title w-100 text-muted my-3">Billing Address</h5>
        <div class="card shadow-none border">
          <div class="card-body">

            @if ($billing->billing_address_one)
              <span class="text-muted ">{{ $billing->billing_address_one }}</span> <br>
            @endif
            @if ($billing->billing_address_two)
              <span class="text-muted "> {{ $billing->billing_address_two }}</span> <br>
            @endif
            <span class="text-muted "> {{ $billing->billing_city ?? '' }} -
              {{ $billing->billing_postal_code ?? '' }} </span> <br>
            <span class="text-muted ">{{ $billing->billing_state ?? '' }} -
              {{ $billing->billing_country ?? '' }}</span> <br>
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
          <hr>

          <span class="text-muted "> Payment Status </span> <br>
          <span class="text-muted"> {{ $order->payment_status }}</span> <br>
        </div>
      </div>


    </div>
  </div>

@endsection



@push('scripts')
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
        $('#error_element').text('');
        $('#response_div').text('');
        $('#msg_send_btn').text('...');
        $('#msg_send_btn').attr('disabled', true);

        // attachment();
        e.preventDefault();

        var formData = new FormData(this);
        $.ajax({
          url: '{{ route('admin.orders.msg') }}',
          type: 'post',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == "success") {
              $('#orderMsgForm')[0].reset();
              $('#no_of_files').text('0 Files Attached');
              $('#response_div').text(response.message)
              $('#response_div').html(
                '<br><div class="alert alert-success" role="alert"><i class="mdi mdi-block-helper mr-2"></i>Message Successfully Send</div>'
              )
              $('#msg_send_btn').html(' <i class="fa fa-paper-plane"></i>');
              $('#msg_send_btn').attr('disabled', false);
              $('#msg_block').html(response.html);

              objDiv.scrollTo(0, objDiv.scrollHeight);

            } else if (response.status == "error") {

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
