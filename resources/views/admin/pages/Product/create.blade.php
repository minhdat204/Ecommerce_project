@extends('Admin.Layout.Layout')

@section('content')
    <div class="container">
        <h1 class="my-4">Thêm Sản Phẩm Mới</h1>

        <form action="{{ route('admin.product.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="tensanpham" class="form-label">Tên Sản Phẩm</label>
                <input type="text" class="form-control" id="tensanpham" name="tensanpham" required>
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" required>
            </div>

            <div class="mb-3">
                <label for="mota" class="form-label">Mô Tả</label>
                <textarea class="form-control" id="mota" name="mota" required></textarea>
            </div>

            <div class="mb-3">
                <label for="thongtin_kythuat" class="form-label">Mô Tả Kỹ Thuật</label>
                <textarea class="form-control" id="thongtin_kythuat" name="thongtin_kythuat" required></textarea>
            </div>

            <div class="mb-3">
    <label for="id_danhmuc" class="form-label">Danh Mục</label>
    <select class="form-control" id="id_danhmuc" name="id_danhmuc" required>
        <option value="" disabled selected>Chọn danh mục</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id_danhmuc }}">{{ $category->ten_danhmuc }}</option>
        @endforeach
    </select>
</div>

            <div class="mb-3">
                <label for="gia" class="form-label">Giá</label>
                <input type="number" class="form-control" id="gia" name="gia" required>
            </div>

            <div class="mb-3">
                <label for="gia_khuyen_mai" class="form-label">Giá Khuyến Mãi</label>
                <input type="number" class="form-control" id="gia_khuyen_mai" name="gia_khuyen_mai">
            </div>

            <div class="mb-3">
                <label for="donvitinh" class="form-label">Đơn Vị Tính</label>
                <input type="text" class="form-control" id="donvitinh" name="donvitinh" required>
            </div>

            <div class="mb-3">
                <label for="xuatxu" class="form-label">Xuất Xứ</label>
                <input type="text" class="form-control" id="xuatxu" name="xuatxu" required>
            </div>

            <div class="mb-3">
                <label for="soluong" class="form-label">Số Lượng</label>
                <input type="number" class="form-control" id="soluong" name="soluong" required>
            </div>

            <div class="mb-3">
                <label for="trangthai" class="form-label">Trạng Thái</label>
                <select class="form-control" id="trangthai" name="trangthai" required>
                    <option value="1">Kích Hoạt</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="luotxem" class="form-label">Lượt Xem</label>
                <input type="number" class="form-control" id="luotxem" name="luotxem">
            </div>

            <button type="submit" class="btn btn-primary">Lưu Sản Phẩm</button>
        </form>
    </div>
@endsection
