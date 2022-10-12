<table>
  <thead>
    <tr>
      <th colspan="12">
        <h2 style="text-align: center">REFUND REPORT</h2>
      </th>
    </tr>
    <tr>
      <th>FIRST NAME</th>
      <th>LAST NAME</th>
      <th>EMAIL</th>
      <th>MOBILE NO</th>
      <th>SHIPPING ADDRESS</th>
      <th>COUNTRY</th>
      <th>DATE</th>
      <th>ORDER NO</th>
      <th>REFUND TRANSACTION ID</th>
      {{-- <th>ITEM NAME</th>
      <th>SIZE</th>
      <th>MATERIAL</th>
      <th>QUANTITY</th>
      <th>GST %</th>
      <th>RATE</th>
      <th>DISCOUNT</th>
      <th>NET AMOUNT</th>
      <th>CGST AMOUNT</th>
      <th>SGST AMOUNT</th>
      <th>IGST AMOUNT</th> --}}
      <th>SUB TOTAL</th>
      <th>SHIPPING AMOUNT</th>
      <th>TOTAL AMOUNT</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($items as $key => $list)
      @php

        if (isset($list->address)) {
            $order_address = $list->address;
            $address = json_decode($order_address);
            $shipping = $address->shipping_address;
            $settingState = $setting->state;
            $shippingState = $shipping->state;

            $type = 'gst';
            if (strtolower(trim($settingState)) != strtolower(trim($shippingState))) {
                $type = 'igst';
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
        <td>{{ $list->user->first_name ?? '' }}</td>
        <td>{{ $list->user->last_name ?? '' }}</td>
        <td>{{ $list->user->email ?? '' }}</td>
        <td>{{ $list->user->phone ?? '' }}</td>
        <td>{{ $adr ?? '' }}</td>
        <td>{{ isset($shipping->country) ? $shipping->country : '' }}</td>
        <td>{{ isset($list) ? date('d-m-Y', strtotime($list->created_at)) : '' }}</td>
        <td>{{ $list->order_no ?? '' }}</td>
        <td>{{ $list->refund_transaction_id ?? '' }}</td>
        <td>{!! Helper::showPrice($list->subtotal ?? 0, $list->currency, $list->currency) !!}</td>
        <td>{!! Helper::showPrice($list->shipping_charge, $list->currency) !!}</td>
        <td>{!! Helper::showPrice($list->total ?? 0, $list->currency) !!}</td>
      </tr>
    @endforeach
  </tbody>
</table>
