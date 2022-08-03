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
          <ul class="single-sidebar-widget--list single-sidebar-widget--list--category">
            @foreach ($forntcategory as $item)
              <li class="has-children">
                <a class="" href="{{ route('category.product', $item->slug) }}"> {{ ucfirst($item->name) ?? '' }} </a>
                @if ($item->subCategory->count())
                  <ul>
                    @foreach ($item->subCategory as $subItem)
                      <li>
                        <a class="" href="{{ route('product.details', ['cat_slug' => $item->slug, 'product_subcategory_slug' => $subItem->slug, 'slug' => null]) }}">{{ ucfirst($subItem->name) }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                @endif
              </li>
            @endforeach
          </ul>
        </div>
        <!--=======  End of single widget  =======-->
      </div>
      <!--=======  End of contact widget  =======-->
    </div>
    <!--=======  End of overlay content container  =======-->
  </div>
</div>
