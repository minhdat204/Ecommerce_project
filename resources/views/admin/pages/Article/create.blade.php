@extends('Admin.Layout.Layout')
@section('namepage', 'Thêm Bài Viết')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Thêm Bài Viết Mới</div>

                    <div class="card-body">
                        <!-- Hiển thị thông báo lỗi nếu có -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('article.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="ArticleName">Tên Bài Viết</label>
                                <input type="text" class="form-control" id="ArticleName" name="ArticleName"
                                    value="{{ old('ArticleName') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="ArticleContent">Nội Dung</label>
                                <textarea class="form-control" id="ArticleContent" name="ArticleContent" rows="5" required>{{ old('ArticleContent') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="categories">Danh Mục</label>
                                <select class="form-control" id="categories" name="categories[]" multiple required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->ID }}">{{ $category->CategoryName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Status">Trạng Thái</label>
                                <select class="form-control" id="Status" name="Status" required>
                                    <option value="1" {{ old('Status') == '1' ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="0" {{ old('Status') == '0' ? 'selected' : '' }}>Vô hiệu hóa</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Thêm</button>
                            <a href="{{ route('article.index') }}" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_custom')
    <script>
        CKEDITOR.replace('ArticleContent');
    </script>
@endsection
