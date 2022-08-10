<a class="list-group-item" wire:poll="mountComponent()" @if (strtolower(\Request::route()->getName()) == 'order.chat') {{ 'active' }} @endif" href="{{ route('order.chat') }}"><i class="fa fa-comments-o"></i>
  Chat <span class="badge badge-circle badge-sm badge-danger mx-2 p-2">{{ $chat->count() }}</span>
</a>
