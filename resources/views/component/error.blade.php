@if(count($errors) > 0)
<div class="col-12">
    <div class="form-group">
    	<div class="alert alert-danger">
    		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ik ik-x"></i>
            </button>
        
            @foreach ($errors->all() as $error)
            <p class="mb-1">{{ $error }}</p>
            @endforeach

        </div>
    </div>
</div>
@endif