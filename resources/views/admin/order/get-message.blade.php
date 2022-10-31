<div class="modal fade" id="message_form_model">
  <div class="modal-dialog">
    <form action="{{ route('admin.order.init.message.send', $order->id) }}" method="POST" role="form">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Order Chat</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" data-msg-required="Category is required.">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Message<em class="text-danger">*</em></label>
            <textarea data-rule-required="true" name="message" class="form-control" rows="3"></textarea>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-default btn-link" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-sm btn-primary">Send</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
