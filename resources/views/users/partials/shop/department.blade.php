<div class="category-section">
    <h4>Categories</h4>
    <ul>
        <li>
            <a href="{{ route('users.shop') }}"
               class="{{ request()->is('shop') ? 'active' : '' }}">All</a>
        </li>
        @foreach($categories as $category)
            @if($category->id_danhmuc_cha != null)
                @continue
            @endif
            <li>
                <a href="{{ route('shop.category', $category->slug) }}"
                   class="{{ request()->is('shop/category/'.$category->slug) ? 'active' : '' }}">
                    {{ $category->tendanhmuc }}
                </a>
                @if($category->childCategories->count() > 0)
                    <ul>
                        @foreach($category->childCategories as $child)
                            <li>
                                <a href="{{ route('shop.category', $child->slug) }}"
                                   class="{{ request()->is('shop/category/'.$child->slug) ? 'active' : '' }}">
                                    {{ $child->tendanhmuc }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</div>
