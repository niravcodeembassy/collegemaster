@extends('admin.layouts.app')
@push('style')
  <style type="text/css">
    .btn.btn-primary {
      height: 36px !important;
      width: 46px !important;
    }

    .page-header .page-header-title i {
      float: left;
      width: 40px;
      height: 40px;
      border-radius: 5px;
      margin-right: 15px;
      vertical-align: middle;
      font-size: 22px;
      color: #fff;
      display: inline-flex;
      -webkit-justify-content: center;
      -moz-justify-content: center;
      -ms-justify-content: center;
      justify-content: center;
      -ms-flex-pack: center;
      -webkit-align-items: center;
      -moz-align-items: center;
      -ms-align-items: center;
      align-items: center;
      -webkit-box-shadow: 0 2px 12px -3px rgba(0, 0, 0, 0.5);
      -moz-box-shadow: 0 2px 12px -3px rgba(0, 0, 0, 0.5);
      box-shadow: 0 2px 12px -3px rgba(0, 0, 0, 0.5);
    }

    .settings li {
      font-size: 18px;
      font-weight: 400;
    }

    .settings li i {
      padding-right: 15px;
    }
  </style>
@endpush
@section('content')
  <div class="row d-flex mb-2">
    <div class="d-flex justify-content-between align-items-center col">
      <h4>Settings</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.settings.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-cogs"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.settings.index') }}">
                  <h6 class="text-capitalize mb-1"><b> Genaral setting </b></h6>
                </a>
                {{-- Here you can config site name,email, address etc... --}}
              </span>
            </div>
            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.smtp.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-at"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.smtp.index') }}">
                  <h6 class="text-capitalize mb-1"><b> SMTP Configuration </b></h6>
                </a>
                {{-- Here you can configure your smtp details that will use to send a email... --}}
              </span>
            </div>
            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.option.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-list"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.option.index') }}">
                  <h6 class="text-capitalize mb-1"><b> Attributes </b></h6>
                </a>
                {{-- Here you can configure your product variation option... --}}
              </span>
            </div>
            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.optionvalue.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-list"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.optionvalue.index') }}">
                  <h6 class="text-capitalize mb-1"><b> Attributes Value</b></h6>
                </a>
                {{-- Here you can configure your product variation option value... --}}
              </span>
            </div>
            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.homepagebanners.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-image"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.homepagebanners.index') }}">
                  <h6 class="text-capitalize mb-1"><b> Slider </b>
                  </h6>
                </a>
                {{-- Here you can configure your product home page slider  option value... --}}
              </span>
            </div>
            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.common-banner.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-image"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.common-banner.index') }}">
                  <h6 class="text-capitalize mb-1"><b> Unique Ideas </b></h6>
                </a>
                {{-- Here you can configure your unique ideas banner... --}}
              </span>
            </div>
            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.hscode.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-percentage"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.hscode.index') }}">
                  <h6 class="text-capitalize mb-1"><b>HSN Code </b></h6>
                </a>
                {{-- Here you can configure your unique ideas banner... --}}
              </span>
            </div>

            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.shipping-country.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-shipping-fast"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.shipping-country.index') }}">
                  <h6 class="text-capitalize mb-1"><b>Shipping Country </b></h6>
                </a>
              </span>
            </div>

            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.payment.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-credit-card" aria-hidden="true"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.payment.index') }}">
                  <h6 class="text-capitalize mb-1"><b>Payment Setting </b></h6>
                </a>
              </span>
            </div>

            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.pages.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-pager" aria-hidden="true"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.pages.index') }}">
                  <h6 class="text-capitalize mb-1"><b>Page </b></h6>
                </a>
              </span>
            </div>

            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.dealofday.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-pager" aria-hidden="true"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.dealofday.index') }}">
                  <h6 class="text-capitalize mb-1"><b>Deal Of Day </b></h6>
                </a>
              </span>
            </div>
            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.faq.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-question-circle" aria-hidden="true"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.faq.index') }}">
                  <h6 class="text-capitalize mb-1"><b>Frequent Asked Question</b></h6>
                </a>
              </span>
            </div>
            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.story.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fas fa-video" aria-hidden="true"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.story.index') }}">
                  <h6 class="text-capitalize mb-1"><b>Our Story</b></h6>
                </a>
              </span>
            </div>
            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.message-snippet.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="far fa-comment-alt" aria-hidden="true"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.message-snippet.index') }}">
                  <h6 class="text-capitalize mb-1"><b> Message Snippet</b></h6>
                </a>
              </span>
            </div>
            <div class="align-items-center col-sm-12 col-md-4 d-flex py-3">
              <a href="{{ route('admin.sitemap.index') }}" role="button" type="button" class="btn btn-primary shdow mr-3 shadow">
                <i class="fa fa-sitemap" aria-hidden="true"></i>
              </a>
              <span class="text-muted">
                <a href="{{ route('admin.sitemap.index') }}">
                  <h6 class="text-capitalize mb-1"><b>Sitemap</b></h6>
                </a>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
