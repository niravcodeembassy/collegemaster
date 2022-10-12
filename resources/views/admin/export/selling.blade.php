<table>
  <thead>
    <tr>
      <th colspan="5">
        <h2 style="text-align: center">{{ $title }}</h2>
      </th>
    </tr>
    <tr>
      <th>Product Name</th>
      <th>Product Sku</th>
      <th>Product Size</th>
      <th>Product Material</th>
      <th>Quantity Sold</th>
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
        }
      @endphp
      <tr>
        <td>{{ $list->name }}</td>
        <td>{{ $list->sku }}</td>
        @foreach ($attributes as $key => $attribute)
          <td>{{ $attribute ?? '' }}</td>
        @endforeach
        <td>{{ str_replace('.00', ' ', $list->quantity_sold) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
