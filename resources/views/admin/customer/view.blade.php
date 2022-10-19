@extends('admin.layouts.app')

@section('title', $title)

@section('content')
  @component('component.heading',
      [
          'page_title' => 'Customer Details',
          'icon' => 'fa fa-user-astronaut',
          'tagline' => 'Lorem ipsum dolor sit amet.',
          'action' => route('admin.customer.index'),
          'action_icon' => 'fa fa-arrow-left',
          'text' => 'Back',
      ])
  @endcomponent

  <div class="row">
    <div class="col-lg-4 col-md-5">
      <div class="card">
        <div class="card-body">
          <div class="text-center">
            <img src="{{ $customer->profile_src }}" class="rounded-circle" width="150">
            <h4 class="mt-3">{{ $customer->name }}</h4>
            <div class="row text-center justify-content-md-center">
              <div class="col-4">
                <a href="javascript:void(0)" class="link"><i class="fa fa-truck f-18"></i>
                  <font class="font-medium f-18"> {{ $customer->orders->count() ?? 0 }}</font>
                </a>
              </div>
            </div>
          </div>
        </div>
        <hr class="mb-0">
        <div class="card-body">
          <small class="text-muted d-block">Email address </small>
          <h6>{{ $customer->email ?? '' }}</h6>
          <small class="text-muted d-block pt-10">Phone</small>
          <h6>{{ $customer->phone ?? '' }}</h6>
          @if (isset($customer->country))
            <small class="text-muted d-block pt-10">Country</small>
            <h6>{{ $customer->country->name ?? '' }}</h6>
          @endif
        </div>
      </div>
    </div>
    <div class="col-lg-8 col-md-7">
      <div class="card">
        <div class="tab-content" id="pills-tabContent">
          <div class="card-body">

            @if ($customer->orders->count() > 0)
              <div class="profiletimeline mt-0">
                @foreach ($customer->orders as $item)
                  <div class="sl-item">
                    <div class="sl-right">
                      <a href="{{ route('admin.order.show', $item->id) }}" class="link text-primary ">
                        Order No. {{ $item->order_number ?? '---' }}
                        <span class="sl-date   text-behance">{{ $item->created_at->format('d-m-Y') ?? '---' }}
                        </span>
                        @isset($item->order_status)
                          <small class="text-muted  d-block f-12 pt-2">Order Status</small>
                          <h6 class="mb-0 text-muted">
                            {{ ucfirst(str_replace('_', ' ', $item->order_status)) }}</h6>
                        @endisset
                        @isset($item->payment_type)
                          <small class="text-muted d-block pt-2 f-12">Payment Mode</small>
                          <h6 class="mb-0 text-muted">{{ ucfirst($item->payment_type) }}</h6>
                        @endisset
                      </a>
                    </div>

                  </div>
                  @if (!$loop->last)
                    <hr>
                  @endif
                @endforeach
              </div>
            @else
              <h4> User has no orders.</h4>
            @endif
          </div>

        </div>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
  <script type="text/javascript">
    var table = $('#CustomerTable').DataTable({
      "processing": true,
      "serverSide": true,
      "stateSave": true,
      "lengthMenu": [10, 25, 50],
      "responsive": true,
      // "iDisplayLength": 2,
      "ajax": {
        "url": $('#CustomerTable').attr('data-url'),
        "dataType": "json",
        "type": "POST",
        "data": function(d) {
          return $.extend({}, d, {});
        }
      },
      "order": [
        [0, "desc"]
      ],
      "columns": [{
          "data": "name"
        },
        {
          "data": "email"
        },
        {
          "data": "phone"
        },
        {
          "data": "action"
        }
      ]
    });
  </script>
@endpush
