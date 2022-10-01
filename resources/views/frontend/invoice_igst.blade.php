@extends('frontend.layouts.app')

@section('title', $title)

@section('content')
  @include('frontend.layouts.banner', [
      'pageTitel' => 'INVOICE' ?? '',
  ])

  <div class="container">
    <div class="row mt-80 mb-80">

      <div class="col-sm-12">

        @component('component.heading',
            [
                'page_title' => 'Invoice',
                'icon' => 'fa fa-shopping-bag',
                'tagline' => 'Lorem ipsum dolor sit amet.',
                'action' => null,
                'action_icon' => 'fa fa-plus',
                'text' => '',
            ])
          <button class="btn btn-sm btn-primary printPDF mr-5"><i class="fa fa-print"></i> Print</button>
          {{-- <button class="btn btn-sm btn-primary download-pdf mr-5" ><i class="fa fa-download"></i> Download</button> --}}
          <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary  "><i class="fa fa-arrow-left"></i> Back</a>
        @endcomponent
        <div class="card">
          <div class="card-body ">
            <div class="invoice-page" id="invoice-page" data-filename="{{ $order->order_number }}.pdf">
              <div>
                <div class="refrens-header-wrapper">
                  <div class="invoice-header">
                    <div class="invoice-detail-section">
                      <table border="0" class="invoice-table invoice-head-table">
                        <tbody>
                          <tr>
                            <th>
                              <h3>Invoice&nbsp;</h3>
                            </th>
                          </tr>
                          <tr>
                            <th>Invoice No#</th>
                            <td>{{ $order->order_number ?? '' }}</td>
                          </tr>
                          <tr>
                            <th>Invoice Date</th>
                            <td>
                              <div><span>{{ $order->created_at->format('F d Y') }}</span></div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="invoice-detail-section">
                      <table border="0" class="p-0">
                        <tbody>
                          <tr>
                            <div class="p-0 m-0">
                              <b>{{ $setting->store_name ?? '' }}</b>
                              <div class="billed-by-address">
                                <div class="billed-by-sub-address ">
                                  <span style="white-space: break-spaces;">{!! $setting->address ?? '' !!}</span>
                                </div>
                              </div>
                              <div class="address-email"><b>Email: </b><span>{{ $setting->email }}</span></div>
                              <div class="address-email"><b>Mobile: </b><span>{{ $setting->contact }}</span></div>
                            </div>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="font-size-div">
                  <div class="address-section-wrapper">
                    <div class="address-section-billed-by">
                      <h2 class="primary-text billed-to-heading">Ship To</h2>
                      <b>
                        {{ $shipping_address->first_name }} {{ $shipping_address->last_name }}
                      </b>
                      <div class="billed-to-address">
                        <div class="billed-to-sub-address">
                          <span>{{ $shipping_address->address_one ?? '' }}</span><br>
                          @if ($shipping_address->address_two)
                            <span>{{ $shipping_address->address_two ?? '' }}</span> <br>
                          @endif
                          <span>{{ $shipping_address->city }}&nbsp;{{ $shipping_address->postal_code }}</span>
                          <span>{{ $shipping_address->state }}&nbsp;{{ $shipping_address->country }}</span><br>
                        </div>
                      </div>
                      <div class="address-email"><b>Email: </b><span>{{ $shipping_address->email }}</span></div>
                      <div class="address-email"><b>Mobile: </b><span>{{ $shipping_address->mobile }}</span></div>
                    </div>
                    <div class="address-section-billed-to">
                      <h2 class="primary-text billed-to-heading">Bill To</h2>
                      <b>
                        {{ $belling_address->first_name }} {{ $belling_address->last_name }}
                      </b>
                      <div class="billed-to-address">
                        <div class="billed-to-sub-address">
                          <span>{{ $belling_address->address_one ?? '' }}</span><br>
                          @if ($belling_address->address_two)
                            <span>{{ $belling_address->address_two ?? '' }}</span> <br>
                          @endif
                          <span>{{ $belling_address->city }}&nbsp;{{ $belling_address->postal_code }}</span>
                          <span>{{ $belling_address->state }}&nbsp;{{ $belling_address->country }}</span><br>
                        </div>
                      </div>
                      <div class="address-email"><b>Email: </b><span>{{ $belling_address->email }}</span></div>
                      <div class="address-email"><b>Mobile: </b><span>{{ $belling_address->mobile }}</span></div>
                    </div>
                  </div>
                  <div class="shipped-section-wrapper"></div>
                  <div class="cos-section-wrapper">
                    <div class="cos-column"><span class="cos-column-title"><b>Place of Supply :
                        </b></span><span>{{ $shipping_address->state }}</span></div>
                    <div class="cos-column">
                      <span class="cos-column-title"><b>State of Supply :
                        </b></span><span>{{ $setting->state }}</span>
                    </div>
                  </div>
                  <div class="invoice-items-table-wrapper">
                    <table class="invoice-table invoice-items-table">
                      <thead>
                        <tr invoicetype="INVOICE" class="large-item-row gst-invoice">
                          <th width="10" class="lll"></th>
                          <th>Item</th>
                          <th>GST</th>
                          <th>Quantity</th>
                          <th>Rate</th>
                          <th>Discount</th>
                          <th>Net Amt</th>
                          <th>IGST</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $subtotal = 0;
                        @endphp
                        @foreach ($order->items as $item)
                          @php
                            $data = json_decode($item->raw_data);
                            $subtotal += $data->final_price_total;
                          @endphp
                          <tr class="large-item-row gst-invoice">
                            <td>{{ $loop->iteration }}.</td>
                            <td class="">{{ $data->name . '-' . $data->hsn_cod ?? '' }}</td>
                            <td class="" width="10">{{ $data->tax_percentage }}%</td>
                            <td class="" width="10">{{ $data->qty }}</td>
                            <td class="" width="10">{!! Helper::showPrice($data->price, $order->currency, $order->currency) !!}</td>
                            <td class="" width="10">{!! Helper::showPrice($data->discount ?? 0, $order->currency, $order->currency) !!}</td>
                            <td class="" width="10">{!! Helper::showPrice($data->taxable_price, $order->currency, $order->currency) !!}</td>
                            <td class="" width="10">{!! Helper::showPrice($data->tax, $order->currency, $order->currency) !!}</td>
                            <td class="" width="10">{!! Helper::showPrice($data->final_price_total, $order->currency, $order->currency) !!}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <div class="bank-total-wrapper">
                    <div class="bank-words-wrapper">
                      <div class="invoice-total-in-words-wrapper">
                        <p></p>
                      </div>
                      <div class="invoice-bank-upi-wrapper"></div>
                    </div>
                    <div class="total-signature-wrapper">
                      <div class="invoice-total-calculation">
                        <table border="0" class="invoice-table invoice-totals-table">
                          <tbody>
                            <tr>
                              <th>Sub Total</th>
                              <td>{!! Helper::showPrice($subtotal, $order->currency, $order->currency) !!}</td>
                            </tr>
                            {{-- @if ($order->discount && $order->discount != '0.00')
                                                    <tr>
                                                        <th>Discount</th>
                                                        <td>{!! Helper::showPrice($order->discount,$order->currency) !!}</td>
                                                    </tr>
                                                    @endif --}}
                            @if ($order->shipping_charge)
                              <tr>
                                <th>Shipping charge</th>
                                <td>{!! Helper::showPrice($order->shipping_charge, $order->currency) !!}</td>
                              </tr>
                            @endif
                            {{-- @if ($order->tax)
                                                        <tr>
                                                            <th>GST</th>
                                                            <td>{!! Helper::showPrice($order->tax,$order->currency) !!}</td>
                                                        </tr>
                                                    @endif --}}
                            @if ($order->total)
                              <tr>
                                <th>Total</th>
                                <td>{!! Helper::showPrice($order->total ?? 0, $order->currency) !!}</td>
                              </tr>
                            @endif
                          </tbody>
                        </table>
                        <table border="0" class="invoice-table invoice-extra-total-table">
                          <tbody></tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  @if ($setting->term_condition != '')

                    @php
                      $term_condition = explode('##', $setting->term_condition);
                    @endphp

                    <div class="invoice-terms-wrapper">
                      <div class="primary-text terms-heading">Terms and Conditions</div>
                      <ol class="invoice-terms">
                        @foreach ($term_condition as $item)
                          <li>{{ $item }}</li>
                        @endforeach
                      </ol>
                    </div>

                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Language - Comma Decimal Place table end -->
      </div>
    </div>
  </div>

