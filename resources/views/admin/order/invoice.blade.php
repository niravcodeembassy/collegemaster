<html>
<title>Order invoice</title>

<head>
  <style>
    .main_invoice span,
    td {
      font-size: 20px;
    }

    .w-12 {
      width: 12%;
    }

    .w-54 {
      width: 54%;
    }

    .w-34 {
      width: 34%;
    }

    .pt-top {
      padding-top: 5px;
    }

    .pt-left {
      padding-left: 5px;
    }

    .v-top {
      vertical-align: top;
    }

    .text-right {
      text-align: right;
    }

    .note {
      padding-top: 10px;
    }

    .buyer {
      margin-bottom: 20px;
    }

    .message {
      margin-bottom: 20px;
    }

    .text-center {
      text-align: right;
    }


    .order-page .content-body {
      display: -webkit-flex;
      display: flex;
      margin-bottom: 10px;
    }

    .shipping {
      padding-top: 15px;
    }

    .calculation,
    .main {
      display: flex;
      display: -webkit-flex;
    }

    .shop,
    .calculation {
      padding-top: 10px;
      padding-bottom: 10px;
    }

    .scheduled {
      padding-top: 20px;
      padding-bottom: 20px;
      border-bottom: 1px solid black;
    }

    .left,
    .right {
      -webkit-flex: 1;
      flex: 1;
      text-align: left;
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
    }

    .main_left {
      flex: 1;
      text-align: left;
    }

    .main_right {
      flex: 1;
      text-align: right;
      display: contents;
    }

    .order-page .left_part {
      -webkit-flex: 1;
      flex: 1;
      text-align: left;
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
      margin-top: 40px;
      margin-right: 5px;
    }

    .order-page .right_part {
      -webkit-flex: 1;
      flex: 3;
      text-align: left;
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
      margin-top: 40px;
      margin-left: 5px;
    }

    .order-page .content {
      padding-top: 15px;
      padding-bottom: 15px;
      border-top: 1px solid black;
      border-bottom: 1px solid black;
    }

    .order-page .invoice-table {
      overflow: hidden;
      border-radius: 2px;
      border-style: hidden;
      box-shadow: none;
    }

    .img_product {
      height: 70px;
      width: 70px;
    }
  </style>
</head>

