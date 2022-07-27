@extends('admin.layouts.app')

@section('content')

<div class="row d-flex mb-2">
    <div class="d-flex justify-content-between align-items-center col">
        <h4>Profile</h4>
        <a href="{{ route('admin.user.index') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<form action="{{ route('admin.profile.update' , $profile->id) }}" id="saveUser" method="POST" autocomplete="off">

    @csrf @method('PUT')

    <div class="row">


        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center" id="tag_container">
                        <img src="{{ $profile->profile_src ?? '' }}" class="rounded-circle profile-user-img"
                            style="width:150px;" id="showcropimg">
                        <div class="text-center py-3">
                            <label for="uplode_btn" class="btn btn-sm btn-info">Upload Image</label>
                            <input type="file" value="Choose a file" accept="image/*" id="uplode_btn" name="uplode_btn"
                                style="display:none;">
                        </div>
                        <h4 class="mt-8"><b>{{ ucfirst($profile->first_name ?? '') }}</b></h4>
                        <p class="card-subtitle">{{ $profile->email ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-8">
            <div class="card">
                {{-- <div class="card-header p-2">
                    <ul class="nav nav-pills">
                      <li class="nav-item"><a class="nav-link active" href="#profiletab" data-toggle="tab">Activity</a></li>
                      <li class="nav-item"><a class="nav-link" href="#changepasswordTab" data-toggle="tab">Change password</a></li>
                    </ul>
                </div> --}}
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="profiletab">

                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                @foreach ($errors->all() as $error)
                                <span> {{ $loop->iteration }} ) {{ $error }}</span><br>
                                @endforeach
                            </div>
                            @endif

                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="first_name" class="col-sm-1-12 col-form-label">First Name <i
                                            class="text-danger">*</i></label>
                                    <input type="text" data-rule-required="true" class="form-control" name="first_name"
                                        id="first_name" value="{{ $profile->first_name }}" placeholder="First Name">
                                </div>
                                <div class="form-group col">
                                    <label for="last_name" class="col-sm-1-12 col-form-label">Last Name <i
                                            class="text-danger">*</i></label>
                                    <input type="text" data-rule-required="true" value="{{ $profile->last_name }}"
                                        class="form-control" name="last_name" id="last_name" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="email" class="col-sm-1-12 col-form-label">E-mail Address <i
                                            class="text-danger">*</i></label>
                                    <input type="text" data-rule-required="true" class="form-control"
                                        data-rule-remote="{{ route('admin.user.email.unique' ,['id' => $profile->id]) }}"
                                        value="{{ $profile->email }}" data-msg-remote="This email already exists"
                                        name="email" id="email" placeholder="E-mail Address">
                                </div>
                            </div>
                            <hr style="margin-left: -20px; margin-right: -20px; ">
                            <h4 class="mb-3">Change Password</h4>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="old_password" class="col-sm-1-12 col-form-label">Old Password </label>
                                    <input type="password" data-rule-required="true" class="form-control"
                                        name="old_password" id="old_password" placeholder="Old Password">
                                </div>
                                <div class="form-group col">
                                    <label for="new_password" class="col-sm-1-12 col-form-label">New Password </label>
                                    <input type="password" data-rule-required="true" class="form-control"
                                        name="new_password" id="new_password" placeholder="New Password">
                                </div>
                                <div class="form-group col">
                                    <label for="confirm_password" class="col-sm-1-12 col-form-label">Confirm Password
                                    </label>
                                    <input type="password" data-rule-required="true" class="form-control"
                                        name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>

    </div>

</form>

<!-- Modal -->
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
                <input type="hidden" name="profile_url" id="profile_url"
                    value="{{ route('admin.profile.update.image' , $profile->id) }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn upload-result btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.css" rel="stylesheet">
@endpush

@push('js')
<script src="{{ asset('js/profile.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.js"></script>
@endpush

@push('scripts')
@endpush
