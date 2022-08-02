<div class="header-offcanvas about-overlay" id="about-overlay">
  <div class="overlay-close inactive"></div>
  <div class="overlay-content">
    <!--=======  close icon  =======-->
    <span class="close-icon" id="about-close-icon">
      <a href="javascript:void(0)">
        <i class="ti-close"></i>
      </a>
    </span>
    <!--=======  End of close icon  =======-->
    <!--=======  overlay content container  =======-->
    <div class="overlay-content-container d-flex flex-column justify-content-between h-100">
      <!--=======  widget wrapper  =======-->
      <div class="widget-wrapper">
        <!--=======  single widget  =======-->
        <div class="single-widget">
          <h2 class="single-sidebar-widget--title">Categories</h2>
          {!! $category_list_view !!}
        </div>
        <!--=======  End of single widget  =======-->
      </div>
      <!--=======  End of contact widget  =======-->
    </div>
    <!--=======  End of overlay content container  =======-->
  </div>
</div>
