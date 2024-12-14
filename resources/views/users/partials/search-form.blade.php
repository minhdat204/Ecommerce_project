<form action="{{ route('search.results') }}" method="GET">
    <div class="form-group">
        <label for="category">Danh mục</label>
        <select name="category" id="category" class="form-control">
            <option value="">Tất cả</option>
            @foreach($categories as $category)
                <option value="{{ $category->id_danhmuc }}">{{ $category->tendanhmuc }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="search_term">Từ khóa</label>
        <input type="text" name="search_term" id="search_term" class="form-control" placeholder="Tìm kiếm sản phẩm">
    </div>

    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
</form>
