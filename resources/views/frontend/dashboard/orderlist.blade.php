@extends('frontend.layouts.app')

@push('style')
@endpush
@push('style')
  <style style="text/css">
    .profiletimeline {
      position: relative;
      padding-left: 40px;
      margin: 40px 10px 0 30px;
      border-left: 1px solid rgba(0, 0, 0, 0.1);
    }

    .profiletimeline .sl-item .sl-left {
      float: left;
      margin-left: -60px;
      z-index: 1;
      margin-right: 15px;
    }
  </style>
@endpush

@section('content')


  @include('frontend.layouts.banner', [
      'pageTitel' => 'Orders' ?? '',
  ])

  <section class="section-b-space">
    <div class="container ">
      <div class="row  mt-80 mb-80">
        @include('frontend.dashboard.sidebar')
        <div class="col-lg-9">
          <div class="dashboard-right">
            <h3 class="pl-4">ORDER LIST</h3>
            <div class="dashboard ">
              @if (isset($customer->orders) && $customer->orders->count() > 0)
                <div class="profiletimeline">
                  @foreach ($customer->orders as $item)
                    <div class="sl-item">
                      <div class="sl-left">
                        <button type="button" class="btn social-btn btn-facebook">
                          <i class="ti-truck text-success"></i>
                        </button>
                      </div>

                      <div class="sl-right">
                        <a href="{{ route('orders.show', $item->id) }}" class="link call-modals" data-url="{{ route('orders.show', $item->id) }}" data-target-modal="#orderdetails" data-target="#orderdetails"> Order No :
                          {{ $item->order_number ?? '---' }}
                          | Date : <span class="sl-date text-behance">{{ $item->created_at->format('m-d-Y H:i:s') ?? '---' }} </span>
                          @isset($item->order_status)
                            <small class="text-muted d-block f-12 pt-2">Order Status</small>
                            <h6 class="mb-0">{{ ucfirst(str_replace('_', ' ', $item->order_status)) }}</h6>
                          @endisset
                          @isset($item->payment_type)
                            <small class="text-muted d-block pt-2 f-12">Payment Mode</small>
                            <h6 class="mb-0">{{ ucfirst($item->payment_type) }}</h6>
                          @endisset
                        </a>
                      </div>

                    </div>
                    <hr class="m-3">
                  @endforeach

                </div>
              @else
                <h4 class="pl-4">You have no order</h4>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="modal fade" id="orderdetails">
    <div class="modal-dialog" style="max-width:1080px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Order Details</h5>
          <i class="ti-close pt-2" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" data-msg-required="Category is required."></i>
          {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span --}}
          {{-- aria-hidden="true"  data-msg-required="Category is required." ></span></button> --}}
        </div>
        <div id="load-modal"></div>

      </div>
    </div>
  </div>

@endsection
