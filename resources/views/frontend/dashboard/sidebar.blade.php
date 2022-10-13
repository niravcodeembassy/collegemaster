<div class="{{ isset($class) ? $class : 'col-lg-3' }}">

  <div class="dashboard-left" style="left: 0px;">
    <div class="list-group">
      <span href="#" class="list-group-item " style="background: #333333; color:white;">
        My account
      </span>
      <a class="list-group-item @if (strtolower(\Request::route()->getName()) == 'profile.index') {{ 'active' }} @endif" href="{{ route('profile.index') }}"> <i class="fa fa-user"></i> Profile</a>
      <a class="list-group-item @if (strtolower(\Request::route()->getName()) == 'changepassword.get') {{ 'active' }} @endif" href="{{ route('changepassword.get') }}"> <i class="fa fa-lock"></i> Change Password</a>
      <a class="list-group-item @if (strtolower(\Request::route()->getName()) == 'orders.list') {{ 'active' }} @endif" href="{{ route('orders.list') }}"><i class="fa fa-truck"></i> Order</a>
      <a class="list-group-item @if (strtolower(\Request::route()->getName()) == 'wishlist.index') {{ 'active' }} @endif" href="{{ route('wishlist.index') }}"><i class="fa fa-list"></i> Wish List</a>
      <a class="list-group-item  @if (strtolower(\Request::route()->getName()) == 'order.chat') {{ 'active' }} @endif" wire:poll="mountComponent()" href="{{ route('order.chat') }}"><i class="fa fa-comments-o"></i>
        Order Chat @livewire('order-counter')
      </a>
      <a class="list-group-item @if (strtolower(\Request::route()->getName()) == 'logout') {{ 'active' }} @endif" href="{{ route('logout') }}"><i class="fa fa-power-off"></i> Logout</a>
    </div>
  </div>

</div>
