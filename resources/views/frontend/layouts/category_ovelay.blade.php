<div class="header-offcanvas about-overlay" id="category-overlay">
    <div class="overlay-close inactive"></div>
    <div class="overlay-content">
        <!--=======  close icon  =======-->
        <span class="close-icon" id="category-close-icon">
            <a href="javascript:void(0)">
                <i class="ti-close"></i>
            </a>
        </span>
        <h2 class="single-sidebar-widget--title">Categories</h2>
        <!--=======  End of close icon  =======-->
        <!--=======  overlay content container  =======-->
        <div class="overlay-content-container d-flex flex-column justify-content-between h-100">
            <!--=======  widget wrapper  =======-->
            <div class="widget-wrapper">
                <!--=======  single widget  =======-->
                <div class="single-widget">
                    <ul class="single-sidebar-widget--list single-sidebar-widget--list--category">
                        <li>
                            <a href="{{ route('category.product', 'all') }}"
                                class="{{ $active_category == null ? '' : ('all' == $active_category->slug ? 'active' : '') }}">
                                All Product
                            </a>
                            <span class="quantity">{{ $AllProductCount }}</span>
                        </li>

                        @foreach ($categoryList as $item)
                            <li class="has-children">
                                <a class="{{ $active_category == null ? '' : ($item->id == $active_category->id ? 'active' : '') }}"
                                    href="{{ route('category.product', $item->slug) }}"> {{ $item->name ?? '' }} </a>
                                <span class="quantity">{{ $item->products_count ?? 0 }}</span>
                                @if ($item->subCategory->count())
                                    <ul
                                        style="{{ $active_category == null ? '' : ($item->id == $active_category->id ? 'display: block;' : '') }}">
                                        @foreach ($item->subCategory as $subItem)
                                            <li>
                                                <a class=" {{ isset($subCategory) && $subCategory->id == $subItem->id ? 'active' : '' }}"
                                                    href="{{ route('product.details', ['cat_slug' => $item->slug, 'product_subcategory_slug' => $subItem->slug, 'slug' => null]) }}">{{ $subItem->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if ($active_category != null && $item->id == $active_category->id)
                                    <a href="#" class="expand-icon">-</a>
                                @else
                                    <a href="#" class="expand-icon">+</a>
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
