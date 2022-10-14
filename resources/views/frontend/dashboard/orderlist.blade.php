@extends('frontend.layouts.app')

@push('css')
  <link href="{{ asset('front/assets/css/order-list.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
  @include('frontend.layouts.banner', [
      'pageTitel' => 'Orders' ?? '',
  ])

  <section class="section-b-space">
    <div class="container">
      <div class="row  mt-80 mb-80">
        @include('frontend.dashboard.sidebar', ['class' => 'col-lg-3'])
        <div class="col-lg-9">
          <div class="dashboard-right">
            <h3 class="pl-4 mt-lg-0 mt-4">ORDER LIST</h3>
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
                          | Date : <span class="sl-date text-behance">{{ $item->created_at->format('m-d-Y H:i:s') ?? '---' }} (IST) </span>
                          {{-- @isset($item->order_status)
                            <small class="text-muted d-block f-12 pt-2">Order Status</small>
                            @php
                              $status = null;
                              if ($item->order_status == 'order_placed') {
                                  $status = 'New';
                              } elseif ($item->order_status == 'delivered') {
                                  $status = 'Completed';
                              } elseif ($item->order_status == 'customer_approval') {
                                  $status = 'Approval';
                              } elseif ($item->order_status == 'work_in_progress') {
                                  $status = 'Designing';
                              } elseif ($item->order_status == 'dispatched') {
                                  $status = 'Shipped';
                              } else {
                                  $status = $item->order_status;
                              }
                            @endphp
                            <h6 class="mb-0">{{ ucwords(str_replace('_', ' ', $status)) }}</h6>
                          @endisset
                          @isset($item->payment_type)
                            <small class="text-muted d-block pt-2 f-12">Payment Mode</small>
                            <h6 class="mb-0">{{ ucfirst($item->payment_type) }}</h6>
                          @endisset --}}
                        </a>

                        @php
                          $order_placed = 'complete';
                          $pic_receive = '';
                          $work_in_progress = '';
                          $customer_approval = '';
                          $printing = '';
                          $delivered = '';
                          $correction = '';
                          $order_content = 'Your item has been placed';
                          if ($item->order_status == 'pick_not_receive') {
                              $pic_receive = 'complete';
                              $order_content = 'Your item has been waiting for Pictures';
                          }
                          if ($item->order_status == 'work_in_progress') {
                              $pic_receive = 'complete';
                              $work_in_progress = 'complete';
                              $order_content = 'Your item has been Designing';
                          }
                          if ($item->order_status == 'correction') {
                              $pic_receive = 'complete';
                              $work_in_progress = 'complete';
                              $correction = 'complete';
                              $order_content = 'Your item has been Changes';
                          }
                          if ($item->order_status == 'customer_approval') {
                              $pic_receive = 'complete';
                              $work_in_progress = 'complete';
                              $customer_approval = 'complete';
                              $correction = 'complete';
                              $order_content = 'Your item has been Design Approval';
                          }

                          if ($item->order_status == 'printing') {
                              $pic_receive = 'complete';
                              $work_in_progress = 'complete';
                              $customer_approval = 'complete';
                              $printing = 'complete';
                              $correction = 'complete';
                              $order_content = 'Your item has been Printing';
                          }
                          if ($item->order_status == 'delivered') {
                              $pic_receive = 'complete';
                              $work_in_progress = 'complete';
                              $customer_approval = 'complete';
                              $printing = 'complete';
                              $correction = 'complete';
                              $delivered = 'complete';
                              $order_content = 'Your item has been Dispactched';
                          }
                        @endphp
                        {{-- d-none d-md-flex d-lg-flex --}}
                        <ul class="timeline d-md-flex d-lg-flex d-sm-blok" id="timeline">
                          <li class="li {{ $order_placed }}">
                            <div class="timestamp">
                              <span class="order_status">Order Received</span>
                            </div>
                            <div class="status">
                              <h4></h4>
                            </div>
                          </li>
                          <li class="li {{ $pic_receive }}">
                            <div class="timestamp">
                              <span class="order_status">Wating for Picture</span>
                            </div>
                            <div class="status">
                              <h4>
                                {{-- {{ isset($item->receive_date) ? date('D, jS  M', strtotime($item->receive_date)) : '' }} --}}
                              </h4>
                            </div>
                          </li>
                          <li class="li {{ $work_in_progress }}">
                            <div class="timestamp">
                              <span class="order_status">Picture Received</span>
                            </div>
                            <div class="status">
                              <h4>
                                {{-- {{ isset($item->receive_date) ? date('D, jS  M', strtotime($item->receive_date)) : '' }} --}}
                              </h4>
                            </div>
                          </li>
                          <li class="li {{ $work_in_progress }}">
                            <div class="timestamp">
                              <span class="order_status">Designing</span>
                            </div>
                            <div class="status">
                              <h4>
                                {{-- {{ isset($item->design_date) ? date('D, jS  M', strtotime($item->design_date)) : '' }} --}}
                              </h4>
                            </div>
                          </li>
                          @if ($item->order_status == 'correction')
                            <li class="li {{ $correction }}">
                              <div class="timestamp">
                                <span class="order_status">Correction</span>
                              </div>
                              <div class="status">
                                <h4>
                                  {{-- {{ isset($item->design_date) ? date('D, jS  M', strtotime($item->design_date)) : '' }} --}}
                                </h4>
                              </div>
                            </li>
                          @endif
                          <li class="li {{ $customer_approval }}">
                            <div class="timestamp">
                              <span class="order_status">Approval</span>
                            </div>
                            <div class="status">
                              <h4>
                                {{-- {{ isset($item->approval_date) ? date('D, jS  M', strtotime($item->approval_date)) : '' }} --}}
                              </h4>
                            </div>
                          </li>
                          <li class="li {{ $printing }}">
                            <div class="timestamp">
                              <span class="order_status">Printing</span>
                            </div>
                            <div class="status">
                              <h4>
                                {{-- {{ isset($item->printing_date) ? date('D, jS  M', strtotime($item->printing_date)) : '' }} --}}
                              </h4>
                            </div>
                          </li>
                          <li class="li {{ $delivered }}">
                            <div class="timestamp">
                              <span class="order_status">Dispatch</span>
                            </div>
                            <div class="status">
                              <h4>
                                {{-- {{ isset($item->dispatch_date) ? date('D, jS  M', strtotime($item->dispatch_date)) : '' }} --}}
                              </h4>
                            </div>
                          </li>
                        </ul>
                        <p class="mx-4 h6 order_msg_content"> {{ $order_content ?? '' }}</p>
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
