@extends('admin.layouts.app')

@section('title' , $title)



@section('content')

@component('component.heading',[
'page_title' => 'Home Page Banner',
'icon' => 'ik ik-navigation' ,
'tagline' =>'Lorem ipsum dolor sit amet.' ,
'action' => route('admin.website-setting') ,
'action_icon' => 'fa fa-arrow-left' ,
'text' => 'Back'
])
{{--<a href="{{route('admin.offerbanner.create')}}" class="btn btn-outline-dark btn-rounded ml-3">
  <i class="ik ik-plus "></i> Add Offer Banner
</a>--}}
@endcomponent
<div class="row">
  <div class="col-md-12">

    <div class="card p-3">

      <form action="{{ route('admin.common-banner.store') }}" name="middle_banner" id="middle_banner" method="post"
        enctype="multipart/form-data">

        @csrf
        @foreach ($commonBanner as $key => $middlebanner)
        <div class="row mb-5">
          <div class="col-4">
            <h6 class="text-mute"><strong>Image <span class="text-danger">*</span></strong> </h6>

            <hr>
            <div class="form-row">
              @include('component.imagepriview',[
              'height' => '200px','label' => 'Image' ,
              'name' =>'banner_image_'.$key,
              'id' => 'banner_image_'.rand(0,1111111) ,
              'priview' => $middlebanner->banner_image ?? null
              ])
              <div class="text-left text-danger">Size maust be 560 x 320</div>
            </div>
          </div>
          <div class="col">
            <h6 class="text-mute"><strong>Details <span class="text-danger">*</span></strong> </h6>
            </h6>
            <hr>
            <div class="form-group">
              <label for="caption_{{$key}}">Caption 1</label>
              <input id="caption_{{$key}}" class="form-control" type="text" value="{{ $middlebanner->caption1 }}"
                name="caption1[{{$key}}]">
            </div>
            <div class="form-group">
              <label for="caption_2_{{$key}}">Caption 2</label>
              <input id="caption_2_{{$key}}" class="form-control" type="text" value="{{ $middlebanner->caption2 }}"
                name="caption2[{{$key}}]">
            </div>
            <div class="form-group">
              <label for="caption_3_{{$key}}">Caption 3</label>
              <input id="caption_3_{{$key}}" class="form-control" type="text" value="{{ $middlebanner->caption3 }}"
                name="caption3[{{$key}}]">
            </div>
            <div class="form-group">
              <label for="url_{{$key}}">Url</label>
              <input id="url_{{$key}}" data-rule-url="true" class="form-control" type="text"
                value="{{ $middlebanner->url }}" name="url[{{$key}}]">
            </div>
            <div class="form-group d-none">
              <label for="caption">Have to show offer banner ?</label>
              <div class="material-switch">
                <input id="is_active_{{$key}}" name="is_active[]" {{ $middlebanner->is_active == 'Yes' ? 'checked' : ''
                }} type="checkbox" checked value="1">
                <label for="is_active_{{$key}}" class="badge-success"></label>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" name="id[]" value="{{ $middlebanner->id }}">
        <hr>
        @endforeach
        <div class="form-group">
          <button type="submit" class="btn btn-success shadow float-right"><i
              class="ik ik-check-circle"></i>Update</button>
        </div>
      </form>

    </div>
  </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript">
  $(document).ready(function () {

        $.validator.addMethod('filesize', function (value, element, param) {
            if (element.files.length) {
                return this.optional(element) || (element.files[0].size <= param)
            }
            return true;
        });


        $('#middle_banner').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files")',
            rules: {},
            messages: {},
            errorPlacement: function (error, element) {
                // $(element).addClass('is-invalid')
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (e) {
                return true;
            }
        })

    });
</script>

@endpush
