<div class="sidebar__item">
    <h4>Danh Mục</h4>
    <ul>
        @foreach($categories as $category)
            <li><a href="{{ route('shop.category', $category->id_danhmuc) }}">{{ $category->tendanhmuc }}</a></li>
        @endforeach
    </ul>
</div>
