@extends('admin.layouts.app')

@section('title', $title)

@section('content')

  <div class="row d-flex mb-3">
    <div class="d-flex justify-content-end align-items-center col">
      <div>
        <a href="{{ route('admin.website-setting') }}" class="btn btn-secondary btn-sm">
          <i class="fa fa-arrow-left"></i> Back
        </a>
      </div>
    </div>
  </div>

  <div class="row">
    @include('component.error')

    <div class="col-sm-4">
      <h5 class=""><strong>Sitemap</strong></h5>
      <p class="text-muted">Create Site Map XMl Content</p>
    </div>

    <div class="col-lg-8">
      <form action="{{ route('admin.sitemap.update') }}" id="sitemapForm" method="post">
        @csrf
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="address">XML Content</label>
                  <textarea class="form-control" name="content" id="content" rows="8">{{ $content ?? '' }}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-success float-right"> <i class="fa fa-save"></i> Save </button>
      </form>
    </div>

  @endsection
