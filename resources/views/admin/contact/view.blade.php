<div class="modal fade" id="contactview" role="dialog" aria-labelledby="contactview" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.contact.show' , $contact->id) }}" method="POST" id="contactform" name="contactform" enctype="multipart/form-data">
            @csrf()

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" >Contact Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"  data-msg-required="Category is required." >&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label><b>Name :</b></label>
                                        <span>{{ $contact->name ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label><b>Email :</b></label>
                                         <span>{{ $contact->email ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label><b>Telephone :</b></label>
                                         <span>{{ $contact->phone ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label><b>Subject :</b></label>
                                         <span>{{ $contact->subject ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label><b>Message :</b></label>
                                         <span>{{ $contact->comment ?? '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
