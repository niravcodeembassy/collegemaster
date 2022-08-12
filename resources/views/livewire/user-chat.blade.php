<main class="content" wire:poll="mountComponent">
  <div class="container p-0">
    <div class="card">
      <div class="row g-0">
        <div class="col-12  col-lg-4 border-right order_div">
          <div class="px-4 d-none d-md-block">
            <div class="d-flex align-items-center">
              <div class="flex-grow-1">
                <input type="text" class="form-control my-3" name="search" value="" placeholder="Search by order No" wire:model="search" />
              </div>
            </div>
          </div>
          @foreach ($orders as $order)
            @php
              $not_seen =
                  \App\Model\Message::where('order_id', $order->id)
                      ->where('user_id', $admin->id)
                      ->where('is_seen', false)
                      ->get() ?? null;
              $latest =
                  \App\Model\Message::where('order_id', $order->id)
                      ->where('user_id', $admin->id)
                      ->latest()
                      ->first() ?? null;
            @endphp
            <a href="#" wire:click="getUser({{ $order->id }})" id="order_{{ $order->id }}" class="list-group-item list-group-item-action border-0">
              @if (filled($not_seen))
                <div class="badge bg-warning float-right"> {{ $not_seen->count() }}</div>
              @endif
              <div class="d-flex align-items-start">
                <div class="symbol symbol-45px symbol-circle">
                  <span class="symbol-label bg-light-danger text-info fs-6 fw-bolder">{{ $order->order_no ?? '' }}</span>
                  @if (isset($clicked_user) && $clicked_user->id == $order->id)
                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2"></div>
                  @endif
                </div>
                <div class="flex-grow-1 ml-3">
                  {{ ucwords($order->user->name) ?? '' }}
                  @if (!is_null($latest))
                    <div class="small"> {{ $latest->created_at->diffForHumans(null, true) }}</div>
                  @endif
                </div>
              </div>
            </a>
          @endforeach


          <hr class="d-block d-lg-none mt-1 mb-0">
        </div>
        <div class="col-12 col-lg-8 header-div">
          @if ($show)
            <div class="py-2 px-4 border-bottom">
              <div class="d-flex align-items-center py-1">
                <div class="position-relative">
                  <img src="{{ $admin->profile_src ?? '' }}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                </div>
                <div class="flex-grow-1 pl-3">
                  <strong>{{ ucwords($admin->name) ?? '' }}</strong>
                </div>
              </div>
              <strong class="text-bold pb-2">Order No : <span class="badge badge-info rounded">{{ $clicked_user->order_no ?? '' }}</span></strong>
            </div>
            <div class="position-relative">
              <div class="chat-messages p-4 scroll_div">
                @if (!$messages)
                  <div class="chat-name">Here Is chat Dashboard</div>
                @else
                  @if (isset($messages))
                    @foreach ($messages as $message)
                      @php
                        $className = $message->user_id == auth()->id() ? 'chat-message-right' : 'chat-message-left';
                        $position = $message->user_id == auth()->id() ? 'mr-3' : 'ml-3';
                        $flex = $message->user_id == auth()->id() ? 'align-items-end' : 'align-items-start';
                      @endphp
                      <div class="{{ $className }} pb-4">
                        <div class="d-flex flex-column {{ $flex }}">
                          <div class="d-flex align-items-center mb-2">
                            <img src="{{ $message->user->profile_src ?? '' }}" class="rounded-circle avatar mr-1" alt="Chris Wood">
                            <div class="ms-3">
                              <a href="javascript:void(0)" class="fw-bolder text-gray-900 text-hover-primary me-1">{{ ucwords($message->user->name) ?? '' }}</a>
                              <span class="text-muted small fs-7 mb-1">{{ $message->created_at->diffForHumans() ?? '' }}</span>
                            </div>
                          </div>
                        </div>
                        @if (!empty($message->message))
                          <div class="flex-shrink-1 bg-light rounded py-2 px-3 {{ $position }}">
                            <span> {{ $message->message }}</span>
                          </div>
                        @endif
                        @if (Uploader::isPhoto($message->file))
                          <div class="flex-shrink-1 rounded py-2 px-3 {{ $position }}">
                            <img class="img-fluid rounded media" loading="lazy" src="{{ $message->file }}"><br />
                            <a href="{{ $message->file }}" download="{{ $message->file_name }}" class="bg-light p-2 image_download rounded-pill"><i class="fa fa-download"></i>
                              {{ $message->file_name }}
                            </a>
                          </div>
                        @elseif (Uploader::isVideo($message->file))
                          <div class="flex-shrink-1 rounded py-2 px-3 {{ $position }}">
                            <video class="img-fluid rounded media_video" controls>
                              <source src="{{ $message->file }}">
                            </video>
                            <a href="{{ $message->file }}" download="{{ $message->file_name }}" class="bg-light p-2 download rounded-pill"><i class="fa fa-download"></i>
                              {{ $message->file_name }}
                            </a>
                          </div>
                        @elseif($message->file)
                          <div class="flex-shrink-1 rounded py-2 px-3 {{ $position }}">
                            <a href="{{ $message->file }}" download="{{ $message->file_name }}" class="bg-light download p-2 rounded-pill"><i class="fa fa-download"></i>
                              {{ $message->file_name }}
                            </a>
                          </div>
                        @endif
                      </div>
                    @endforeach
                  @endif
                @endif
              </div>
            </div>
            <div class="flex-grow-0 py-3 px-4 border-top">
              <form wire:submit.prevent="SendMessage" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-12">
                    <div wire:loading="" wire:target="SendMessage">
                      Sending message . . .
                    </div>
                    <div wire:loading="" wire:target="file">
                      Uploading file . . .
                    </div>
                    @if ($file)
                      <section>
                        {{ $file->getClientOriginalName() }}
                        <button type="button" wire:click="resetFile" class="btn btn-danger btn-sm rounded file_button"><i class="fa fa-times px-1"></i>
                        </button>
                      </section>
                    @endif
                  </div>
                  <div class="col-md-12">
                    <textarea wire:model.defer="message" class="form-control form-control-flush" rows="2" placeholder="Type a message" id="message" wire:keydown.enter="SendMessage" @if (!$file) required @endif></textarea>
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
          @else
            <div class="py-2 px-4 border-bottom d-none d-lg-block">
              <div class="d-flex align-items-center py-1">
                <div class="position-relative">
                  <img src="{{ auth()->user()->profile_src ?? '' }}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                </div>
                <div class="flex-grow-1 pl-3">
                  <strong>{{ ucwords(auth()->user()->name) ?? '' }}</strong>
                </div>
              </div>
            </div>
            <div class="position-relative">
              <div class="text-center d-block">
                <img class="overlay-wrapper h-300px bgi-no-repeat bgi-size-contain bgi-position-center" src="{{ asset('front/assets/images/1.png') }}" alt="">
              </div>
              <div class="chat-messages_display p-4">
                <div class="h3 text-center">Here is chat Dashboard</div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</main>
