<table>
  <thead>
    <tr>
      <th colspan="6">
        <h2 style="text-align: center">CUSTOMER REPORT</h2>
      </th>
    </tr>
    <tr>
      <th>NAME</th>
      <th>EMAIL</th>
      <th>MOBILE NO</th>
      <th>COUNTRY</th>
      <th>SIGNUP DATE AND TIME</th>
      <th>ORDER</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($customer as $key => $item)
      <tr>
        <td>{{ $item->name ?? '-' }}</td>
        <td>{{ $item->email ?? '-' }}</td>
        <td>{{ $item->phone ?? '-' }}</td>
        <td>{{ isset($item->country) ? $item->country->name : '-' }}</td>
        <td>{{ date('d-m-Y H:i:s', strtotime($item->created_at)) }}</td>
        <td>{{ $item->orders_count }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
