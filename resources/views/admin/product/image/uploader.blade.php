@extends('admin.layouts.app')

@section('title', $title)

@section('content')
  @component('component.heading',
      [
          'page_title' => 'Upload Image',
          'icon' => 'fa fa-shopping-cart',
          'tagline' => 'Lorem ipsum dolor sit amet.',
          'action' => route(request()->get('route', 'admin.product.edit'), $product->id),
          'action_icon' => 'fa fa-arrow-left',
          'text' => 'Back',
      ])
  @endcomponent

  <div id="app">


    <form @submit="onSubmit" id="product_form" enctype="multipart/form-data">
      <div class="upload-btn-wrapper">
        <button class="btn"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
        <input accept="image/jpeg, image/png" type="file" multiple name="images[]" @change="addFiles($event)" />
      </div>


      <template v-if="files.length > 0">
        <div class="ml-0 mt-2" id="main_card" data-remove-url="{{ route('admin.product.image.remove', ['product_id' => $product->id]) }}" data-position-url="{{ route('admin.product.image.position', ['product_id' => $product->id]) }}">
          <draggable v-model="files" group="people" @start="drag=true" @end="drag=false" class="row">
            <template v-for="(_, index) in Array.from({ length: files.length })">
              <div class="col-md-6">
                <div class="card w-100 parent" :data-index="index">
                  <div class="d-flex">
                    <div class="img">
                      <img v-bind:src="loadFile(files[index])" class="position-relative border-4 border-white preview" />
                      <div class="image_size">
                        <span class="text-xs" v-text="humanFileSize(files[index].size)">...</span>
                      </div>
                    </div>

                    <div class="text">
                      <div class="form-group">
                        <label for="image_name">Name</label>
                        <input type="text" class="form-control" :name="`image_name[${index}]['name']`" v-model="files[index].name">
                      </div>
                      <div class="form-group">
                        <label for="image_alt">Image alt text</label>
                        <input type="text" class="form-control" :name="`image_alt[${index}]['alt']`" v-model="files[index].alt">
                      </div>
                    </div>
                    <div class="icon float-end">
                      <span class="fa fa-eye font-btn pt-2 mx-2" @click="modalImage(files[index])" data-toggle="modal" data-target="#show_image" :image="loadFile(files[index])"></span>
                      <button class="remove_img float-end p-1
                                  bg-white border-0" type="button" @click="remove(index)">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </template>
          </draggable>
          <div class="pull-right mb-2">
            <button type="submit" name="submit" id="save_exit" value="save_exit" class="btn btn-sm btn-info shadow ">
              Upload
            </button>
          </div>
        </div>
      </template>

      <div class="d-flex justify-content-end mt-4">
        <a href="{{ route(request()->get('route', 'admin.product.index'), ['id' => $product->id]) }}" name="submit" value="save_exit" class="btn btn-outline-danger mx-2 shadow"> Save & Exit
        </a>
        @if ($productvariant > 1)
          <a href="{{ route('admin.variation.variation_edit', $product->id) }}" id="save_add_variant" name="submit" value="save_add_variant" class="btn btn-success shadow"> Goto Variation{{-- Update variation --}}
          </a>
        @else
          {{-- <div class="wrap"> --}}
          <a href="{{ route('admin.variation.create', $product->id) }}" id="save_add_variant" name="submit" value="save_add_variant" class="btn btn-success shadow"> Add variation
          </a>
          {{-- </div> --}}
        @endif
      </div>

    </form>
    @include('admin.product.image.showimage')
    <div id="load-modal"></div>
  </div>




@endsection

