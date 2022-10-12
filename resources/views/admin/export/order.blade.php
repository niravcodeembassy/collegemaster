<table>
  <thead>
    <tr>
      <th colspan="21">
        <h2 style="text-align: center">ORDER GST REPORT</h2>
      </th>
    </tr>
    <tr>
      <th>FIRST NAME</th>
      <th>LAST NAME</th>
      <th>MOBILE NO</th>
      <th>SHIPPING ADDRESS</th>
      <th>COUNTRY</th>
      <th>DATE</th>
      <th>ORDER NO</th>
      <th>ITEM NAME</th>
      <th>SIZE</th>
      <th>MATERIAL</th>
      <th>QUANTITY</th>
      <th>GST %</th>
      <th>RATE</th>
      <th>DISCOUNT</th>
      <th>NET AMOUNT</th>
      <th>CGST AMOUNT</th>
      <th>SGST AMOUNT</th>
      <th>IGST AMOUNT</th>
      <th>SUB TOTAL</th>
      <th>SHIPPING AMOUNT</th>
      <th>TOTAL AMOUNT</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($items as $key => $list)
      @php
        $attributes = [];
        $raw_data = [];

        if ($list->attribute != null) {
            $attributes = json_decode($list->attribute, true);
        }
        if ($list->raw_data != null) {
            $raw_data = json_decode($list->raw_data, true);
            $raw_data = (object) $raw_data;
        }

        $cgst = '$ ' . 0.0;
        $sgst = '$ ' . 0.0;
        $igst = '$ ' . 0.0;

        if (isset($list->order->address)) {
            $order_address = $list->order->address;
            $address = json_decode($order_address);
            $shipping = $address->shipping_address;
            $settingState = $setting->state;
            $shippingState = $shipping->state;

            $type = 'gst';
            if (strtolower(trim($settingState)) != strtolower(trim($shippingState))) {
                $type = 'igst';
            }

            if ($type == 'gst') {
                $cgst = Helper::showPrice($raw_data->tax / 2, $list->order->currency, $list->order->currency);
                $sgst = Helper::showPrice($raw_data->tax / 2, $list->order->currency, $list->order->currency);
            }

            if ($type == 'igst') {
                $igst = Helper::showPrice($raw_data->tax, $list->order->currency, $list->order->currency);
            }

            $adr = null;
            if ($shipping->address_one) {
                $adr = $shipping->address_one;
            }
            if ($shipping->address_two) {
                $adr .= ', ' . $shipping->address_two;
            }
            $adr .= ', ' . $shipping->city . '-' . $shipping->postal_code . ', ' . $shipping->state;
        }
      @endphp
      <tr>
        <td>{{ $list->order->user->first_name ?? '' }}</td>
        <td>{{ $list->order->user->last_name ?? '' }}</td>
        <td>{{ $list->order->user->phone ?? '' }}</td>
        <td>{{ $adr ?? '' }}</td>
        <td>{{ isset($shipping->country) ? $shipping->country : '' }}</td>
        <td>{{ isset($list->order) ? date('d-m-Y', strtotime($list->order->created_at)) : '' }}</td>
        <td>{{ $list->order->order_no ?? '' }}</td>
        <td>{{ $list->name ?? '' }}</td>
        @foreach ($attributes as $key => $attribute)
          <td>{{ $attribute ?? '' }}</td>
        @endforeach
        <td>{{ $raw_data->qty }}</td>
        <td>{{ $raw_data->tax_percentage }} %</td>
        <td>{!! Helper::showPrice($raw_data->price ?? 0, $list->order->currency, $list->order->currency) !!}</td>
        <td>{!! Helper::showPrice($raw_data->discount ?? 0, $list->order->currency, $list->order->currency) !!}</td>
        <td>{!! Helper::showPrice($raw_data->taxable_price, $list->order->currency, $list->order->currency) !!}</td>
        <td>{{ $cgst }}</td>
        <td>{{ $sgst }}</td>
        <td>{{ $igst }}</td>
        <td>{!! Helper::showPrice($raw_data->price ?? 0, $list->order->currency, $list->order->currency) !!}</td>
        <td>{!! Helper::showPrice($list->order->shipping_charge, $list->order->currency) !!}</td>
        <td>{!! Helper::showPrice($list->order->total ?? 0, $list->order->currency) !!}</td>
      </tr>
    @endforeach
  </tbody>
</table>
