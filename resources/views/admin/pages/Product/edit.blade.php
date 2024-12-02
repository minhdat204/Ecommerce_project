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
                            <input type="text" id="slug" class="form-control" name="slug" 
                                value="{{ old('slug', $product->slug) }}" readonly>
                        </div>

                        @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const nameInput = document.getElementById('tensanpham');
                                const slugDisplay = document.getElementById('slug');

                                /**
                                * Function to generate slug from a string
                                * @param {string} str
                                * @returns {string}
                                */
                                function generateSlug(str) {
                                    return str.toLowerCase()
                                        .trim()
                                        .replace(/[^a-z0-9\s-]/g, '') // Loại bỏ ký tự đặc biệt
                                        .replace(/[\s-]+/g, '-')      // Thay thế khoảng trắng hoặc dấu gạch ngang bằng 1 dấu gạch ngang
                                        .replace(/^-+|-+$/g, '');    // Loại bỏ dấu gạch ngang ở đầu hoặc cuối
                                }

                                // Cập nhật slug khi nhập tên sản phẩm
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
                            <input type="number" name="gia" id="gia" class="form-control @error('gia') is-invalid @enderror" 
                                   value="{{ old('gia', $product->gia) }}" required>
                        </div>

                        <!-- Giá khuyến mãi -->
                        <div class="form-group">
                            <label for="gia_khuyen_mai">Giá khuyến mãi</label>
                            <input type="number" name="gia_khuyen_mai" id="gia_khuyen_mai" class="form-control @error('gia_khuyen_mai') is-invalid @enderror" 
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
                        <div class="form-group">
                        <label>Hình ảnh hiện tại</label>
                        <div>
                            @foreach ($product->images as $image)
                                <div class="position-relative me-3 mb-3">
                                    <img src="{{ asset('storage/' . $image->duongdan) }}" alt="{{ $image->alt }}" class="img-thumbnail" width="150">
                                    
                                    <!-- Hình chữ X để xóa hình ảnh -->
                                    <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px;" onclick="confirmDelete({{ $image->id }})">
                                        X
                                    </button>

                                    <!-- Ẩn checkbox, chỉ sử dụng cho việc gửi dữ liệu -->
                                </div>
                            @endforeach
                        </div>

                        <script>
                            // Hàm xác nhận và xóa hình ảnh
                            function confirmDelete(imageId) {
                                if (confirm('Bạn có chắc muốn xóa hình ảnh này?')) {
                                    // Tìm checkbox và đánh dấu xóa
                                    const checkbox = document.querySelector(`input[value="${imageId}"]`);
                                    checkbox.checked = true;

                                    // Xóa hình ảnh trong giao diện
                                    const imageItem = checkbox.closest('.position-relative');
                                    imageItem.remove();
                                }
                            }
                        </script>
                            </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Thêm hình ảnh mới</label>
                            <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                        </div>

                        <!-- Preview hình ảnh -->
                        <div id="preview-container" class="d-flex flex-wrap mt-3"></div>

                        <script>
                            // Xử lý hiển thị hình ảnh xem trước
                            document.getElementById('images').addEventListener('change', function (event) {
                                const files = event.target.files;
                                const previewContainer = document.getElementById('preview-container');

                                // Xóa hình ảnh xem trước hiện tại
                                previewContainer.innerHTML = '';

                                // Duyệt qua danh sách file được chọn
                                Array.from(files).forEach((file, index) => {
                                    if (file.type.startsWith('image/')) {
                                        const reader = new FileReader();

                                        // Đọc file và hiển thị hình ảnh
                                        reader.onload = function (e) {
                                            const div = document.createElement('div');
                                            div.className = 'image-item position-relative me-3 mb-3';
                                            div.style.width = '100px';
                                            div.style.height = '100px';

                                            div.innerHTML = `
                                                <img src="${e.target.result}" alt="Hình ảnh xem trước" class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px;" data-index="${index}">
                                                    X
                                                </button>
                                            `;

                                            previewContainer.appendChild(div);
                                        };

                                        reader.readAsDataURL(file);
                                    }
                                });

                                // Gán sự kiện xóa hình ảnh
                                setTimeout(() => attachDeleteHandlers(files), 100);
                            });

                            function attachDeleteHandlers(files) {
                                document.querySelectorAll('#preview-container button').forEach((btn) => {
                                    btn.addEventListener('click', function () {
                                        const index = parseInt(this.getAttribute('data-index'));
                                        const dt = new DataTransfer();

                                        // Lấy các file trừ file bị xóa
                                        Array.from(files).forEach((file, i) => {
                                            if (i !== index) {
                                                dt.items.add(file);
                                            }
                                        });

                                        // Cập nhật lại các file trong input
                                        document.getElementById('images').files = dt.files;

                                        // Xóa hình ảnh xem trước
                                        this.closest('.image-item').remove();
                                    });
                                });
                            }
                        </script>

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