@endsection

@push('css')
@endpush

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js" integrity="sha512-d5Jr3NflEZmFDdFHZtxeJtBzk0eB+kkRXWFQqEc1EKmolXjHm2IKCA7kTvXBNjIYzjXfD5XzIjaaErpkZHCkBg==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
  <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
@endpush

@push('script')
  <script>
    $('.printPDF').on('click', function() {
      var element = document.getElementById('invoice-page');
      var opt = {
        margin: 0.2,
        filename: $('#invoice-page').data('filename'),
        image: {
          type: 'jpeg',
          quality: 1
        },
        html2canvas: {
          scale: 8
        },
        jsPDF: {
          unit: 'in'
        }
      };
      // html2pdf().set(opt).from(element).save();
      html2pdf().set(opt).from(element).toPdf().get('pdf').then(function(pdfObj) {
        pdfObj.autoPrint();
        window.open(pdfObj.output('bloburl'), '_blank');
      });
    });

    // New Promise-based usage:

    // $('.printPDF').on('click', function() {
    //   const a = $('#invoice-page').printThis({
    //     importStyle: true,
    //     beforePrintEvent: function(a) {
    //       console.log(a);
    //     }
    //   });
    //   console.log(a);
    // });
  </script>
@endpush

@push('style')
  <style>
    /* Template Name: Professional  */


    .font-size-div * {
      line-height: 21px;
      font-size: 14px;
    }

    :root {
      --primary-color: rgba(101, 57, 192, 1);
      --secondary-color: rgba(101, 57, 192, 0.1);
      --primary-background: rgba(101, 57, 192, 1);
      --secondary-background: rgba(101, 57, 192, 0.1);
      --title-font: 'Open Sans';
    }

    table {
      border-collapse: collapse;
    }

    .show-in-pdf {
      display: none;
    }

    .invoice-page .no-background {
      background: none;
    }

    .invoice-page {
      line-height: 21px;
      font-family: "Open Sans", Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    @media print {
      .invoice-page {
        padding: 10px;
        width: 1500px;
      }
    }

    .invoice-page .invoice-heading {
      font-family: -webkit-var(--title-font, 'Open Sans');
      font-family: var(--title-font, 'Open Sans');
      font-size: 32px !important;
      color: -webkit-var(--primary-color, rgba(101, 57, 192, 1));
      color: var(--primary-color, rgba(101, 57, 192, 1));
      display: -webkit-flex;
      display: flex;
      margin-bottom: 0;
    }

    .invoice-page .invoice-header {
      display: -webkit-flex;
      display: flex;
      justify-content: space-between;
      -webkit-justify-content: space-between;
      margin-top: 10px;
    }

    .invoice-page .invoice-head-table {
      overflow: hidden;
      border-radius: 2px;
      border-style: hidden;
      box-shadow: none;
      margin: auto 0 15px;
      border: none;
    }

    .invoice-page .invoice-head-table tbody th {
      text-align: left;
      vertical-align: top;
      color: rgba(0, 0, 0, 0.50);
    }

    .invoice-page .invoice-head-table th {
      padding: 5px 15px 5px 0;
      border: none;
    }

    .invoice-page .invoice-head-table td {
      padding: 5px 15px 5px 0;
      font-weight: bold;
      border: none;
    }

    .invoice-page .address-section-wrapper {
      display: -webkit-flex;
      display: flex;
      margin-bottom: 10px;
    }

    .invoice-page .shipped-section-wrapper {
      display: -webkit-flex;
      display: flex;
      margin-bottom: 10px;
    }

    .invoice-page .cos-section-wrapper {
      display: -webkit-flex;
      display: flex;
    }

    .invoice-page .address-section-billed-by {
      -webkit-flex: 1;
      flex: 1;
      text-align: left;
      background: -webkit-var(--secondary-background, rgba(101, 57, 192, 0.1));
      background: var(--secondary-background, rgba(101, 57, 192, 0.1));
      padding: 15px;
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
      margin-top: 10px;
      margin-right: 5px;
      border-radius: 6px;
    }

    .invoice-page .address-section-billed-to {
      -webkit-flex: 1;
      flex: 1;
      text-align: left;
      background: -webkit-var(--secondary-background, rgba(101, 57, 192, 0.1));
      background: var(--secondary-background, rgba(101, 57, 192, 0.1));
      padding: 15px;
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
      margin-top: 10px;
      margin-left: 5px;
      border-radius: 6px;
    }

    .invoice-page .address-section-shipped-to {
      -webkit-flex: 1;
      flex: 1;
      text-align: left;
      background: -webkit-var(--secondary-background, rgba(101, 57, 192, 0.1));
      background: var(--secondary-background, rgba(101, 57, 192, 0.1));
      padding: 15px;
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
      margin-top: 10px;
      border-radius: 6px;
      margin-right: 10px;
      max-width: 50%;
    }

    .invoice-page .address-section-transport {
      -webkit-flex: 1;
      flex: 1;
      text-align: left;
      background: -webkit-var(--secondary-background, rgba(101, 57, 192, 0.1));
      background: var(--secondary-background, rgba(101, 57, 192, 0.1));
      padding: 15px;
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
      margin-top: 10px;
      border-radius: 6px;
      max-width: 50%;
    }

    .invoice-page .address-section-billed-by .billed-by-heading {
      line-height: 31px;
      margin-bottom: 0;
      font-family: -webkit-var(--title-font, 'Open Sans');
      font-family: var(--title-font, 'Open Sans');
    }

    .invoice-page .address-section-billed-to .billed-to-heading {
      line-height: 31px;
      margin-bottom: 0;
      font-family: -webkit-var(--title-font, 'Open Sans');
      font-family: var(--title-font, 'Open Sans');
    }

    .invoice-page .address-section-shipped-to .shipped-to-heading {
      line-height: 31px;
      margin-bottom: 0;
      font-family: -webkit-var(--title-font, 'Open Sans');
      font-family: var(--title-font, 'Open Sans');
    }

    .invoice-page .address-section-transport .transport-heading {
      line-height: 31px;
      margin-bottom: 0;
      font-family: -webkit-var(--title-font, 'Open Sans');
      font-family: var(--title-font, 'Open Sans');
    }

    .invoice-page .address-section-billed-by .billed-by-address {
      display: flex;
      display: -webkit-flex;
      flex-direction: column;
      -webkit-flex-direction: column;
    }

    .invoice-page .address-section-billed-to .billed-to-address {
      display: flex;
      display: -webkit-flex;
      flex-direction: column;
      -webkit-flex-direction: column;
    }

    .invoice-page .address-section-shipped-to .shipped-to-address {
      display: flex;
      display: -webkit-flex;
      flex-direction: column;
      -webkit-flex-direction: column;
    }

    .invoice-page .address-section-transport p {
      margin-bottom: 5px;
    }

    .invoice-page .cos-column {
      -webkit-flex: 1;
      flex: 1;
      text-align: left;
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
      margin: 10px 0;
      text-align: center;
    }

    .invoice-page .cos-column:first-child {
      margin-right: 5px;
    }

    .invoice-page .cos-column:last-child {
      margin-left: 5px;
    }

    .invoice-page .primary-text {
      color: -webkit-var(--primary-color, rgba(101, 57, 192, 1));
      color: var(--primary-color, rgba(101, 57, 192, 1));
      margin-bottom: 0.5rem;
    }

    .invoice-page .logo-wrapper {
      text-align: center;
      margin: 0;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      display: -webkit-flex;
      -webkit-box-pack: end;
      -ms-flex-pack: end;
      justify-content: flex-end;
      -webkit-justify-content: flex-end;
      -webkit-box-align: start;
      -webkit-align-items: flex-start;
      -ms-flex-align: start;
      align-items: flex-start;
    }

    .invoice-page .logo-wrapper img {
      max-width: 240px;
      max-height: 120px;
      -o-object-fit: scale-down;
      object-fit: scale-down;
    }

    .invoice-page .logo-wrapper.signature {
      display: flex;
      display: -webkit-flex;
      flex-direction: column;
      -webkit-flex-direction: column;
      align-items: center;
      -webkit-align-items: center;
    }

    .invoice-page .invoice-total-in-words-wrapper {
      flex: 1;
      -webkit-flex: 1;
    }

    .invoice-page .invoice-total-in-words {
      text-transform: uppercase;
    }

    .invoice-page .invoice-bank-and-logo-wrapper {
      display: flex;
      display: -webkit-flex;
      flex-direction: row;
      justify-content: space-between;
      -webkit-flex-direction: row;
      -webkit-justify-content: space-between;
      margin-top: 10px;
    }

    .invoice-page .link-button {
      background: none;
      cursor: pointer;
    }

    .invoice-page .invoice-bank-table {
      border: none;
    }

    .invoice-page .invoice-bank-table th {
      padding: 0 15px 0 0;
      border: none;
    }

    .invoice-page .invoice-bank-table td {
      border: none;
      padding: 0;
    }

    .invoice-page .invoice-terms {
      list-style: decimal !important;
      padding-left: 25px;
    }

    .invoice-page .invoice-payment-table {
      border: none;
    }

    .invoice-page .invoice-payment-table td {
      padding: 0 15px 5px 0;
      border: none;
    }

    .invoice-page .invoice-payment-table th {
      padding: 0 15px 5px 0;
      border: none;
    }

    .invoice-page .invoice-bank-upi-wrapper {
      display: flex;
      display: -webkit-flex;
    }

    .invoice-page .invoice-tag {
      display: inline-block;
      color: rgb(255, 255, 255);
      font-size: 12px;
      white-space: nowrap;
      margin-right: 8px;
      font-weight: 500;
      padding: 0px 5px;
      border-radius: 3px;
    }

    .invoice-page .invoice-tag.success {
      background: #52c41a;
    }

    .invoice-page .invoice-tag.warning {
      background: #faad14;
    }

    .invoice-page .invoice-tag.danger {
      background: #EA453D;
    }

    .invoice-page .invoice-tag.info {
      background: #2db7f5;
    }

    .invoice-page .invoice-tag.devider {
      background: #e8e8e8;
    }

    .invoice-page .secondary-button {
      align-items: center;
      background: -webkit-var(--primary-background, rgb(254, 62, 130));
      background: var(--primary-background, rgb(254, 62, 130));
      border-bottom-left-radius: 4px;
      border-bottom-right-radius: 4px;
      color: rgb(255, 255, 255);
      cursor: pointer;
      display: inline-flex;
      font-size: 15px;
      font-weight: 500;
      height: 35px;
      justify-content: center;
      letter-spacing: normal;
      line-height: 19.5px;
      margin-bottom: 2px;
      margin-left: 2px;
      margin-right: 2px;
      margin-top: 2px;
      padding-bottom: 8px;
      padding-left: 16px;
      padding-right: 16px;
      padding-top: 8px;
      text-align: center;
      text-decoration: none;
    }

    .invoice-page .pay-button-wrapper {
      text-align: center;
    }

    .invoice-page .pay-button-wrapper>small {
      color: rgba(0, 0, 0, 0.50);
    }

    .invoice-page .total-wrapper {
      display: flex;
      display: -webkit-flex;
      margin-top: 10px;
    }

    .invoice-page .invoice-bank-wrapper {
      display: -webkit-flex;
      display: flex;
      flex-direction: column;
      -webkit-flex-direction: column;
      padding: 10px 20px 0 20px;
      border-radius: 6px;
      margin-right: 12px;
      background-color: var(--secondary-background, rgba(101, 57, 192, 0.1));
      -webkit-print-color-adjust: exact;
    }

    .invoice-page .invoice-upi-wrapper {
      display: -webkit-flex;
      display: flex;
      flex-direction: column;
      -webkit-flex-direction: column;
      margin-left: 20px;
      text-align: center;
    }

    .invoice-page .invoice-upi-wrapper>button {
      background: none;
    }

    .invoice-page .invoice-upi-wrapper .upi-heading {
      font-weight: 500;
      font-size: 16.38px;
      font-family: -webkit-var(--title-font, 'Open Sans');
      font-family: var(--title-font, 'Open Sans');
    }

    .invoice-page .invoice-bank-wrapper .bank-heading {
      font-weight: 500;
      font-size: 16.38px;
      font-family: -webkit-var(--title-font, 'Open Sans');
      font-family: var(--title-font, 'Open Sans');
    }

    .invoice-page .qr-wrapper {
      display: -webkit-flex;
      display: flex;
      flex-direction: column;
      -webkit-flex-direction: column;
    }

    .invoice-page .qr-wrapper>img {
      margin: 0 auto;
    }

    .invoice-page .qr-wrapper>span {
      font-size: 10px;
    }

    .invoice-page .invoice-table {
      overflow: hidden;
      border-radius: 2px;
      border-style: hidden;
      box-shadow: none;
      margin-bottom: 10px;
    }

    .invoice-page.invoice-table tbody th {
      text-align: left;
      vertical-align: top;
    }

    .invoice-page .invoice-items-table {
      border: 0;
      box-shadow: none;
      overflow: hidden;
      border-style: hidden;
      margin: 0 0 10px;
      width: 100%;
      border-radius: 6px;
      border-color: -webkit-var(--primary-color, rgba(101, 57, 192, 1));
      border-color: var(--primary-color, rgba(101, 57, 192, 1));
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
      box-shadow: 0 0 0 1px rgba(101, 57, 192, 0.1);
    }

    .invoice-page .invoice-items-table th {
      color: #fff;
      text-shadow: 0 0 #fff;
      background: -webkit-var(--primary-background, rgba(101, 57, 192, 1));
      background: var(--primary-background, rgba(101, 57, 192, 1));
      padding: 5px 5px 5px 10px;
      border: 0;
      border-color: -webkit-var(--primary-color, rgba(101, 57, 192, 1));
      border-color: var(--primary-color, rgba(101, 57, 192, 1));
      text-align: center;
      font-family: -webkit-var(--title-font, 'Open Sans');
      font-family: var(--title-font, 'Open Sans');
    }

    .invoice-page .invoice-items-table td {
      padding: 10px;
      border: 0;
      background: -webkit-var(--secondary-background, rgba(101, 57, 192, 0.1));
      background: var(--secondary-background, rgba(101, 57, 192, 0.1));
      vertical-align: middle;
      text-align: center;
      white-space: nowrap;
    }

    .invoice-page .invoice-items-table td:first-child {
      padding-left: 10px;
    }

    .invoice-page .invoice-items-table td:nth-child(2) {
      white-space: normal;
    }

    .invoice-page .invoice-items-table input,
    .invoice-page .invoice-items-table textarea {
      padding: 4px 0;
      font-size: 14px;
      line-height: 20px;
      min-height: 40px;
    }

    .invoice-page .custom-column {
      white-space: normal !important;
    }

    .invoice-page .invoice-totals-table {
      width: 100%;
      border: none;
    }

    .invoice-page .invoice-extra-total-table {
      width: 100%;
      border: none;
    }

    .invoice-page .invoice-extra-total-table td,
    .invoice-page .invoice-extra-total-table th {
      padding: 2px 15px;
      border: none;
    }

    .invoice-page .invoice-extra-total-table td:last-child,
    .invoice-page .invoice-extra-total-table th:last-child {
      text-align: right;
    }

    .invoice-page .invoice-totals-table tr:last-child th,
    .invoice-page .invoice-totals-table tr:last-child td {
      border-top: solid 1px black;
    }

    .invoice-page .invoice-totals-table td,
    .invoice-page .invoice-totals-table th {
      padding: 2px 15px;
      border: none;
    }

    .invoice-page .invoice-totals-table td:last-child,
    .invoice-page .invoice-totals-table th:last-child {
      text-align: right;
    }

    .invoice-page .item-name-row {
      display: none;
    }

    .invoice-page .hide-background>td {
      background: none;
    }

    .invoice-page .item-name-row.full-width {
      display: table-row !important;
    }

    .invoice-page .item-name-row>td {
      text-align: left !important;
      white-space: normal;
      padding-bottom: 0;
    }

    .invoice-page .small-item-row {
      display: none;
    }

    .invoice-page .small-item-row td:first-child {
      width: auto;
    }

    .invoice-page .large-item-row th:first-child,
    .invoice-page .large-item-row th:nth-child(2) {
      text-align: left;
    }

    .invoice-page .large-item-row td:first-child,
    .invoice-page .large-item-row td:nth-child(2) {
      text-align: left;
    }

    .invoice-page .large-item-row.gst-invoice td:first-child,
    .invoice-page .large-item-row.gst-invoice th:first-child,
    .invoice-page .large-item-row.gst-invoice td:nth-child(2),
    .invoice-page .large-item-row.gst-invoice th:nth-child(2) {
      display: table-cell;
    }

    .invoice-page .large-item-row.full-width td:first-child,
    .invoice-page .large-item-row.full-width th:first-child,
    .invoice-page .large-item-row.full-width td:nth-child(2),
    .invoice-page .large-item-row.full-width th:nth-child(2) {
      display: none !important;
    }

    .invoice-page .large-item-row.description td {
      white-space: pre-wrap;
      text-align: left;
    }

    .invoice-page .large-item-row.description div {
      max-width: 75%;
    }


    .invoice-page .early-pay-wrapper {
      background-image: url('/public/images/invoice/earlypay/bannerbg.png');
      margin: -10px -10px 20px -10px;
      padding: 32px;
      color: #fff;
    }

    .invoice-page .early-pay-wrapper p {
      margin-top: 8px;
    }

    .invoice-page .center-align-text {
      text-align: center;
    }

    .invoice-page .early-pay-heading {
      display: inline-flex;
    }

    .invoice-page .early-pay-heading svg {
      width: 48px;
      height: 48px;
      margin-left: -5px;
    }

    .invoice-page .early-pay-heading>div {
      display: flex;
      align-items: center;
      text-align: left;
    }

    .invoice-page .early-pay-heading>div>strong {
      display: inline-block;
      padding-left: 5px;
      font-size: 22px;
      font-weight: 600;
    }

    .invoice-page .large-text {
      font-size: 16px;
      display: inline-block;
      margin-bottom: 4px;
    }

    .invoice-page .large-text>span {
      font-size: 22px;
    }

    .invoice-page .small-text {
      font-size: 14px;
      opacity: 0.7;
      display: inline-block;
      margin-bottom: 4px;
    }

    .invoice-page .invoice-status {
      display: flex;
    }

    .invoice-page .invoice-status>span {
      padding: 0 5px !important;
      font-size: 12px !important;
      margin-right: 8px !important;
      font-weight: 500 !important;
    }

    .invoice-page .responsive-image {
      max-width: 100%;
      max-height: 100%;
      height: auto;
    }

    .invoice-page .page-footer {
      width: 100%;
      text-align: center;
      font-size: 10px;
    }

    .invoice-page .attachment-link {
      text-align: left;
      margin-bottom: 4px;
      background: none;
    }

    .invoice-page .bank-total-wrapper {
      display: -webkit-flex;
      display: flex;
      justify-content: space-between;
      -webkit-justify-content: space-between;
      page-break-inside: avoid;
    }

    .invoice-page .bank-total-wrapper .bank-words-wrapper {
      display: -webkit-flex;
      display: flex;
      flex-direction: column;
      -webkit-flex-direction: column;
    }

    .invoice-page .bank-total-wrapper .total-signature-wrapper {
      display: -webkit-flex;
      display: flex;
      flex-direction: column;
      -webkit-flex-direction: column;
    }

    .invoice-page .bank-total-wrapper .bank-words-wrapper .invoice-total-in-words-wrapper {
      margin-bottom: 30px;
      font-weight: 600;
    }

    .invoice-page .attachment-wrapper {
      margin-top: 20px;
    }

    .invoice-page .invoice-notes-wrapper {
      margin-top: 20px;
    }

    .invoice-page .invoice-notes-wrapper p {
      white-space: pre-line;
      -webkit-white-space: pre-line;
      orphans: 3;
      widows: 3;
    }

    .invoice-page .invoice-terms-wrapper {
      margin-top: 20px;
    }

    .invoice-page .invoice-payments-wrapper {
      margin-top: 20px;
    }

    .invoice-page .terms-heading {
      margin-bottom: 0.2rem;
      font-size: 16.38px;
      font-family: -webkit-var(--title-font, 'Open Sans');
      font-family: var(--title-font, 'Open Sans');
      page-break-inside: avoid;
    }

    .invoice-page .terms-heading::after {
      content: '';
      display: block;
      height: 80px;
      margin-bottom: -80px;
    }

    .invoice-page .invoice-terms>li {
      page-break-inside: avoid;
    }

    .invoice-page .payments-heading {
      margin-bottom: 0.2rem;
      font-size: 16.38px;
      font-family: -webkit-var(--title-font, 'Open Sans');
      font-family: var(--title-font, 'Open Sans');
      page-break-inside: avoid;
    }

    .invoice-page .payments-heading::after {
      content: '';
      display: block;
      height: 80px;
      margin-bottom: -80px;
    }

    .invoice-page .notes-heading {
      margin-bottom: 0.2rem;
      font-size: 16.38px;
      font-family: -webkit-var(--title-font, 'Open Sans');
      font-family: var(--title-font, 'Open Sans');
      page-break-inside: avoid;
    }

    .invoice-page .notes-heading::after {
      content: '';
      display: block;
      height: 80px;
      margin-bottom: -80px;
    }

    .invoice-page .attachment-heading {
      margin-bottom: 0.2rem;
      font-size: 16.38px;
      font-family: -webkit-var(--title-font, 'Open Sans');
      font-family: var(--title-font, 'Open Sans');
    }

    .invoice-page .attachment-link-wrapper {
      display: -webkit-flex;
      display: flex;
      flex-direction: column;
      -webkit-flex-direction: column;
    }

    .invoice-page .invoice-contact-wrapper {
      text-align: center;
      margin-top: 20px;
    }

    .invoice-page .address-section-transport .extra {
      margin-top: 10px;
    }

    .invoice-page .link {
      background: none;
    }

    /* Media Query */

    @media print {
      .no-pdf {
        display: none;
      }

      .show-in-pdf {
        display: block !important;
      }

      .invoice-page .early-pay-wrapper {
        display: none;
      }

      .invoice-page .invoice-bank-wrapper {
        margin-top: 10px;
        padding: 10px 20px 0 20px;
        border-radius: 6px;
        margin-right: 12px;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
        background-color: var(--secondary-background, rgba(101, 57, 192, 0.1));
      }

      .invoice-page .invoice-bank-wrapper .bank-heading>button {
        display: none;
      }

      .invoice-page .invoice-upi-wrapper .upi-heading>button {
        display: none;
      }
    }

    @media screen and (max-width: 768px) {
      .invoice-page .invoice-bank-upi-wrapper {
        flex-direction: column;
        align-items: flex-start;
      }
    }

    @media screen and (max-width: 568px) {
      .invoice-page .invoice-header {
        flex-direction: column-reverse;
      }

      .invoice-page .logo-wrapper {
        margin: 0 auto;
      }

      .invoice-page .address-section-wrapper {
        flex-direction: column;
      }

      .invoice-page .shipped-section-wrapper {
        flex-direction: column;
      }

      .invoice-page .invoice-bank-and-logo-wrapper {
        flex-direction: column-reverse;
        justify-content: space-between;
      }

      .invoice-page .item-name-row>td {
        padding-bottom: 10px;
      }

      .invoice-page .small-item-row {
        display: table-row;
      }

      .invoice-page .small-item-row.full-width td {
        padding-top: 0;
      }

      .invoice-page .small-item-row.full-width td:first-child {
        font-weight: 600;
      }

      .invoice-page .invoice-items-table td {
        text-align: left;
      }

      .invoice-page .invoice-items-table th {
        text-align: left;
      }

      .invoice-page .large-item-row {
        display: none;
      }

      .invoice-page .large-item-row.gst-invoice td:first-child,
      .invoice-page .large-item-row.gst-invoice th:first-child,
      .invoice-page .large-item-row.gst-invoice td:nth-child(2),
      .invoice-page .large-item-row.gst-invoice th:nth-child(2) {
        display: none;
      }

      .invoice-page .early-pay-heading>div>strong {
        font-size: 28px;
      }

      .invoice-page .invoice-bank-table th {
        padding-right: 10px;
      }

      .invoice-page .invoice-head-table {
        width: 100%;
      }

      .invoice-page .invoice-head-table th {
        padding-right: 0;
      }

      .invoice-page .invoice-header .logo-wrapper {
        margin-top: 0;
      }

      .invoice-page .bank-total-wrapper {
        flex-direction: column-reverse;
      }

      .invoice-page .invoice-bank-wrapper {
        margin-top: 10px;
        padding: 10px 20px 0 20px;
        border-radius: 6px;
        -webkit-print-color-adjust: exact;
        background-color: var(--secondary-background, rgba(101, 57, 192, 0.1));
      }

      .invoice-page .invoice-bank-upi-wrapper {
        flex-direction: column;
      }

      .invoice-page .invoice-upi-wrapper {
        margin-left: 0;
        margin-top: 10px;
        text-align: left;
      }

      .invoice-page .qr-wrapper>img {
        margin: 0;
      }

      .invoice-page .invoice-upi-wrapper>button {
        text-align: left;
        padding-left: 10px;
      }

      .invoice-page .logo-wrapper img {
        max-width: 180px;
      }

      .invoice-page .item-name-row {
        display: table-row;
      }

      .invoice-page .address-section-billed-by {
        margin-right: 0;
      }

      .invoice-page .address-section-billed-to {
        margin-left: 0;
      }

      .invoice-page .address-section-shipped-to {
        margin-right: 0;
        max-width: 100%;
      }

      .invoice-page .address-section-transport {
        max-width: 100%;
      }

      .invoice-page .invoice-payment-table-scroll {
        overflow-x: auto;
        padding: 0;
      }
    }

    @media screen and (max-width: 992px) {
      .invoice-page .invoice-items-table-wrapper {
        overflow-x: auto;
        padding: 0 1px;
      }

      .invoice-page .item-name-row.gst-invoice {
        display: table-row;
      }

      .invoice-page .large-item-row.gst-invoice td:first-child,
      .invoice-page .large-item-row.gst-invoice th:first-child,
      .invoice-page .large-item-row.gst-invoice td:nth-child(2),
      .invoice-page .large-item-row.gst-invoice th:nth-child(2) {
        display: none;
      }
    }

    @media screen and (max-width: 768px) {

      .invoice-page .large-item-row.gst-invoice td:first-child,
      .invoice-page .large-item-row.gst-invoice th:first-child,
      .invoice-page .large-item-row.gst-invoice td:nth-child(2),
      .invoice-page .large-item-row.gst-invoice th:nth-child(2) {
        display: none;
      }
    }

    @media screen and (min-width: 992px) and (max-width: 1200px) {
      .invoice-page .item-name-row.aside-collpased {
        display: none;
      }

      .invoice-page .large-item-row.aside-collpased td:first-child,
      .invoice-page .large-item-row.aside-collpased th:first-child,
      .invoice-page .large-item-row.aside-collpased td:nth-child(2),
      .invoice-page .large-item-row.aside-collpased th:nth-child(2) {
        display: table-cell;
      }
    }

    @media (min-width: 768px) {
      .invoice-page .early-pay-wrapper {
        margin: -48px -48px 20px -48px;
      }
    }
  </style>
@endpush
