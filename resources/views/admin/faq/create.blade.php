@extends('admin.layouts.app')
@section('content')
  <div class="row d-flex">
    <div class="d-flex justify-content-between align-items-center col">
      <h4>Create Frquent Asked Question</h4>
      <a href="{{ route('admin.faq.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back
      </a>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-md-12">
      <form action="{{ route('admin.faq.store') }}" id="addmore" method="POST" autocomplete="off">
        @csrf
        <div class="card">
          <div class="card-body repeater">
            <div class="form-group">
              <label class="form-label fw-bolder">Title <span class="text-danger">*</span></label>
              <input type="text" name="title" required id="title" class="form-control form-control-solid title">
            </div>
            <div class="repeater">
              <div data-repeater-list="response">
                <div data-repeater-item>
                  <div class="form-group mt-2">
                    <label class="form-label fs-6 fw-bolder mb-3">Question <span class="text-danger">*</span></label>
                    <input type="text" name="question" class="form-control form-control-solid question">
                  </div>

                  <input type="hidden" name="parent_id">

                  <div class="form-group min">
                    <div class="form-group">
                      <label class="form-label fs-6 fw-bolder mb-3">Answer <span class="text-danger">*</span></label>
                      <textarea name="answer" rows="2" class="form-control form-control-solid answer editor"></textarea>
                    </div>
                  </div>

                  <button data-repeater-delete type="button" class="input-group-text bg-danger">
                    <i class="fas fa-trash-alt text-light"></i>
                  </button>

                </div>
              </div>
            </div>
            <input data-repeater-create type="button" class="btn btn-success btn-sm my-2" value="Add" />
          </div>
        </div>

        <div class="float-right">
          <a href="{{ route('admin.faq.index') }}" class="btn btn-default mr-2 "> Cancel</a>
          <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Save</button>
        </div>

      </form>
    </div>
  </div>
@endsection




@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js" integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w==" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/19.1.1/classic/ckeditor.js"></script>
@endpush

@push('scripts')
  <script type="text/javascript">
    ClassicEditor
      .create(document.querySelector('.answer'))
      .catch(error => {
        console.error(error);
      });
      
    $('.repeater').repeater({
      show: function() {
        $(this).slideDown(function() {
          ClassicEditor
            .create($(this).children('.min').find('.answer')[0])
            .catch(error => {
              console.error(error);
            });
        });
      },
      ready: function(setIndexes) {}
    });


    jQuery(document).ready(function($) {
      $('#addmore').on('submit', function(event) {
        $('.question').each(function() {
          $(this).rules("add", {
            required: true,
            messages: {
              required: "Please Enter question",
            }
          });
        });

        $('.answer').each(function() {
          $(this).rules("add", {
            required: true,
            messages: {
              required: "Please Enter answer",
            }
          });
        });
      });

      $('form#addmore').validate({
        errorPlacement: function(error, element) {
          error.insertAfter(element.parent()).addClass('text-danger');
        }
      });
    });
  </script>
@endpush