<body>
  <div class="row">
    <div class="col-sm-12">
      <div class="card main_invoice">
        <div class="card-body">
          <div class="order-page" id="order-page">
            <div class="header">
              <h2>Order {{ $order->order_number ?? '' }}</h2>
              <p>{{ $shipping_address->first_name }} (7b2a310c6x5iovov)</p>
            </div>
            <div class="content-body">
              <div class="left_part">
                <span><i class="fa fa-gift" aria-hidden="true"></i> Marked as gift</span><br>
                <span><i class="fa fa-shopping-bag" aria-hidden="true"></i> Gift message included</span>

                <div class="shipping">
                  <b>Ship to</b>
                  <table>
                    <tr>
                      <td><span>{{ $shipping_address->address_one ?? '' }}</span><br>
                        @if ($shipping_address->address_two)
                          <span>{{ $shipping_address->address_two ?? '' }}</span> <br>
                        @endif
                        <span>{{ $shipping_address->city }}&nbsp;{{ $shipping_address->postal_code }}</span>
                        <span>{{ $shipping_address->state }}</span><br>
                        <span>{{ $shipping_address->country }}</span>
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="scheduled">
                  @if (isset($order->shipping_date))
                    <b>Scheduled to ship by</b>
                    <table>
                      <tr>
                        <td>

                          {{ date('F j, Y', strtotime($order->shipping_date)) }}

                        </td>
                      </tr>
                    </table>
                  @endif
                </div>
                <div class="shop">
                  <b>Shop</b>
                  <table>
                    <tr>
                      <td>{{ $setting->store_name ?? '' }}
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="shop">
                  <b>Order date</b>
                  <table>
                    <tr>
                      <td>{{ $order->created_at->format('F d, Y') }}</td>
                    </tr>
                  </table>
                </div>
                <div class="shop">
                  <b>Payment method</b>
                  <table>
                    <tr>
                      <td>Paid via {{ $order->payment_type ?? '' }}
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="right_part">
                <b>
                  <h4>{{ $order->items->count() ?? '' }} item</h4>
                </b>
                <div class="content">
                  @php
                    $subtotal = 0;
                  @endphp
                  @foreach ($order->items as $key => $item)
                    @php

                      $data = json_decode($item->raw_data);
                      $attributes = [];
                      if ($data->attribute != null) {
                          $attributes = json_decode($item->attribute, true);
                      }
                      $subtotal += $data->final_price_total;
                      $product = \App\Model\Product::select('id', 'name', 'slug', 'sku')->find($data->product_id);
                      $image_id = $data->image_id;
                      $image_url = null;
                      if (isset($image_id)) {
                          $img = App\Model\ProductImage::select('image_url')->find($image_id);
                          if (isset($img->image_url)) {
                              $image_url = asset('storage/' . $img->image_url);
                          } else {
                              $image_url = asset('storage/' . $img->image_url);
                          }
                          $image_url = asset('storage/' . $img->image_url);
                      } else {
                          $image_url = asset('storage/category/default.png');
                      }
                    @endphp

                    <table class="order-table">
                      <tr>
                        <td class="w-12">
                          <img src="{{ $image_url ?? 'https://i.etsystatic.com/18954143/r/il/4d9459/2243517109/il_340x270.2243517109_k5dq.jpg' }}" class="img_product">
                        </td>
                        <td class="w-54 v-top">
                          <b>{{ $data->name . '-' . $data->hsn_cod ?? '' }}
                          </b>
                        </td>
                        <td class="w-34 v-top text-right">
                          {{ $data->qty }} x {!! Helper::showPrice($data->price ?? 0, $order->currency, $order->currency) !!}
                        </td>
                      </tr>
                      <tr>
                        <td class="w-12">
                        </td>
                        <td class="w-54">
                          <table>
                            <tr>
                              <td class="pt-top">SKU : </td>
                              <td class="pt-top pt-left">{{ $product->sku ?? '' }}</td>
                            </tr>
                            @if (count($attributes) > 0)
                              <tr>
                                <td class="pt-top">Size : </td>
                                <td class="pt-top pt-left">{{ $attributes['size'] ?? '' }} inches</td>
                              </tr>
                              <tr>
                                <td class="pt-top">Printing Options :</td>
                                <td class="pt-top pt-left">{{ $attributes['printing options'] ?? '' }}</td>
                              </tr>
                            @endif
                            @if (isset($data->notes) && $data->notes != '')
                              <tr>
                                <td class="pt-top">Personalization :</td>
                                <td class="pt-top pt-left">{{ $data->notes ?? '' }}</td>
                              </tr>
                            @endif
                          </table>
                        </td>
                        <td class="w-34">

                        </td>
                      </tr>
                    </table>
                    @if ($loop->last)
                      <span>
                      @else
                        <hr />
                    @endif
                  @endforeach


                </div>
                <div class="calculation">
                  <div class="left">
                  </div>
                  <div class="right">
                    <div class="main">
                      <div class="main_left">
                        <table class="invoice-table">
                          <tr>
                            <td class="text-right v-top">
                              <table>
                                <tr>
                                  <td>
                                    Item total
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    Shop discount
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    Subtotal
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    Tax
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    Shipping total
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <b>Order total</b>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <div class="main_right">
                        <table class="invoice-table">
                          <tr>
                            <td class="text-right v-top">
                              <table>
                                <tr>
                                  <td>
                                    {!! Helper::showPrice($data->final_price_total, $order->currency, $order->currency) !!}
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    - {!! Helper::showPrice($order->discount ?? 0, $order->currency, $order->currency) !!}
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    {!! Helper::showPrice($subtotal, $order->currency, $order->currency) !!}
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    $ 0.00
                                    {{-- {!! Helper::showPrice($data->tax, $order->currency, $order->currency) !!} --}}
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    {!! Helper::showPrice($order->shipping_charge, $order->currency) !!}
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <b>{!! Helper::showPrice($order->total ?? 0, $order->currency) !!}</b>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="note">
                  <div class="buyer">
                    <b>Note from buyer</b>
                    <table>
                      <tr>
                        <td> <span>I will send you photos and also display text soon Leena. Thank you</span></td>
                      </tr>
                    </table>
                  </div>
                  <div class="mesage">
                    <b>Gift message</b>
                    <table>
                      <tr>
                        <td><span>{{ $order->gift ?? 'The most wonderful thing I decided to do was to share my life and heart with you.' }}</span></td>
                      </tr>
                      <tr>
                        <td> <span>Happy anniversary dear husband!</span>
                        </td>
                      </tr>
                      <tr>
                        <td> <span>I love you so much! {{ $order->gift ?? '' }}</span></td>
                      </tr>
                      <tr>
                        <td> <span>Yours,</span></td>
                      </tr>
                      <tr>
                        <td> <span>{{ $shipping_address->first_name }},</span></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
