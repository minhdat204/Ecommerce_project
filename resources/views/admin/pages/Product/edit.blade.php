@extends('Admin.Layout.Layout')

@section('namepage', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Chỉnh sửa sản phẩm</h4>
                </div>
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

                    <form action="{{ route('admin.product.update', $product->id_sanpham) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Tên sản phẩm -->
                        <div class="form-group">
                            <label for="tensanpham">Tên sản phẩm</label>
                            <input type="text" name="tensanpham" id="tensanpham" class="form-control" 
                                   value="{{ old('tensanpham', $product->tensanpham) }}" required>
                        </div>

                        <!-- Slug (ẩn hoặc chỉ hiển thị read-only) -->
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" id="slug" class="form-control" 
                                value="{{ Str::slug(old('tensanpham', $product->tensanpham)) }}" readonly>
                        </div>
                        @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const nameInput = document.getElementById('tensanpham');
                                const slugDisplay = document.getElementById('slug');

                                function generateSlug(str) {
                                    return str.toLowerCase()
                                        .trim()
                                        .replace(/[^a-z0-9\s-]/g, '')
                                        .replace(/[\s-]+/g, '-')
                                        .replace(/^-+|-+$/g, '');
                                }

                                nameInput.addEventListener('input', function () {
                                    slugDisplay.value = generateSlug(nameInput.value);
                                });
                            });
                        </script>
                        @endpush

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
                                   value="{{ old('gia', $product->gia) }}" required min="0">
                        </div>
                        <script>
                            document.getElementById('gia').addEventListener('input', function () {
                                if (this.value < 0) {
                                    this.value = 0; // Tự động chuyển về 0 nếu nhập giá trị âm
                                }
                            });
                        </script>

                        <!-- Giá khuyến mãi -->
                        <div class="form-group">
                            <label for="gia_khuyen_mai">Giá khuyến mãi</label>
                            <input type="number" name="gia_khuyen_mai" id="gia_khuyen_mai" class="form-control" 
                                   value="{{ old('gia_khuyen_mai', $product->gia_khuyen_mai) }}" required min="0">
                        </div>
                        <script>
                            document.getElementById('gia_khuyen_mai').addEventListener('input', function () {
                                if (this.value < 0) {
                                    this.value = 0; // Tự động chuyển về 0 nếu nhập giá trị âm
                                }
                            });
                        </script>

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
                                   value="{{ old('soluong', $product->soluong) }}" required min="0">
                        </div>
                        <script>
                            document.getElementById('soluong').addEventListener('input', function () {
                                if (this.value < 0) {
                                    this.value = 0; // Tự động chuyển về 0 nếu nhập giá trị âm
                                }
                            });
                        </script>

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

                        <!-- Hình ảnh hiện tại -->
                        <div class="form-group">
                            <label>Hình ảnh hiện tại</label>
                            <div>
                                @foreach ($product->images as $image)
                                    <img src="{{ asset('storage/' . $image->duongdan) }}" alt="{{ $image->alt }}" class="img-thumbnail" width="150">
                                @endforeach
                            </div>
                        </div>

                        <!-- Thêm hình ảnh mới -->
                        <div class="form-group">
                            <label for="images">Thêm hình ảnh mới</label>
                            <input type="file" name="images[]" id="images" class="form-control" multiple>
                        </div>

                        <!-- Nút hành động -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

