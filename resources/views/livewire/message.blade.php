<div class="d-flex flex-column flex-lg-row" wire:poll.keep-alive>
  <!--begin::Sidebar-->
  @if ($admin_user)
    <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
      <!--begin::Contacts-->
      <div class="card header-div card-flush">
        <!--begin::Card header-->
        <div class="card-header pt-7" id="kt_chat_contacts_header">
          <!--begin::Form-->
          <form class="w-100 position-relative" autocomplete="off">
            <!--begin::Icon-->
            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
            <span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                <path
                  d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                  fill="black" />
              </svg>
            </span>
            <!--end::Svg Icon-->
            <!--end::Icon-->
            <!--begin::Input-->
            <input type="text" class="form-control form-control-solid px-15" name="search" value="" placeholder="Search by username or email..." wire:model="search" />
            <!--end::Input-->
          </form>
          <!--end::Form-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body chatbox pt-5" id="kt_chat_contacts_body" wire:poll.10ms="mountComponent()">
          <!--begin::List-->
          <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
            data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header" data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="5px">
            <!--begin::User-->
            @foreach ($orders as $order)
              @php
                $not_seen =
                    \App\Model\Message::where('order_id', $order->id)
                        ->where('is_seen', false)
                        ->get() ?? null;
                $latest =
                    \App\Model\Message::where('order_id', $order->id)
                        ->latest()
                        ->first() ?? null;
              @endphp
              <div class="d-flex flex-stack py-4">
                <!--begin::Details-->
                <div class="d-flex align-items-center">
                  <!--begin::Avatar-->
                  <div class="symbol symbol-45px symbol-circle">
                    <span class="symbol-label bg-light-danger text-info fs-6 fw-bolder">{{ $order->id ?? '' }}</span>
                  </div>
                  <!--end::Avatar-->
                  <!--begin::Details-->
                  <div class="ms-5">
                    <a wire:click="getUser({{ $order->id }})" id="order_{{ $order->id }}" style="cursor: pointer" href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2">{{ $order->user->name ?? '' }}</a>
                    <div class="fw-bold text-muted">{{ $order->user->email ?? '' }}</div>
                  </div>
                  <!--end::Details-->
                </div>
                <!--end::Details-->
                <!--begin::Lat seen-->
                <div class="d-flex flex-column align-items-end ms-2">
                  <span class="text-muted fs-7">5 mins</span>
                  {{-- <span class="text-muted fs-7">{{ $latest->created_at->diffForHumans(null, true) }}</span>
                  @if (filled($not_seen))
                    <span class="badge badge-sm badge-circle badge-light-warning">{{ $not_seen->count() }}
                    </span>
                  @endif --}}
                </div>
                <!--end::Lat seen-->
              </div>
              <div class="separator separator-dashed d-none"></div>
            @endforeach


          </div>
          <!--end::List-->
        </div>
        <!--end::Card body-->
      </div>
      <!--end::Contacts-->
    </div>
  @endif
  <!--end::Sidebar-->
  <!--begin::Content-->
  <div class="flex-lg-row-fluid {{ $admin_user ? 'ms-lg-7 ms-xl-10' : '' }}">
    <!--begin::Messenger-->
    <div class="card {{ $show ? 'main_div' : 'not_main_div' }}" id="kt_chat_messenger">
      <!--begin::Card header-->
      <div class="card-header" id="kt_chat_messenger_header">
        <!--begin::Title-->
        <div class="card-title">
          <!--begin::User-->
          <div class="d-flex justify-content-center flex-column me-3">
            @if (isset($clicked_user))
              <a href="javascript:void(0)" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1 text-capitalize">{{ $clicked_user->user->name ?? '' }}</a>
            @elseif ($admin_user)
              <a href="javascript:void(0)" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1 text-capitalize">Admin</a>
            @else
              <a href="javascript:void(0)" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1">
                Select a
                user to see the chat</a>
            @endif
          </div>
          <!--end::User-->
        </div>
      </div>
      <!--end::Card header-->
      <!--begin::Card body-->
      <div class="card-body message-box" id="kt_chat_messenger_body" @if (!$admin_user) wire:poll.10ms="mountComponent()" @endif>
        <!--begin::Messages-->
        <div class="scroll-y me-n5 pe-5" id="scroll_body">
          @if (!$messages)
            <div class="p-5 rounded text-dark fw-bold mw-lg-300px bg-light-info text-start" data-kt-element="message-text"> Here is chat dashboard</div>
          @else
            @if ((isset($messages) && isset($clicked_user)) || !$admin_user)
              @foreach ($messages as $message)
                @php
                  $className = $message->user_id !== auth()->id() ? 'justify-content-start' : 'justify-content-end';
                  $avatar = $message->user_id !== auth()->id() ? 'align-items-start' : 'align-items-end';
                  $align = $message->user_id !== auth()->id() ? 'bg-light-info' : 'bg-light-primary';
                  if ($admin_user) {
                      $className = $message->user_id == $admin->id ? 'justify-content-end' : 'justify-content-start';
                      $avatar = $message->user_id == $admin->id ? 'align-items-end' : 'align-items-start';
                      $align = $message->user_id == $admin->id ? 'bg-light-primary' : 'bg-light-info';
                  }
                @endphp
                <div class="d-flex {{ $className }} mb-10">
                  <!--begin::Wrapper-->
                  <div class="d-flex flex-column {{ $avatar }}">
                    <!--begin::User-->
                    <div class="d-flex align-items-center mb-2">
                      <!--begin::Avatar-->
                      <div class="symbol symbol-35px symbol-circle">
                        <img alt="Pic" src="{{ $message->user->profile_src ?? '' }}" />
                      </div>
                      <!--end::Avatar-->
                      <!--begin::Details-->
                      <div class="ms-3">
                        <a href="javascript:void(0)" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">{{ $message->user->name ?? '' }}</a>
                        <span class="text-muted fs-7 mb-1">{{ $message->created_at->diffForHumans() ?? '' }}</span>
                      </div>
                      <!--end::Details-->
                    </div>
                    <!--end::User-->
                    <!--begin::Text-->
                    @if (!empty($message->message))
                      <div class="p-5 rounded text-dark fw-bold mw-lg-400px text-start {{ $align }}" data-kt-element="message-text">{{ $message->message }}</div>
                    @endif

                    @if (Uploader::isPhoto($message->file))
                      <div class="w-100 my-2">
                        <img class="img-fluid rounded media" loading="lazy" src="{{ $message->file }}">
                      </div>
                      <div class="w-100 my-2">
                        <a href="{{ $message->file }}" download="{{ $message->file_name }}" class="bg-light p-2 rounded-pill"><i class="fa fa-download"></i>
                          {{ $message->file_name }}
                        </a>
                      </div>
                    @elseif (Uploader::isVideo($message->file))
                      <div class="w-100 my-2">
                        <video class="img-fluid rounded media" controls>
                          <source src="{{ $message->file }}">
                        </video>
                      </div>
                      <div class="w-100 my-2">
                        <a href="{{ $message->file }}" download="{{ $message->file_name }}" class="bg-light p-2 rounded-pill"><i class="fa fa-download"></i>
                          {{ $message->file_name }}
                        </a>
                      </div>
                    @elseif ($message->file)
                      <div class="w-100 my-2">
                        <a href="{{ $message->file }}" download="{{ $message->file_name }}" class="bg-light p-2 rounded-pill"><i class="fa fa-download"></i>
                          {{ $message->file_name }}
                        </a>
                      </div>
                    @endif
                  </div>
                  <!--end::Wrapper-->
                </div>
              @endforeach
            @else
              <div class="d-flex justify-content-start mb-20">
                <div class="w-100 my-2">
                  <div class="card card-stretch">
                    <div class="card-body">
                      <div class="text-center d-block">
                        <img class="overlay-wrapper h-300px bgi-no-repeat bgi-size-contain bgi-position-center" src="{{ asset('admin/assets/media/illustrations/sigma-1/1.png') }}" alt="">
                      </div>
                      <div class="d-flex flex-column mt-4">
                        <span class="h1 text-center">Click on a user to see the
                          messages</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          @endif
        </div>
        <!--end::Messages-->
      </div>
      <!--end::Card body-->
      <!--begin::Card footer-->
      @if ($show)
        <div class="card-footer pt-4" id="kt_chat_messenger_footer">
          <form wire:submit.prevent="SendMessage" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-12">
                <div wire:loading wire:target='SendMessage'>
                  Sending message . . .
                </div>
                <div wire:loading wire:target="file">
                  Uploading file . . .
                </div>
                @if ($file)
                  <section>
                    {{ $file->getClientOriginalName() }}
                    <button type="button" wire:click="resetFile" class="btn btn-danger rounded file_button"><i class="fa fa-times px-1"></i>
                    </button>
                  </section>
                @endif
              </div>
              <div class="col-md-12">
                <textarea wire:model="message" class="form-control form-control-flush" rows="2" placeholder="Type a message" id="message" wire:keydown.enter="SendMessage" @if (!$file) required @endif></textarea>
                <div class="d-flex flex-stack">
                  <div class="d-flex align-items-center me-2">
                    @if (empty($file))
                      <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" id="file-area" data-bs-toggle="tooltip" title="uplod">
                        <label>
                          <i class="fa fa-upload fs-3"></i>
                          <input type="file" wire:model="file">
                        </label>
                      </button>
                    @endif
                  </div>
                  <button class="btn btn-primary" type="submit" data-kt-element="send">Send</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      @endif
      <!--end::Card footer-->
    </div>
    <!--end::Messenger-->
  </div>
  <!--end::Content-->
</div>
