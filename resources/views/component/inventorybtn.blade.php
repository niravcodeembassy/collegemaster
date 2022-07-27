<div class="custome align-bottom  ">
    <div class="form-group mb-0">
        <div class="input-group input-group-button mb-0 col justify-content-center">
            <input type="text" class="form-control col-4 border-dark  custom-input"  style="height: 39px;" name="inventory_{{ $item->variant_id }}" id="inventory_{{ $item->variant_id }}" placeholder="Qty">

            <label for="add_option_{{ $item->variant_id }}" class="input-group-append option-btn  mb-0" data-target="#inventory_{{ $item->variant_id }}" data-url="{{ route('admin.inventory.change.qty' , ['id' => $item->variant_id ,'type' => 'add' ] ) }}" >
                <span class="btn btn-sm btn-outline-secondary font-weight-bold p-2">Add</span>
            </label>

            <label data-target="#inventory_{{ $item->variant_id }}" id="set_option_{{ $item->variant_id }}"  class="input-group-append option-btn mb-0" data-url="{{ route('admin.inventory.change.qty' , ['id' => $item->variant_id ,'type' => 'set' ]) }}">
                <span class="p-2 btn btn-sm btn-outline-secondary font-weight-bold">Set</span>
            </label>

            </div>
        </div>
    </div>
</div>