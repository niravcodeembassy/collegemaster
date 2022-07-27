@extends('admin.layouts.app')

@section('title' , $title)

@section('content')
@component('component.heading' , [
'page_title' => 'Inventory ',
'icon' => 'fa fa-clipboard' ,
'tagline' =>'Lorem ipsum dolor sit amet.' ,
'action' => route('admin.inventory.index') ,
'action_icon' => 'fa fa-arrow-left' ,
'text' => 'Back'
])
@endcomponent
<form action="{{ route('admin.inventory.update_all') }}" method="POST" name="save_inventory" id="save_inventory">

    @csrf 
    

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-block">
                    <h3>Bulk Edit</h3>             
                </div>
                <div class="card-block p-0 table-border-style">
                    <div class="table-responsive">
                        <table class="table table-inverse">
                            <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th>MRP </th>
                                    <th>Offer Price</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productvariant as $key => $item)
                                    <input type="hidden" name="variant_id[]" value="{{ $item->id }}">
                                    <tr>
                                        <td>
                                            <div class="feeds-widget">
                                                <div class="feed-item border-0">
                                                    <a href="#">
                                                        <div class="feeds-body">
                                                            <h4 class="font-weight-normal f-18 text-primary mb-0">{{ $item->product->name }} </h4>
                                                            <small>
                                                                <strong> <span> Price : {{ $item->mrp_price }} </span></strong>
                                                            </small>
                                                            <small>
                                                                <strong> <span> Offer Price : {{ $item->offer_price }} </span></strong>
                                                            </small> <br>
                                                            <small>
                                                                <strong> 
                                                                    @if($item->variantCombination)
                                                                        @foreach ($item->variantCombination as $variant_item)
                                                                         <span class="text-capitalize text-facebook"> {{ $variant_item->option->name }} : {{ $variant_item->optionvalue->name}} </span>
                                                                        @endforeach
                                                                    @endif
                                                                </strong>
                                                            </small>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
        
                                        </td>
                                        <td> 
                                            <div class="form-group">
                                                <input type="text"
                                                class="form-control w-75" name="mrp_price[]" data-rule-required="true" data-msg-required="MRP Price is required." data-rule-number="true" id="mrp_price_{{ $item->id }}" value="{{  $item->mrp_price }}" placeholder="">
                                            </div> 
                                        </td>
                                        <td> 
                                            <div class="form-group">
                                                <input type="text"
                                                class="form-control w-75 " name="offer_price[]"  data-rule-required="false" data-msg-required="Offer Price is required." data-rule-number="true" id="offer_price_{{ $item->id }}" value="{{  $item->offer_price  }}" placeholder="">
                                            </div> 
                                        </td>
                                        
                                        <td> 
                                            <div class="form-group">
                                                <input type="text"
                                                class="form-control w-75" name="inventory_quantity[]"  id="inventory_quantity_{{ $item->id }}" data-rule-number="true" value="{{ $item->inventory_quantity  }}" placeholder="">
                                            </div> 
                                        </td>
                                        
                                    </tr>
                                @endforeach                          
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success shadow"> Save</button>
            </div>
        </div>
    </div>
</form>

@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>        
@endpush
@push('css')
<style>
    /* .custome span.active{
            color: #fff;
            background-color: #0062cc;
            border-color: #005cbf;
        } */
    .custom-input {
        height: 35px;
        border: 1px solid grey !important;
    }

</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        // var table = $('#order-table').DataTable();
            
        $('#save_inventory').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {},
            messages: {},
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (e) {
                return true;
            }
        }) ;

        

    });

</script>
@endpush
