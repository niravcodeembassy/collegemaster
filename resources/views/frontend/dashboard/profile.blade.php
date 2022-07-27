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
      .nice-select {
            width: 100%;
            border: 1px solid transparent;
            border-bottom: 2px solid #cccccc;
        }

        .nice-select:hover {
            border: 1px solid transparent;
            border-bottom: 2px solid #cccccc;
        }

        .nice-select.open,
        .nice-select:active,
        .nice-select:focus {
            border: 1px solid transparent;
            border-bottom: 2px solid #cccccc;
        }

        .iti__selected-flag{
            height:44px!important;
        }
    </style>
@endpush

@push('css')
    <link href="{{ asset('css/croppie.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

    @include('frontend.layouts.banner',[
        'pageTitel' => $title ?? '',
    ])

    <section class="section-b-space">
        <div class="container ">
        <div class="row mt-80 mb-80">
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

                        <div class="row">
                            <div class="col-lg-3 col-md-12">
                                 <div class="text-center" id="tag_container">
                                            <img src="{{ $user->profile_src }}" class="rounded-circle" width="150" height="150" id="showcropimg">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <label for="uplode_btn" class="btn btn-sm btn-info">Upload Image</label>
                                                    <input type="file" value="Choose a file" accept="image/*" id="uplode_btn" name="uplode_btn"  style="display:none;">
                                                </div>
                                            </div>
                                            <h4 class="card-title mt-8"><b>{{ $user->first_name ?? '' }}</b></h4>
                                            <p class="card-subtitle">{{ $user->email ?? '' }}</p>
                                        </div>
                            </div>
                            <div class="col-lg-9 col-md-12">
                                <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                                    @include('component.error')

                                    <div class="card-body lezada-form contact-form p-0">
                                        <form action="{{ route('profile.update',$user->id) }}" class="form-horizontal" name="update_profile_form" id="update_profile_form" enctype="multipart/form-data" method="POST" data-url="{{ route('mailcheck') }}" data-id="{{ $user->id }}">
                                            @method('put')
                                            @csrf()

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="" name="first_name" id="first_name"
                                                           data-rule-required="true" data-msg-required="First Name is required" value="{{ $user->first_name ?? '' }}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="" name="last_name" id="last_name" data-rule-required="true" data-msg-required="Last Name is required" value="{{ $user->last_name ?? ''}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="Email">Email Address <span class="text-danger">*</span></label>
                                                    <input type="email" class="" name="email" id="email" data-rule-required="true"
                                                           data-rule-remote=""
                                                           data-msg-remote="Email is already exists."
                                                           data-msg-required="Email is required" value="{{ $user->email ?? ''}}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                        <label for="phone">Mobile no <span
                                                                class="text-danger">*</span></label>
                                                        <input type="tel" placeholder="Phone number"
                                                            value="{{ $user->phone ?? '' }}" name="phone" id="telephone"
                                                             data-rule-required="true" required pattern="^([0|\+[0-9]{1,5})?([7-9][0-9]{9})$" data-msg-required="Mobile no is required" data-rule-mobileUK="true" style="padding-left:73px!important;padding:10px">
                                                    <label id="phone-error" class="error text-danger" for="phone"></label>
                                                             {{-- <input type="text" id="phone" name="phone" id="phone" class="" data-rule-required="true" data-msg-required="Mobile no is required" data-rule-number="true" data-rule-maxlength="10"  value="{{ $user->phone ?? ''}}"> --}}
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="address1">Address 1 <span class="text-danger">*</span></label>
                                                <input type="text" placeholder="" class="" name="address1" data-rule-required="true"  value="{{ $user->address1 ?? '' }}" />
                                            </div>

                                            <div class="form-group">
                                                <label for="address2">Address 2</label>
                                                <input type="text" placeholder="" class="" name="address2" value="{{ $user->address2 ?? '' }}" />
                                            </div>

                                            <div class="row">
													@php
                                                        $countryList = App\Model\Country::get();
                                                    @endphp
                                                <div class="form-group col-md-6 col-12 mb-20">
                                                        <label>Country*</label>
                                                        <input type="hidden" name="country_url" id="country_url"
                                                        value="{{ route('country.to.state') }}">
        
                                                        <select class="nice-select" placeholder="Country" name="country"
                                                            style="display: none;" id="country">
                                                            <option value="">Select Country</option>
                                                            @foreach ($countryList as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ isset($user->country_id) && strtolower($user->country_id) == strtolower($item->id) ? 'selected' : '' }}>
                                                                    {{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                <div class="form-group col-md-6">
                                                        <input type="hidden" name="old_state" id="old_state"
                                                            value="{{ isset($user->state_id) && $user->state_id != '' ? strtolower($user->state_id) : '' }}">
                                                        <label>State*</label>
                                                        <select class="nice-select state" required name="state" id="state"
                                                            style="display: none;">
                                                            <option value="">Select State</option>
                                                            
                                                        </select>
                                                    </div>

                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="city">Town / City <span class="text-danger">*</span></label>
                                                    <input type="text" placeholder="" class="" name="city" data-rule-required="true"  value="{{ $user->city_id ?? '' }}" />
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="last_name">Postcode / Zip <span class="text-danger">*</span></label>
                                                    <input type="text" placeholder="" class="" name="postcode" data-rule-required="true"  value="{{ $user->postal_code ?? '' }}" />
                                                </div>
                                            </div>

                                            <button class="lezada-button mt-20  lezada-button--medium float-right" type="submit">Save Changes</button>

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

<div id="load-modal"></div>
<div class="modal fade" id="profile_modal" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Profile Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="upload-demo"></div>
                <input type="hidden" name="profile_url" id="profile_url" value="{{ route('changeProfilImage' , ['id' => $user->id ]) }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn upload-result btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script src="{{ asset('js/croppie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/user_profile.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="{{ asset('front/assets/build/css/intlTelInput.css') }}">

    <script src="{{ asset('front/assets/build/js/intlTelInput.min.js') }}"></script>

    <script>
        var input = document.querySelector("#telephone");
        window.intlTelInput(input, {
            formatOnDisplay: false,
            autoPlaceholder: "polite",
            initialDialCode: true,
            americaMode: false,
            preferredCountries: ["us"],
        });
      $('#telephone').keyup(function(){
            var mobile_no = $(this).val();
            var regex = /^\+(?:[0-9] ?){6,14}[0-9]$/;
            if(regex.test(mobile_no)){
                $('#phone-error').text('');
                return true;
            }else{
                $('#phone-error').text('Please Enter Valid Mobile No');
                return false;
            }
        });
        
        $(document).ready(function() {
            var country_code = $('#country').val();
            var country_url = $('#country_url').val();

            get_state(country_code, country_url)

        });


        $('#country').on('change', function() {
            var country_code = $(this).val();
            var country_url = $('#country_url').val();

            get_state(country_code, country_url)

        });

        function get_state(country_code, country_url) {
            $.post(country_url, {
                    _token: '{{ csrf_token() }}',
                    country_code: country_code
                },
                function(data) {
                    if (data.length != "") {
                        $('.state').html(null);

                        var old_state = $('#old_state').val();

                        var html = "";
                        for (var i = 0; i < data.length; i++) {
                            var state_name = data.stateData[i].id;
                            if (state_name == old_state) {
                                var var_selected = "selected";
                            } else {
                                var var_selected = "";
                            }
                            html += '<option value="' + data.stateData[i].id + '" ' + var_selected + '>' + data
                                .stateData[i].name + '</option>';
                        }

                        $('.state').html(html);
                        $('select.state').niceSelect();
                        $('select.state').niceSelect('update');

                    } else {
                        $('.state').html(null);
                    }
                });
        }
    </script>
    <script src="{{ asset('front/assets/build/js/intlTelInput-jquery.min.js') }}"></script>

@endpush

