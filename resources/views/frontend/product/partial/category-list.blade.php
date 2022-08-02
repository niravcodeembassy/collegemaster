<ul class="single-sidebar-widget--list single-sidebar-widget--list--category">
  <li>
    <a href="{{ route('category.product', 'all') }}" class=" {{ 'all' == $category->slug ? 'active' : '' }}">
      All
    </a>
    <span class="quantity">{{ $AllProductCount }}</span>
  </li>
  
  @foreach ($categoryList as $item)
    <li class="has-children">
      <a class=" {{ $item->id == $category->id ? 'active' : '' }}" href="{{ route('category.product', $item->slug) }}"> {{ $item->name ?? '' }} </a> <span class="quantity">{{ $item->products_count ?? 0 }}</span>
      @if ($item->subCategory->count())
        <ul style="{{ $item->id == $category->id ? 'display: block;' : '' }}">
          @foreach ($item->subCategory as $subItem)
            <li>
              <a class=" {{ isset($subCategory) && $subCategory->id == $subItem->id ? 'active' : '' }}"
                href="{{ route('product.details', ['cat_slug' => $item->slug, 'product_subcategory_slug' => $subItem->slug, 'slug' => null]) }}">{{ $subItem->name }}
              </a>
            </li>
          @endforeach
        </ul>
      @endif
    </li>
  @endforeach
</ul>
