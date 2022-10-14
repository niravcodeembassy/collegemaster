@extends('admin.layouts.app')

@push('css')
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('style')
  <style>
    #size_daterangepicker {
      background-color: #fff !important;
    }

    #material_daterangepicker {
      background-color: #fff !important;
    }

    #variant_daterangepicker {
      background-color: #fff !important;
    }

    #country_daterangepicker {
      background-color: #fff !important;
    }

    .size_cancel,
    .material_cancel,
    .variant_cancel,
    .country_cancel {
      left: 310px;
      top: 12px;
      background-color: white;
    }
  </style>
@endpush

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
                        } elseif ($item->order_status == 'pick_not_receive') {
                            $status = 'Waiting for Pic';
                        } elseif ($item->order_status == 'correction') {
                            $status = 'Changes';
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

  <div class="row">
    <div class="col-md-5 mt-4">
      <h5>Best Selling Size</h5>
      <div class="card p-4" style="height:480px;">
        <div class="w-75 mb-4 position-relative">
          <input class="form-control" readonly placeholder="Pick date range" id="size_daterangepicker" data-url="{{ route('admin.size.chart') }}" />
          <i class="fa fa-times-circle size_cancel text-secondary position-absolute" style="display: none;"></i>
        </div>
        <h5 class="size_heading text-center" style="display: none">Data Not Found</h5>
        <canvas id="size_pie_chart" height="350">
        </canvas>
      </div>

    </div>
    <div class="col-md-5 mt-4">
      <h5>Best Selling Material</h5>
      <div class="card p-4" style="height:480px;">
        <div class="w-75 mb-4 position-relative">
          <input class="form-control" readonly placeholder="Pick date range" id="material_daterangepicker" data-url="{{ route('admin.material.chart') }}" />
          <i class="fa fa-times-circle material_cancel text-secondary position-absolute" style="display: none;"></i>
        </div>
        <h5 class="material_heading text-center" style="display: none">Data Not Found</h5>
        <canvas id="material_pie_chart" height="350">
        </canvas>
      </div>

    </div>

    <div class="col-md-5 mt-4">
      <h5>Best Selling Variant (Size + Material)</h5>
      <div class="card p-4" style="height:480px;">
        <div class="w-75 mb-4 position-relative variant_div">
          <input class="form-control" readonly placeholder="Pick date range" id="variant_daterangepicker" data-url="{{ route('admin.variant.chart') }}" />
          <i class="fa fa-times-circle variant_cancel text-secondary position-absolute" style="display: none;"></i>
        </div>
        <h5 class="variant_heading text-center" style="display: none">Data Not Found</h5>
        <canvas id="variant_pie_chart" height="350">
        </canvas>
      </div>
    </div>


    <div class="col-md-5 mt-4">
      <h5>Country Wise Sales</h5>
      <div class="card p-4" style="height:480px;">
        <div class="w-75 mb-4 position-relative">
          <input class="form-control" readonly placeholder="Pick date range" id="country_daterangepicker" data-url="{{ route('admin.country.chart') }}" />
          <i class="fa fa-times-circle country_cancel text-secondary position-absolute" style="display: none;"></i>
        </div>
        <h5 class="country_heading text-center" style="display: none">Data Not Found</h5>
        <canvas id="country_pie_chart" height="350">
        </canvas>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer">
  </script>

  <script src="{{ asset('js/size-chart.js') }}"></script>
  <script src="{{ asset('js/material-chart.js') }}"></script>
  <script src="{{ asset('js/variant-chart.js') }}"></script>
  <script src="{{ asset('js/country-chart.js') }}"></script>
@endpush
