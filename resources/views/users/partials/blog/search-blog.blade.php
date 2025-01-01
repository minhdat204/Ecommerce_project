<div class="blog__sidebar__search">
    <form action="{{ route('users.blogs') }}" method="GET">
        <input type="text" name="keyword" id="searchInput" placeholder="Search..." value="{{ request()->keyword }}">
        <button type="submit"><span class="icon_search"></span></button>
    </form>
</div>
