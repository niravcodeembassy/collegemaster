@extends('admin.layouts.app')

@section('content')

<div class="row d-flex mb-2">
    <div class="d-flex justify-content-between align-items-center col">
        <h4>Create User</h4>
        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back </a>
    </div>
</div>

<form action="{{ route('admin.user.store') }}" id="saveUser" method="POST" autocomplete="off">
    
    @csrf

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
        
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="first_name" class="col-sm-1-12 col-form-label">First Name <i class="text-danger">*</i></label>
                            <input type="text" data-rule-required="true" class="form-control" name="first_name" id="first_name" placeholder="First Name">
                        </div>
                        <div class="form-group col">
                            <label for="last_name" class="col-sm-1-12 col-form-label">Last Name <i class="text-danger">*</i></label>
                            <input type="text" data-rule-required="true" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="email" class="col-sm-1-12 col-form-label">E-mail Address <i class="text-danger">*</i></label>
                            <input type="text" 
                            data-rule-required="true"  class="form-control" 
                            data-rule-remote="{{ route('admin.user.email.unique') }}"
                            data-msg-remote="This email already exists"
                            name="email" id="email" placeholder="E-mail Address">
                        </div>
                    </div>                      
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="password" class="col-sm-1-12 col-form-label">Password <i class="text-danger">*</i></label>
                            <input type="password" data-rule-required="true" class="form-control" name="password" id="password" placeholder="password">
                        </div>
                        <div class="form-group col">
                            <label for="confirmation_password" class="col-sm-1-12 col-form-label">Confirmation Password</label>
                            <input type="password"  class="form-control" name="confirmation_password" id="confirmation_password" placeholder="Confirmation Password">
                        </div>
                    </div>
                    <div class="form-row">

                        <div class="form-group col-12">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" checked class="custom-control-input" id="is_active" value="1" name="is_active">
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        
                        <div class="form-group col-12">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="confirmed" value="1" name="confirmed">
                                <label class="custom-control-label" for="confirmed">Confirmed</label>
                            </div>
                        </div>

                     
                    </div>

            
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header border-0">
                    <p class="text-secondery mb-0 font-weight-bold">Abilities</p>
                </div>
                <div class="card-body pt-0">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="role" >Role <i class="text-danger">*</i></label>
                            <select name="role[]" data-rule-required="true" multiple id="role" data-url="{{ route('admin.get.role') }}" data-placeholder="Select Role" id="role" class="form-control">
                                <option value="">Select Role</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="permission" >Additional Permission</label>
                            <select name="permission[]" data-rule-required="false" multiple data-placeholder="Select Permission" id="permission" data-url="{{ route('admin.get.permission') }}" id="permission" class="form-control">
                                <option value="">Select permission</option>
                            </select>
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

@endsection

@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {

            let $rolePermission = $('#role,#permission');

            $('#saveUser').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                errorPlacement: function (error, element) {
                    // $(element).addClass('is-invalid')
                    error.appendTo(element.parent()).addClass('text-danger');
                }
            });

            $rolePermission.select2({
                theme: 'bootstrap4',
                ajax: {
                    url: function(){
                        return $(this).data('url')  
                    } ,
                    data: function (params) {
                        return {
                            search: params.term,
                        };
                    },
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data.map(function (item) {
                                return {
                                    id: item.id,
                                    text: item.name,
                                    otherfield: item,
                                };
                            }),
                        }
                    },
                    //cache: true,
                    delay: 250
                },
            })
           

        });
    </script>
@endpush