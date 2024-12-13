<div class="blog__sidebar__search">
    <form id="searchForm" action="{{ route('blogs.index') }}" method="GET">
        <input type="text" name="keyword" id="searchInput" placeholder="Search..." value="{{ request()->keyword }}">
        <button type="submit"><span class="icon_search"></span></button>
    </form>
</div>

