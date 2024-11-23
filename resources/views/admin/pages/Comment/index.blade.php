@extends('Admin.Layout.Layout')
@section('namepage', 'Quản lý Bình Luận')
@push('scripts')
    <script src="{{ asset('js/delete_comment.js') }}"></script>
@endpush
@section('content')
    <div class="container">
        <div class="table-wrapper">
            @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Hiển thị thông báo lỗi -->
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
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
                            <a href="#deleteCommentModal" class="delete" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Xóa">&#xE872;</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                     <!-- Modal Xóa bình luận -->
                     <div id="deleteCommentModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <form id="deleteCommentForm" action="" method="POST">
                                    @csrf
                                    @method('DELETE') <!-- Phương thức DELETE -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Xóa bình luận</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Bạn có chắc chắn muốn xóa bình luận này?</p>
                                        <p class="text-warning"><small>Hành động này không thể hoàn tác.</small></p>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Hủy">
                                        <input type="submit" class="btn btn-danger" value="Xóa">
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="clearfix">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
@endsection
