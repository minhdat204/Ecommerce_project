@extends('Admin.Layout.Layout')
@section('namepage', 'Sửa Bài Viết')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Sửa Bài Viết</div>

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
                        <form action="{{ route('article.update', $article->ID) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="ArticleName">Tên bài viết:</label>
                                <input type="text" class="form-control" id="ArticleName" name="ArticleName"
                                    value="{{ $article->ArticleName }}" required>
                            </div>

                            <div class="form-group">
                                <label for="ArticleContent">Nội dung bài viết:</label>
                                <textarea class="form-control" id="ArticleContent" name="ArticleContent" required>{{ $article->ArticleContent }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="categories">Danh mục:</label>
                                <select class="form-control" name="categories[]" multiple>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->ID }}"
                                            {{ in_array($category->ID, $article->categories->pluck('ID')->toArray()) ? 'selected' : '' }}>
                                            {{ $category->CategoryName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="Status">Trạng thái:</label>
                                <select class="form-control" name="Status">
                                    <option value="1" {{ $article->Status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                    <option value="0" {{ $article->Status == 0 ? 'selected' : '' }}>Ẩn</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_custom')
    <script>
        CKEDITOR.replace('ArticleContent', 'ArticleName');
    </script>
@endsection
