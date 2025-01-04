@extends('Admin.Layout.Layout')
@section('namepage', 'Tìm Kiếm Bài Viết')

@section('content')
    <div class="container">
        <div class="table-wrapper">
            <!-- Tiêu đề bảng -->
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Kết Quả Tìm Kiếm <b>Bài Viết</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <!-- Nút Quay Lại Trang Danh Sách -->
                        <a href="{{ route('article.index') }}" class="btn btn-secondary">
                            <i class="material-icons">&#xE5C4;</i> <span>Quay Lại</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Bảng Bài Viết Tìm Kiếm -->
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Bài Viết</th>
                        <th>Nội Dung</th>
                        <th>Thời Gian Đăng</th>
                        <th>Danh Mục</th>
                        <th>Trạng Thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articles as $art)
                        <tr>
                            <td>{{ $art->ID }}</td>
                            <td>{{ $art->ArticleName }}</td>
                            <td>{{ Str::limit($art->ArticleContent, 50) }}</td>
                            <td>{{ $art->PostTime->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($art->categories->isNotEmpty())
                                    @foreach ($art->categories as $category)
                                        {{ $category->CategoryName }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                @else
                                    Không xác định
                                @endif
                            </td>
                            <td>
                                @if ($art->Status)
                                    <span class="badge badge-success">Kích hoạt</span>
                                @else
                                    <span class="badge badge-danger">Vô hiệu hóa</span>
                                @endif
                            </td>
                            <td>
                                <!-- Nút Sửa -->
                                <a href="{{ route('article.edit', $art->ID) }}" class="edit" title="Sửa">
                                    <i class="material-icons">&#xE254;</i>
                                </a>
                                <!-- Nút Xóa -->
                                <form action="{{ route('article.destroy', $art->ID) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete" title="Xóa"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">
                                        <i class="material-icons">&#xE872;</i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Không tìm thấy bài viết nào với từ khóa
                                    "{{ $searchTerm }}".</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Phân Trang -->
                <div class="clearfix">
                    <div class="hint-text">Hiển thị <b>{{ $articles->count() }}</b> trong tổng số
                        <b>{{ $articles->total() }}</b> mục
                    </div>
                    {{ $articles->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    @endsection
