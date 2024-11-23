@extends('Admin.Layout.Layout')
@section('namepage', 'Quản lý Bình Luận')

@section('content')
    <div class="container">
        <div class="table-wrapper">
            <!-- Tiêu đề bảng -->
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Quản lý <b>Bình Luận</b></h2>
                    </div>
                </div>
            </div>

            <!-- Bảng danh sách bình luận -->
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Nội dung</th>
                        <th>Đánh giá</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comments as $comment)
                        <tr>
                            <td>{{ $comment->id_binhluan }}</td>
                            <td>{{ $comment->product->tensanpham ?? 'Không xác định' }}</td>
                            <td>{{ $comment->noidung }}</td>
                            <td>{{ $comment->danhgia }}</td>
                            <td>
                            <a href="#deleteCategoryModal" class="delete" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Xóa">&#xE872;</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="clearfix">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
@endsection
