    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#">
                <div id="nav-icon4">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link py-0  " data-toggle="dropdown" href="#">
                <img src="{{ $authUser->profile_src  ?? ''}}"
                style="width:35px;"
                class="user-image  img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">{{ $authUser->name ?? '' }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile.index') }}" class="dropdown-item text-gray">
                    <i class='fa fa-user f-18 pr-1'></i> Profile
                </a>
                <a href="{{ route('admin.logout') }}" class="dropdown-item text-gray">
                    <i class='fa fa-power-off f-18 pr-1'></i> Logout
                </a>
            </div>
        </li>
    </ul>