@push('style')
  <style>
    .upload-btn-wrapper {
      position: relative;
      overflow: hidden;
      display: inline-block;
    }

    .upload-btn-wrapper .btn {
      border: 2px solid gray;
      color: gray;
      background-color: white;
      padding: 8px 20px;
      border-radius: 8px;
      font-size: 20px;
      font-weight: bold;
    }

    .upload-btn-wrapper input[type=file] {
      font-size: 100px;
      position: absolute;
      left: 0;
      top: 0;
      opacity: 0;
    }

    .main_div {
      padding-top: 30px;
      padding-bottom: 30px;
    }

    .remove_img {
      top: 7px;
      right: 7px;
      z-index: 50;
      cursor: pointer;
    }

    .main_div>input {
      height: 100%;
      width: 100%;
      opacity: 0;
      cursor: pointer;
    }

    .image_thumbnail svg {
      width: 25px;
      height: 25px;
    }


    div.img {
      width: 25% !important;
    }

    div.text {
      width: 65% !important;
      vertical-align: middle;
      padding-top: 10px;
      padding-bottom: 10px;
    }

    div.icon {
      width: 10% !important;
    }

    div.img img {
      width: 160px;
      height: 100%;
      border-radius: 8px;
    }

    div.image_size {
      position: absolute;
      bottom: 0;
      background: transparent;
      width: 160px;
    }

    .image_size span {
      opacity: 0.8;
      display: flex;
      background: white;
      justify-content: center;
    }
  </style>
@endpush

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
  <!-- CDNJS :: Vue.Draggable (https://cdnjs.com/) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>
  <script src="https://unpkg.com/create-file-list"></script>
  <script src="{{ asset('js/serialize.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js" integrity="sha512-odNmoc1XJy5x1TMVMdC7EMs3IVdItLPlCeL5vSUPN2llYKMJ2eByTTAIiiuqLg+GdNr9hF6z81p27DArRFKT7A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush

@push('scripts')
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        files: [],
      },
      methods: {
        humanFileSize(size) {
          const i = Math.floor(Math.log(size) / Math.log(1024));
          return (
            (size / Math.pow(1024, i)).toFixed(2) * 1 +
            " " + ["B", "kB", "MB", "GB", "TB"][i]
          );
        },
        async remove(index) {
          let files = [...this.files];
          var del = files[index];
          const url = $('#main_card').data('remove-url');

          message.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value == true) {
              showLoader();
              var data = {
                id: del.id,
                date: new Date()
              }
              if (del.id !== null) {
                axios.post(url, data)
                  .then((response) => {
                    message.fire({
                      title: 'Success',
                      text: "Image remove successfully.",
                      type: 'success',
                    });
                  })
              }
              stopLoader();
              files.splice(index, 1);
              this.files = files;
            }
          });
        },
        loadFile(file) {
          const preview = document.querySelectorAll(".preview");
          if (file.image instanceof File && file.image.type.includes('image/')) {
            const blobUrl = URL.createObjectURL(file.image);
            preview.forEach(elem => {
              elem.onload = () => {
                URL.revokeObjectURL(elem.src); // free memory
              };
            });
            return blobUrl;
          }
          return file.dataURL;
        },
        modalImage(e) {
          let alt = e.alt;
          let img = this.loadFile(e);
          $('#sho-img').attr('src', img);
          $('#sho-img').attr('alt', alt);
        },
        addFiles(e) {
          var files = e.target.files;
          if (files) {
            var files_count = files.length;
            for (let i = 0; i < files_count; i++) {
              this.files.push({
                "alt": files[i].name,
                "image": files[i],
                "dataURL": null,
                "is_delelt": false,
                "position": null,
                "progress": 100,
                "name": files[i].name,
                "size": files[i].size,
                "id": null,
                "removeUrl": null,
                "upload": {
                  "uuid": null,
                  "id": null
                },
                "accepted": true,
                "width": 255
              });
            }
          }
        },
        async onSubmit(e) {
          e.preventDefault();
          const url = '{{ route('admin.image.store', $product->id) }}';
          const formData = this.files;
          showLoader();
          axios.post(url, formData, {
              transformRequest: [
                function(data, headers) {
                  return serialize({
                    'record': data
                  }, {
                    indices: true
                  });
                },
              ]
            })
            .then((response) => {
              this.files = [];
              if (response.data.success) {
                message.fire({
                  title: 'Success',
                  text: "Image uploaded successfully.",
                  type: 'success',
                });
                stopLoader();
                let previewFile = response.data.preview_file;
                if (!jQuery.isEmptyObject(previewFile)) {
                  let preview = [...previewFile];
                  this.files = preview.sort((a, b) => {
                    return a.position - b.position;
                  });
                }
              }
            });
        }
      },
      mounted() {
        var mokup = @json($mockup);
        if (!jQuery.isEmptyObject(mokup)) {
          this.files = [...mokup];
          // console.log(this.files);
        }
      }
    });
  </script>
@endpush
