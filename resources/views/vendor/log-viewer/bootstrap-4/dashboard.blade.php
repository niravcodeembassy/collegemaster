@extends('admin.layouts.app')
@push('style')
    <style>
         /*
         * Colors: Badge & Infobox
         */

        .card.box {
            color: #FFF !important;
        }
        .badge.badge-env,
        .badge.badge-level-all,
        .badge.badge-level-emergency,
        .badge.badge-level-alert,
        .badge.badge-level-critical,
        .badge.badge-level-error,
        .badge.badge-level-warning,
        .badge.badge-level-notice,
        .badge.badge-level-info,
        .badge.badge-level-debug,
        .badge.empty {
            color: #FFF;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
        }

        .badge.badge-level-all,
        .box.level-all {
            background-color: {{ log_styler()->color('all') }};
        }

        .badge.badge-level-emergency,
        .box.level-emergency {
            background-color: {{ log_styler()->color('emergency') }};
        }

        .badge.badge-level-alert,
        .box.level-alert  {
            background-color: {{ log_styler()->color('alert') }};
        }

        .badge.badge-level-critical,
        .box.level-critical {
            background-color: {{ log_styler()->color('critical') }};
        }

        .badge.badge-level-error,
        .box.level-error {
            background-color: {{ log_styler()->color('error') }};
        }

        .badge.badge-level-warning,
        .box.level-warning {
            background-color: {{ log_styler()->color('warning') }};
        }

        .badge.badge-level-notice,
        .box.level-notice {
            background-color: {{ log_styler()->color('notice') }};
        }

        .badge.badge-level-info,
        .box.level-info {
            background-color: {{ log_styler()->color('info') }};
        }

        .badge.badge-level-debug,
        .box.level-debug {
            background-color: {{ log_styler()->color('debug') }};
        }

        .badge.empty,
        .box.empty {
            background-color: {{ log_styler()->color('empty') }};
        }

        .badge.badge-env {
            background-color: #6A1B9A;
        }
    </style>
@endpush
@section('content')
    <div class="page-header mb-4">
        <h1>@lang('Dashboard')</h1>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <canvas id="stats-doughnut-chart" height="300" class="mb-3"></canvas>
        </div>
        <div class="col-md-6 col-lg-9">
            <div class="row">
                @foreach($percents as $level => $item)
                    <div class="col-sm-6 col-md-12 col-lg-4 mb-3">
                        <div class="card box level-{{ $level }} {{ $item['count'] === 0 ? '' : '' }}">
                            <div class="card-body">
                                <div class="">
                                    <div class="box-icon f-24">
                                        {!! log_styler()->icon($level) !!}
                                    </div>
                                    <div class="box-content">
                                        <span class="box-text">{{ $item['name'] }}</span>
                                        <span class="box-number">
                                            {{ $item['count'] }} @lang('entries') - {!! $item['percent'] !!} %
                                        </span>
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar bg-gray-dark" style="width: {{ $item['percent'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
@endpush
@push('scripts')
    <script>
        $(function() {
            new Chart(document.getElementById("stats-doughnut-chart"), {
                type: 'doughnut',
                data: {!! $chartData !!},
                options: {
                    legend: {
                        position: 'bottom'
                    }
                }
            });
        });
    </script>
@endpush
