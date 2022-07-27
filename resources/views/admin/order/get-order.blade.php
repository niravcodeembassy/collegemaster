{{-- <link rel="stylesheet" href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />

<div class="modal fade" id="edit_hsncode_form_model">
	<div class="modal-dialog">
		<form action="{{route('admin.order.update' , $order->id) }}" method="POST" role="form" name="edit_tax_form" id="edit_tax_form">
			@csrf @method('PUT') ;
			<div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Manage Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true"  data-msg-required="Category is required." >&times;</span></button>
                </div>
				<div class="modal-body">
					<div class="tax-ajax-message"></div>

					<div class="contct-shop hide">
						<div class="form-group">

							<label for="gst_type">Payment Status <em class="text-danger">*</em></label>
							<div class="content_error ">
								<select name="payment_status" id="payment_status_id" data-rule-required="true"  class="form-control">
									<option value="">--- Payment Status ---</option>

									@if ($order->payment_status == 'completed')
										<option value="completed" selected >Completed</option>
									@else
										<option value="completed"  >completed</option>
									@endif
									@if ($order->payment_status == 'pending')
										<option value="pending" selected>pending</option>
									@else
										<option value="pending">pending</option>
									@endif
									@if ($order->payment_status == 'failed')
										<option value="failed" selected>failed</option>
									@else
										<option value="failed">failed</option>
									@endif
								</select>
							</div>
						</div>
					</div>

					<div class="contct-info">
						<div class="form-group">
							<label for="eidt_percentage">Delivery Status  <em class="text-danger">*</em></label>
							<select name="delivery_status" id="delivery_status" data-rule-required="true"  onchange="getdelivery_status();" data-parsley-group="first" required  class="form-control">
								<option value="">--- Delivery Status ---</option>
								<option value="order_placed" {{  strtolower($order->order_status)  == 'order_placed' ? "selected" : ''  }} >Ordered</option>
								<option value="customer_approval" {{  strtolower($order->order_status)  == 'customer_approval' ? "selected" : ''  }} >Customer approval</option>
								<option value="work_in_progress" {{  strtolower($order->order_status)  == 'work_in_progress' ? "selected" : ''  }} >Work In Progress</option>
								<option value="dispatched"  {{ strtolower($order->order_status) == 'dispatched' ? "selected" : ''  }}>Shipped</option> {{-- Shipped == Dispatch --}}
								<option value="delivered" {{ strtolower($order->order_status) == 'delivered' ? "selected" : ''  }}>Delivered</option>
								<option value="cancelled" {{ $order->order_status == 'cancelled' ? "selected" : ''  }}>Cancel</option>
							</select>
						</div>
					</div>

					@php
						$ordered_ = $order->delivery_status == 'ordered' ? "" : 'd-none' ;
						$shipped_ = $order->delivery_status == 'dispatched' ? "" : 'd-none' ;
						$delivered_ = $order->delivery_status == 'delivered' ? "" : 'd-none' ;
						$cancel_ = $order->delivery_status == 'cancelled' ? "" : 'd-none' ;
					@endphp

					<div  class="{{ $shipped_ }}" id="hdn_element_shipped" >
						<div class="contct-info" >
							<div class="form-group">
                                <label for="eidt_percentage">Shipped date <em class="text-danger">*</em></label>
                                <input type="text"
									data-rule-required="true"  value="{{ $order->shipping_date ? date('d-m-Y' , strtotime($order->shipping_date)) : '' }}"  name="shipping_date" id="shipping_date"
                                    style="width: 100%;" class="form-control "
                                    data-toggle="datetimepicker" data-target="#shipping_date"
                                    >

							        {{-- <input type="text"  id="shipping_date"
                                    name="shipping_date"
                                    value="{{ $order->shipping_date ? date('d-m-Y' , strtotime($order->shipping_date)) : '' }}"
                                    class="form-control "
                                    id="shipping_date" readonly
                                    data-toggle="datetimepicker" data-target="#shipping_date"/> --}}
							</div>
						</div>
						<div class="contct-info d-none " >
							<div class="form-group">
								<label for="courier_name">Shipped method <em class="text-danger">*</em></label>
								<input type="text" id="courier_name"
									data-rule-required="true"  value="" name="courier_name"
									style="width: 100%;" class="form-control-user form-control">
							</div>
						</div>
						<div class="contct-info d-none" >
							<div class="form-group"> {{-- courier_number == doc number  only change then lable--}}
								<label for="courier_number">Tracking number <em class="text-danger">*</em></label>
								<input type="text" id="courier_number"
                                    value="{{ $order->courier_number ?? '' }}"
									data-rule-required="true" name="courier_number"
									style="width: 100%;" class="form-control-user form-control">
							</div>
						</div>

					</div>


{{--
                    <div class="form-group">
                        <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                            <input type="text" class="form-control " id="datetimepicker5" data-toggle="datetimepicker" data-target="#datetimepicker5"/>
                            </div>
                        </div>
                    </div> --}}

                    <div  class="{{ $delivered_ }}" id="hdn_element_deleverd">

						<div class="contct-info" >{{--data-rule-required="true"<em class="text-danger">*</em>--}}
							<div class="form-group">
                                <label for="deleverd_date"> Date  <em class="text-danger">*</em> </label>
                                <input type="text"  id="deleverd_date"
                                    name="deleverd_date"
                                    value="{{ $order->deleverd_date ? date('d-m-Y' , strtotime($order->deleverd_date)) : '' }}"
                                    class="form-control "
									id="deleverd_date"
									data-rule-required="true"
                                    data-toggle="datetimepicker" data-target="#deleverd_date"/>
{{--
								<input type="text" id="deleverd_date"
									 name="deleverd_date"
									value="{{ $order->deleverd_date ? date('m-d-Y' , strtotime($order->deleverd_date)) : '' }}"
                                    style="width: 100%;" class="form-control-user form-control datetimepicker" data-target="#datetimepicker4"> --}}

							</div>
                        </div>

						<div class="contct-info" >
							<div class="form-group">{{--data-rule-required="true"<em class="text-danger">*</em>--}}
								<label for="eidt_percentage">Name(Delivered to) </label>
								<input type="text" id="user_name"
									 name="user_name"
									value="{{ $order->deleverd_to_name ?? '' }}"

									style="width: 100%;" class="form-control-user form-control">
							</div>
						</div>

					</div>

					<div class="{{ $cancel_ }}" style="margin-bottom: 10px;" id="show_cancel_comment">
						<div class="contct-info" >

							<div class="form-group">
								{{ $order->cancelReason }}
								<label for="eidt_percentage">Cancel Remarks <em class="text-danger">*</em></label>
								<input type="text" id="cancel_remarks"
									value="{{ $order->cancel_reason ?? '' }}"
									data-rule-required="true" name="cancel_remarks"
									style="width: 100%;" class="form-control-user form-control">
							</div>
						</div>
					</div>


				</div>
				<input type="hidden" id="edit_id" value="{{-- $hsncode->id or '' --}}" >
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-default btn-link" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-sm btn-primary">Save</button>
				</div>
			</div>
		</div>
	</form>
</div>



{{-- <script src="{{ asset('assets/plugins/select2/dist/js/select2.min.js') }}"></script> --}}

{{-- <script src="{{ asset('backend/plugins/bootstrap-datetimepicker/js/moment.min.js') }}"></script> --}}



<script type="text/javascript">


	$(document).ready(function () {

        var status = $("#delivery_status").val();
        var payment_status = $("#payment_status_id").val();

        //alert(payment_status);
        if(payment_status=="success"){
            $("#hdn_element_payment_status").addClass('hidden');
        }else{
            $("#hdn_element_payment_status").removeClass('hidden');
        }


        if(status=="dispatched"){
            $("#hdn_element_shipped").removeClass('hidden');
        }else{
            $("#hdn_element_shipped").addClass('hidden');
        }

        if(status=="delivered"){
            $("#hdn_element_deleverd").removeClass('hidden');
        }else{
            $("#hdn_element_deleverd").addClass('hidden');
        }

        $('#shipping_date,#deleverd_date').datetimepicker({
            format: 'DD-MM-YYYY' ,
            keepOpen: false,
            showClear: true,
            showClose: true,
            icons: {
                time: "fa fa-clock",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }
        });

		$('#edit_tax_form').validate({
			messages: {
				percentage: {
					remote: 'This type already exists.'
				}
			},
			errorPlacement: function (error, element) {
				error.appendTo(element.parent()).addClass('text-danger');
			},
			submitHandler: function (e) {
				return true;
			}
		});

        $('#delivery_status').on('change', function () {
            getdelivery_status();
        });

	});
</script>

<script>
    function getdelivery_status(){

       var status = $("#delivery_status").val();

       if(status=="dispatched"){
           $("#hdn_element_shipped").removeClass('d-none');
       }else{
            $("#hdn_element_shipped").addClass('d-none');
       }

        if(status=="delivered"){
           $("#hdn_element_deleverd").removeClass('d-none');
        }else{
            $("#hdn_element_deleverd").addClass('d-none');
        }

        if(status=="cancelled"){
           $("#show_cancel_comment").removeClass('d-none');
        }else{
           $("#show_cancel_comment").addClass('d-none');
        }

    }
</script>
