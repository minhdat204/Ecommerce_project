@extends('Admin.Layout.Layout')
@section('content')
    <div >
        <div class="table-wrapper">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Quản lý <b>Bình Luận</b></h2>
                    </div>
                </div>
            </div>

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
                                <!-- Nút Xóa -->
                                <a href="#" class="delete" data-toggle="modal" data-target="#deleteCommentModal{{ $comment->id_binhluan }}">
                                <i class="material-icons" data-toggle="tooltip" title="Xóa">&#xE872;</i>
                            </a>
                        </td>
                    </tr>

                    <!-- Modal Xóa Bình Luận -->
                    <div id="deleteCommentModal{{ $comment->id_binhluan }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form id="deleteCommentForm{{ $comment->id_binhluan }}" action="{{ route('admin.comment.destroy', $comment->id_binhluan) }}" method="POST">
                                    @csrf
                                    @method('DELETE') <!-- Phương thức DELETE -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteCommentModalLabel">Xóa bình luận</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Bạn có chắc chắn muốn xóa bình luận này?</p>
                                        <p class="text-warning"><small>Hành động này không thể hoàn tác.</small></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
