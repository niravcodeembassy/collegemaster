@extends('admin.layouts.app')

@section('title', $title)

@section('content')

  @component('component.heading',
      [
          'page_title' => 'Orde Invoice',
          'icon' => 'fa fa-shopping-bag',
          'tagline' => 'Lorem ipsum dolor sit amet.',
          'action' => null,
          'action_icon' => 'fa fa-plus',
          'text' => '',
      ])
    <button class="btn btn-sm btn-primary printPDF"><i class="fa fa-print"></i> Print</button>

    {{-- <a href="{{ route('admin.order.invoice', 167) }}" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Print</a> --}}
  @endcomponent

  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body ">
          <div class="order-page" id="order-page">
            <div class="header">
              <h2>Order {{ $order->order_number ?? '' }}</h2>
              <p>{{ $shipping_address->first_name }} (7b2a310c6x5iovov)</p>
            </div>
            <div class="content-body">
              <div class="left_part">
                <p><i class="fa fa-gift" aria-hidden="true"></i> Marked as gift</p>
                <p><i class="fa fa-wallet" aria-hidden="true"></i> Gift message included</p>

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
                  <b>Scheduled to ship by</b>
                  <table>
                    <tr>
                      <td>
                        @if (isset($order->shipping_date))
                          {{ $order->shipping_date->format('F d Y') ?? '' }}
                        @endif
                      </td>
                    </tr>
                  </table>
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
                      <td>{{ $order->created_at->format('F d Y') }}</td>
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
                      $img = App\Model\ProductImage::select('image_url')->find($data->image_id);
                    @endphp

                    <table class="order-table">
                      <tr>
                        <td class="w-12">
                          <img src="{{ asset('storage/' . $img->image_url) ?? 'https://i.etsystatic.com/18954143/r/il/4d9459/2243517109/il_340x270.2243517109_k5dq.jpg' }}" class="img_product">
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
                            @if (isset($item->notes) && $item->notes != "")
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
                                    {{-- - {!! Helper::showPrice($data->discount ?? 0, $order->currency, $order->currency) !!} --}}
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    {!! Helper::showPrice($subtotal, $order->currency, $order->currency) !!}
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    {!! Helper::showPrice($data->tax, $order->currency, $order->currency) !!}
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
                        <td> <span>The most wonderful thing I decided to do was to share my life and heart with you.</span></td>
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


@endsection

@push('style')
  <style>
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
@endpush

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js" integrity="sha512-d5Jr3NflEZmFDdFHZtxeJtBzk0eB+kkRXWFQqEc1EKmolXjHm2IKCA7kTvXBNjIYzjXfD5XzIjaaErpkZHCkBg==" crossorigin="anonymous"></script>
@endpush

@push('scripts')
  <script>
    $('.printPDF').on('click', function() {
      const a = $('#order-page').printThis({
        importStyle: true,
        beforePrintEvent: function(a) {
          console.log(a);
        }
      });
    });
  </script>
@endpush
