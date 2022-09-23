@extends('admin.layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-info"><i class="fa fa-user-astronaut"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Customer</span>
          <span class="info-box-number">{{ $customer }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-success"><i class="far fa fa-shopping-bag"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Orders</span>
          <span class="info-box-number">{{ $totalOrders }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-primary"><i class="far fa fa-bookmark"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Today Orders</span>
          <span class="info-box-number">{{ $todayOrder ?? 0 }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-danger"><i class="far fa-money-bill-alt"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Revenue</span>
          <span class="info-box-number">₹ {{ $revenue ?? 0 }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <div class="row mt-5">
    <div class="col-lg-12 col-sm-12">
      <div class="card">
        <div class="card-header border-transparent">
          <h3 class="card-title">Latest Orders</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table m-0">
              <thead>
                <tr>
                  <th style="width: 33%">Order ID</th>
                  <th style="width: 33%">Status</th>
                  <th style="width: 33%">Payment Mode</th>
                </tr>
              </thead>
              <tbody>
                @if ($orders->count() > 0)
                  @foreach ($orders as $item)
                    <tr>
                      <td><a href="{{ route('admin.order.show', $item->id) }}" class="link text-primary "> Order No. {{ $item->order_number ?? '---' }}</a></td>
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
                      <td>{{ ucwords(str_replace('_', ' ', $status)) }}</td>
                      <td>{{ ucfirst($item->payment_type) }}</td>
                    </tr>
                  @endforeach
                @else
                  </tr>
                  <td colspan="3" class="text-center">You have no order</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
          <a href="{{ route('admin.order.index') }}" class="btn btn-sm btn-secondary float-right">View All Orders</a>
        </div>
        <!-- /.card-footer -->
      </div>
    </div>
    {{-- <div class="col-lg-6 col-sm-12">
        <div class="card text-left">
          <div class="card-body">
            <h4 class="card-title">Title</h4>
            <p class="card-text">Body</p>
          </div>
        </div>
    </div> --}}
  </div>
@endsection
