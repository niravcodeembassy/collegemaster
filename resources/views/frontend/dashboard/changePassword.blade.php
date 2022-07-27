@extends('frontend.layouts.app')

@push('style')
    <style style="text/css">
        .profiletimeline {
            position: relative;
            padding-left: 40px;
            margin: 40px 10px 0 30px;
            border-left: 1px solid rgba(0,0,0,0.1);
        }
        .profiletimeline .sl-item .sl-left {
            float: left;
            margin-left: -60px;
            z-index: 1;
            margin-right: 15px;
        }
    </style>
@endpush

@push('css')
    <link href="{{ asset('css/croppie.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

    @include('frontend.layouts.banner',[
        'pageTitel' => 'CHANGE PASSWORD'?? '',
    ])
    <section class="section-b-space">
        <div class="container ">
            <div class="row  mt-80 mb-80">
                @include('frontend.dashboard.sidebar')
                <div class="col-lg-9">
                    <div class="dashboard-right">

                        @if(Session::has('success'))
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-success" role="alert">
                                        <strong>{{ Session::get('success') }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="dashboard">

                            <div class="row lezada-form contact-form">
                                <div class="col">
                                    <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        @include('component.error')
                                        <div class="card-body p-0">
                                            <div class="page-title">
                                                <h2 class="mb-20">CHANGE PASSWORD</h2>
                                            </div>


                                            <form class="form-horizontal" id="change_password_form" name="change_password_form" enctype="multipart/form-data" method="POST" action="{{ route('changePassword') }}" data-url="{{ route('checkuserPassword') }}" data-id="{{ $user->id }}">
                                                @csrf

                                                @if (Request::get('id'))
                                                    <input type="hidden" class="" name="id" value="{{Request::get('id')}}" id="id">
                                                @endif

                                                <div class="form-group">
                                                    <label for="old_password">Old Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="" name="old_password" id="old_password">
                                                </div>
                                                <div class="form-group">
                                                    <label for="new_password">New Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="" name="new_password" id="new_password">
                                                </div>
                                                <div class="form-group">
                                                    <label for="comfirm_password">Confirm Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="" name="comfirm_password" id="comfirm_password">
                                                </div>
                                                <button class="lezada-button mt-20  lezada-button--medium  float-right" name="btn_change_password" type="submit">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"/>

    <style>
        .select2-container--bootstrap .select2-selection--single {
            height: 42px !important;
            line-height: 2 !important;
        }
        .select2-container--bootstrap .select2-selection {
            box-shadow: none !important;
            border-radius: 0 !important;
        }
    </style>

@endpush

@push('js')
    <script src="{{ asset('assets/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script src="{{asset('js/croppie.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/user_profile.js')}}" type="text/javascript"></script>
@endpush
