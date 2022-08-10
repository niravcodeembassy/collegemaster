<li class="nav-item" wire:poll="mountComponent()">
  <a href="{{ route('admin.chat.order') }}" class="nav-link  {{ Helper::isActive(['admin.chat.order']) }}">
    <i class="px-1 nav-icon f-18  fas fa-comment-dots d-inline-block"></i>
    <p class="align-middle">
      Chat <span class="badge badge-sm badge-danger mx-2 p-2">{{ $chat->count() }}</span>
    </p>
  </a>
</li>
