@extends('admin.layouts.app')

@section('title' , $title)

@section('content')
@component('component.heading',[
'page_title' => 'Add',
'icon' => 'ik ik-home' ,
'tagline' =>'Lorem ipsum dolor sit amet.' ,
'action' => route('admin.homepagebanners.index') ,
'action_icon' => 'fa fa-arrow-left' ,
'text' => 'Back'
])

@endcomponent
<div class="section">
    <form action="{{ route('admin.homepagebanners.store') }}" method="POST" name="bannerform" id="bannerform"  enctype="multipart/form-data" >
        @csrf()

        <div class="row">
            @include('component.error')

            <div class="col-md-8">
                <div class="card">
                     <div class="card-body">

                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="btn_name">Title</label>
                                   <input type="text" id="title" class=" form-control col-12" name="title" data-rule-required="true">
                                </div>
                            </div>
                        </div>
                        <div class="form-row ">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="btn_name">Button Name</label>
                                    <input id="btn_name" class="form-control" type="text" name="btn_name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="btn_url">Button Link</label>
                                    <input id="btn_url" class="form-control" type="text" name="btn_url">
                                </div>
                            </div>
                        </div>
                        <div class="form-row d-none">
                            <div class="col">
                                <div class="form-group">
                                    <h6><strong>Title Position</strong></h6>
                                    <hr>
                                    <div class="form-radio">
                                        <div class="radio radio-inline">
                                            <label class="pr-3">
                                                <input type="radio" name="title_position" value="Left" checked="checked">
                                                <i class="helper"></i>Left
                                            </label>
                                            <label class="pr-3">
                                                <input type="radio" name="title_position" value="Center">
                                                <i class="helper"></i>Center
                                            </label>
                                            <label class="pr-3">
                                                <input type="radio" name="title_position" value="Right">
                                                <i class="helper"></i>Right
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-row d-none">
                            <h6><strong>Status</strong></h6>
                            <hr>
                            <div class="col">
                                <div class="form-group">
                                    <div class="form-radio">
                                        <div class="radio radio-inline">
                                            <label>
                                                <input type="radio" name="status" value="Yes" checked="checked">
                                                <i class="helper"></i>Enabled
                                            </label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <label>
                                                <input type="radio" name="status" value="No">
                                                <i class="helper"></i>Disabled
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col">
                                <h6 class="text-mute"><strong>Slider Image <span class="text-danger">*</span></strong> </h6> <hr>
                                    @include('component.imagepriview',[ 'height' => '200px','label' => 'Image' , 'class' => 'files' ,'name' =>'slider_image','priview' => null ])
                                    <div class="text-left text-danger">Size maust be 1710 x 860</div>
                                    <br>
                                    <h6 class="text-mute"><strong>Mobile Slider Image <span class="text-danger">*</span></strong> </h6> <hr>
                                    @include('component.imagepriview',[ 'height' => '200px','label' => 'Image' , 'class' => 'files' ,'name' =>'mobile_slider_image','priview' => null ])
                                    <div class="text-left text-danger">Size maust be 840 x 640</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col d-flex justify-content-end">
                <button type="submit" class="btn btn-success shadow"><i class="ik ik-check-circle">
                </i>Save</button>
            </div>
        </div>

    </form>
</div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>
@endpush
@push('scripts')
    <script>

        $.validator.addMethod('filesize', function (value, element, param) {
            if (element.files.length) {
                return this.optional(element) || (element.files[0].size <= param)
            }
            return true;
        }, 'File size must be less than 5mb.');

        $(document).ready(function ()   {

            $('#bannerform').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
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
