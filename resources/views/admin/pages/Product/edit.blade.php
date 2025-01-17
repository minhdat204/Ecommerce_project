@extends('Admin.Layout.Layout')

@section('title', 'Chỉnh sửa sản phẩm')

@section('namepage', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="container mt-4">
                    <!-- Hiển thị số lượng sản phẩm trong giỏ hàng -->
                                        <div class="card-header">
                                            <h3 class="text-center">Số lượng giỏ hàng đang chứa sản phẩm: <strong>{{ number_format($count) }}</strong></h3>
                                            <h3 class="text-center">Thời gian chỉnh sửa gần nhất nhất: <strong>{{$thoigian}}</strong></h3>
                                        </div>
                    <form action="{{ route('admin.product.update', $product->id_sanpham) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Tên sản phẩm -->
                        <div class="form-group">
                            <label for="tensanpham">Tên sản phẩm</label>
                            <input type="text" name="tensanpham" id="tensanpham" class="form-control"
                                   value="{{ old('tensanpham', $product->tensanpham) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="slug"></label>
                            <input type="hidden" id="slug" name="slug" value="{{ old('slug', $product->slug) }}">
                            </div>
                        <!-- Mô tả -->
                        <div class="form-group">
                            <label for="mota">Mô tả</label>
                            <textarea name="mota" id="mota" class="form-control" rows="3">{{ old('mota', $product->mota) }}</textarea>
                        </div>

                        <!-- Thông tin kỹ thuật -->
                        <div class="form-group">
                            <label for="thongtin_kythuat">Thông tin kỹ thuật</label>
                            <textarea name="thongtin_kythuat" id="thongtin_kythuat" class="form-control" rows="3">{{ old('thongtin_kythuat', $product->thongtin_kythuat) }}</textarea>
                        </div>

                        <!-- Giá -->
                        <div class="form-group">
                            <label for="gia">Giá</label>
                            <input type="number" name="gia" id="gia" class="form-control"
                                   value="{{ old('gia', $product->gia) }}" required>
                        </div>

                        <!-- Giá khuyến mãi -->
                        <div class="form-group">
                            <label for="gia_khuyen_mai">Giá khuyến mãi</label>
                            <input type="number" name="gia_khuyen_mai" id="gia_khuyen_mai" class="form-control"
                                   value="{{ old('gia_khuyen_mai', $product->gia_khuyen_mai) }}">
                        </div>

                        <!-- Đơn vị tính -->
                        <div class="form-group">
                            <label for="donvitinh">Đơn vị tính</label>
                            <input type="text" name="donvitinh" id="donvitinh" class="form-control"
                                   value="{{ old('donvitinh', $product->donvitinh) }}">
                        </div>

                        <!-- Xuất xứ -->
                        <div class="form-group">
                            <label for="xuatxu">Xuất xứ</label>
                            <input type="text" name="xuatxu" id="xuatxu" class="form-control"
                                   value="{{ old('xuatxu', $product->xuatxu) }}">
                        </div>

                        <!-- Số lượng -->
                        <div class="form-group">
                            <label for="soluong">Số lượng</label>
                            <input type="number" name="soluong" id="soluong" class="form-control"
                                   value="{{ old('soluong', $product->soluong) }}" required>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group">
                            <label for="trangthai">Trạng thái</label>
                            <select name="trangthai" id="trangthai" class="form-control">
                                <option value="active" {{ old('trangthai', $product->trangthai) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="inactive" {{ old('trangthai', $product->trangthai) == 'inactive' ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>

                        <!-- Danh mục -->
                        <div class="form-group">
                            <label for="id_danhmuc">Danh mục</label>
                            <select name="id_danhmuc" id="id_danhmuc" class="form-control">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id_danhmuc }}"
                                            {{ old('id_danhmuc', $product->id_danhmuc) == $category->id_danhmuc ? 'selected' : '' }}>
                                        {{ $category->tendanhmuc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Thêm hình ảnh mới -->
                        <div class="form-group">
                            <label for="images">Thêm hình ảnh mới</label>
                            <input type="file" name="images[]" id="images" class="form-control" multiple>
                        </div>
                        <div class="form-group text-center">
                            <!-- Nút mở Modal xác nhận -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmUpdateModal">Lưu thay đổi</button>
                            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>                
<!-- Modal Xác Nhận -->
<div id="confirmUpdateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="confirmUpdateForm" action="{{ route('admin.product.update', $product->id_sanpham) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="confirmUpdateModalLabel">Xác nhận thay đổi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn lưu thay đổi? </p>
                    <p>Việc thay đổi sẽ ảnh hưởng tới một số giỏ hàng!</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="confirmUpdateBtn">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Khi nhấn "Xác nhận" trong modal
        $('#confirmUpdateBtn').click(function() {
            // Gửi form cập nhật sản phẩm khi nhấn Xác nhận
            $('form').submit(); // Gửi form chính
        });
    });
</script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection