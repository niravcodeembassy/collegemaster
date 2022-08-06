<!-- Brand Logo -->
<a href="{{ route('admin.home') }}" class="brand-link text-center">
  {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
    style="opacity: .8"> --}}
  <span class="brand-text font-weight-bold ">Collage Master</span>
</a>

<!-- Sidebar -->
<div class="sidebar">

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar  flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class

                with font-awesome or any other icon font library -->
      <li class="nav-item">
        <a href="{{ route('admin.home') }}" class="nav-link  {{ Helper::isActive(['home']) }}">
          <i class="px-1  nav-icon f-18 fa fa-home d-inline-block"></i>
          <p class="align-middle">
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.category.index') }}" class="nav-link  {{ Helper::isActive(['category.*']) }}">
          <i class="px-1">
            <svg aria-hidden="true" width="18" focusable="false" data-prefix="fad" data-icon="list-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-list-alt fa-2x">
              <g class="fa-group">
                <path fill="currentColor"
                  d="M464 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h416a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48zM128 392a40 40 0 1 1 40-40 40 40 0 0 1-40 40zm0-96a40 40 0 1 1 40-40 40 40 0 0 1-40 40zm0-96a40 40 0 1 1 40-40 40 40 0 0 1-40 40zm288 168a12 12 0 0 1-12 12H204a12 12 0 0 1-12-12v-32a12 12 0 0 1 12-12h200a12 12 0 0 1 12 12zm0-96a12 12 0 0 1-12 12H204a12 12 0 0 1-12-12v-32a12 12 0 0 1 12-12h200a12 12 0 0 1 12 12zm0-96a12 12 0 0 1-12 12H204a12 12 0 0 1-12-12v-32a12 12 0 0 1 12-12h200a12 12 0 0 1 12 12z"
                  class="fa-secondary"></path>
                <path fill="currentColor" d="M128 200a40 40 0 1 0-40-40 40 40 0 0 0 40 40zm0 16a40 40 0 1 0 40 40 40 40 0 0 0-40-40zm0 96a40 40 0 1 0 40 40 40 40 0 0 0-40-40z" class="fa-primary"></path>
              </g>
            </svg>
          </i>
          <p class="align-middle">
            Category
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.sub-category.index') }}" class="nav-link  {{ Helper::isActive(['sub-category.*']) }}">
          <i class="px-1">
            <svg aria-hidden="true" width="18" focusable="false" data-prefix="fad" data-icon="list-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-list-alt fa-2x">
              <g class="fa-group">
                <path fill="currentColor"
                  d="M464 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h416a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48zM128 392a40 40 0 1 1 40-40 40 40 0 0 1-40 40zm0-96a40 40 0 1 1 40-40 40 40 0 0 1-40 40zm0-96a40 40 0 1 1 40-40 40 40 0 0 1-40 40zm288 168a12 12 0 0 1-12 12H204a12 12 0 0 1-12-12v-32a12 12 0 0 1 12-12h200a12 12 0 0 1 12 12zm0-96a12 12 0 0 1-12 12H204a12 12 0 0 1-12-12v-32a12 12 0 0 1 12-12h200a12 12 0 0 1 12 12zm0-96a12 12 0 0 1-12 12H204a12 12 0 0 1-12-12v-32a12 12 0 0 1 12-12h200a12 12 0 0 1 12 12z"
                  class="fa-secondary"></path>
                <path fill="currentColor" d="M128 200a40 40 0 1 0-40-40 40 40 0 0 0 40 40zm0 16a40 40 0 1 0 40 40 40 40 0 0 0-40-40zm0 96a40 40 0 1 0 40 40 40 40 0 0 0-40-40z" class="fa-primary"></path>
              </g>
            </svg>
          </i>
          <p class="align-middle">
            Sub Category
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.product.index') }}" class="nav-link  {{ Helper::isActive(['product.*']) }}">
          <i class="px-1">
            <svg aria-hidden="true" width="18" focusable="false" data-prefix="fad" data-icon="bags-shopping" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-bags-shopping fa-w-18 fa-2x">
              <g class="fa-group">
                <path fill="currentColor"
                  d="M448 192a32 32 0 0 0-32-32h-96V96a96 96 0 0 0-192 0v64H32a32 32 0 0 0-32 32v256a32 32 0 0 0 32 32h128V256a32 32 0 0 1 32-32h256zm-176-32h-96V96a48 48 0 0 1 96 0zm200 160h-16a8 8 0 0 0-8 8v24a64.07 64.07 0 0 1-70.38 63.69c-33.25-3.23-57.62-33.12-57.62-66.53V328a8 8 0 0 0-8-8h-16a8 8 0 0 0-8 8v20.66c0 48.79 35 92.32 83.37 98.53A96.12 96.12 0 0 0 480 352v-24a8 8 0 0 0-8-8z"
                  class="fa-secondary"></path>
                <path fill="currentColor"
                  d="M544 256H224a32 32 0 0 0-32 32v192a32 32 0 0 0 32 32h320a32 32 0 0 0 32-32V288a32 32 0 0 0-32-32zm-64 96a96.12 96.12 0 0 1-108.63 95.19C323 441 288 397.45 288 348.66V328a8 8 0 0 1 8-8h16a8 8 0 0 1 8 8v21.16c0 33.41 24.37 63.3 57.62 66.53A64.07 64.07 0 0 0 448 352v-24a8 8 0 0 1 8-8h16a8 8 0 0 1 8 8z"
                  class="fa-primary"></path>
              </g>
            </svg>
          </i>
          <p class="align-middle">
            Product
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.inventory.index') }}" class="nav-link  {{ Helper::isActive(['inventory.*']) }}">
          <i class="px-1  nav-icon f-18 fa fa-clipboard d-inline-block"></i>
          <p class="align-middle">
            Inventory
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.customer.index') }}" class="nav-link  {{ Helper::isActive(['customer.*']) }}">
          <i class="px-1  nav-icon f-18 fa fa-user-astronaut d-inline-block"></i>
          <p class="align-middle">
            Customers
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.blog.index') }}" class="nav-link  {{ Helper::isActive(['blog.*']) }}">
          <i class="px-1  nav-icon f-18 fas fa-blog d-inline-block"></i>
          <p class="align-middle">
            Blog
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.tag.index') }}" class="nav-link  {{ Helper::isActive(['tag.*']) }}">
          <i class="px-1  nav-icon f-18 fas fa-tag d-inline-block"></i>
          <p class="align-middle">
            Tag
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.testimonial.index') }}" class="nav-link  {{ Helper::isActive(['testimonial.*']) }}">
          <i class="px-1  nav-icon f-18 fa fa-quote-left d-inline-block"></i>
          <p class="align-middle">
            Testimonial
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.team.index') }}" class="nav-link  {{ Helper::isActive(['team.*']) }}">
          <i class="px-1  nav-icon f-18 fa fa-users d-inline-block"></i>
          <p class="align-middle">
            Team Member
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.order.index', ['type' => 'online']) }}" class="nav-link  {{ Helper::isActive(['order.*']) }}">
          <i class="px-1  nav-icon f-18 fa fa fa-shopping-bag d-inline-block"></i>
          <p class="align-middle">
            Order
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.discount.index') }}" class="nav-link  {{ Helper::isActive(['discount.*']) }}">
          <i class="px-1  nav-icon f-18 fa fa-percent d-inline-block"></i>
          <p class="align-middle">
            Discount
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.contact.index') }}" class="nav-link  {{ Helper::isActive(['contact.*']) }}">
          <i class="px-1  nav-icon f-18 fa fa fa-envelope d-inline-block"></i>
          <p class="align-middle">
            Contact US
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.newsletter.index') }}" class="nav-link  {{ Helper::isActive(['newsletter.*']) }}">
          <i class="px-1  nav-icon f-18 fa fa-smile d-inline-block"></i>
          <p class="align-middle">
            Newsletter
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.review.index') }}" class="nav-link  {{ Helper::isActive(['review.*']) }}">
          <i class="px-1  nav-icon f-18 fa fa-user-astronaut d-inline-block"></i>
          <p class="align-middle">
            Review
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.website-setting') }}" class="nav-link  {{ Helper::isActive(['website-setting']) }}">
          <i class='fa fa-cog f-18  px-1'></i>
          <p class="align-middle">
            Setting
          </p>
        </a>
      </li>
      <li class="nav-item has-treeview">
        <a href="pages/widgets.html" class="nav-link  {{ Helper::isActive(['user.*', 'role.*', 'permission.*']) }}">
          <i class="nav-icon fa fa-user f-18  px-1"></i>
          <p> User setting <i class="right fa fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview  ">
          <li class="nav-item">
            <a href="{{ route('admin.user.index') }}" class="nav-link {{ Helper::isActive(['user.*']) }}">
              <i class='fa fa-user f-18 px-1'></i>
              <p class="align-middle">
                Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.role.index') }}" class="nav-link {{ Helper::isActive(['role.*']) }}">
              <i class="fa fa-user-shield f-18 px-1"></i>
              <p class="align-middle">
                Role
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.permission.index') }}" class="nav-link {{ Helper::isActive(['permission.*']) }} ">
              <i class='fa fa-key f-18 px-1'></i>
              <p class="align-middle">
                Permission
              </p>
            </a>
          </li>
        </ul>
      </li>


      <li class="nav-item has-treeview">
        <a href="pages/widgets.html" class="nav-link  {{ Helper::isActive(['log-viewer::dashboard', 'log-viewer::logs.list']) }}">
          <i class="nav-icon fa fa-fw fa-list f-18  px-1"></i>
          <p> Log viewer <i class="right fa fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          {{-- <li class="nav-item">
            <a href="{{ route('log-viewer::dashboard') }}" class="nav-link
                    {{ Helper::isActive(['log-viewer::dashboard'] ) }} ">
              <i class='fa fa-tachometer-alt f-18 px-1'></i>
              <p class="align-middle">
                @lang('Dashboard')
              </p>
            </a>
          </li> --}}
          <li class="nav-item">
            <a href="{{ route('log-viewer::logs.list') }}" class="nav-link {{ Helper::isActive(['log-viewer::logs.list']) }} ">
              <i class="fa fa-layer-group f-18 px-1"></i>
              <p class="align-middle">
                @lang('Logs')
              </p>
            </a>
          </li>
        </ul>
      </li>


    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
