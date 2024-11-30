@extends('Admin.Layout.Layout')

@section('content')
            <h1 class="my-4">Thêm Sản Phẩm Mới</h1>

            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Các trường thông tin sản phẩm -->
                <div class="mb-3">
                    <label for="tensanpham" class="form-label">Tên Sản Phẩm</label>
                    <input type="text" class="form-control @error('tensanpham') is-invalid @enderror" id="tensanpham" name="tensanpham" value="{{ old('tensanpham') }}" required>
                    @error('tensanpham')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="hidden" id="slug" name="slug">
                </div>

                <script>
                // Danh sách các slug đã có (có thể lấy từ database hoặc dữ liệu động)
                var existingSlugs = [
                    'rau-cai-ngot-organic',
                    'rau-cai-ngot-organic-1',
                    // Thêm các slug khác vào danh sách nếu cần
                ];

                // Chuyển tên sản phẩm thành slug tự động
                document.getElementById('tensanpham').addEventListener('input', function () {
                    let slug = this.value
                        .toLowerCase()
                        .trim()
                        .normalize('NFD') // Chuẩn hóa Unicode
                        .replace(/[\u0300-\u036f]/g, '') // Loại bỏ dấu
                        .replace(/đ/g, 'd') // Thay "đ" thành "d"
                        .replace(/[^a-z0-9\s-]/g, '') // Loại bỏ ký tự đặc biệt
                        .replace(/\s+/g, '-') // Thay khoảng trắng bằng dấu "-"
                        .replace(/-+/g, '-'); // Loại bỏ dấu "-" liên tiếp

                    // Kiểm tra slug có bị trùng không
                    let originalSlug = slug;
                    let count = 1;
                    while (existingSlugs.includes(slug)) {
                        slug = originalSlug + '-' + count;
                        count++;
                    }

                    // Gán giá trị slug vào input ẩn
                    document.getElementById('slug').value = slug;

                    // Thêm slug vào danh sách các slug đã có
                    existingSlugs.push(slug);
                });
                </script>



            <div class="mb-3">
                <label for="mota" class="form-label">Mô Tả</label>
                <textarea class="form-control @error('mota') is-invalid @enderror" id="mota" name="mota" required>{{ old('mota') }}</textarea>
                @error('mota')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="thongtin_kythuat" class="form-label">Mô Tả Kỹ Thuật</label>
                <textarea class="form-control @error('thongtin_kythuat') is-invalid @enderror" id="thongtin_kythuat" name="thongtin_kythuat" required>{{ old('thongtin_kythuat') }}</textarea>
                @error('thongtin_kythuat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Chọn danh mục -->
            <div class="mb-3">
                <label for="id_danhmuc" class="form-label">Danh Mục</label>
                <select class="form-control" id="id_danhmuc" name="id_danhmuc" required>
                    <option value="" disabled selected>Chọn danh mục</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->tendanhmuc }}">{{ $category->tendanhmuc }}</option>
                    @endforeach
                </select>
            </div>


            <!-- Các trường thông tin khác -->
            <div class="mb-3">
                <label for="gia" class="form-label">Giá</label>
                <input type="number" class="form-control @error('gia') is-invalid @enderror" 
                    id="gia" name="gia" value="{{ old('gia') }}" required min="0">
                @error('gia')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <script>
                document.getElementById('gia').addEventListener('input', function () {
                    if (this.value < 0) {
                        this.value = 0; 
                    }
                });
                 // Lắng nghe sự kiện khi người dùng thay đổi giá
                document.getElementById('gia').addEventListener('input', function () {
                    validatePrice();
                });

                // Lắng nghe sự kiện khi người dùng thay đổi giá khuyến mãi
                document.getElementById('gia_khuyen_mai').addEventListener('input', function () {
                    validatePrice();
                });

                // Hàm kiểm tra giá
                function validatePrice() {
                    var gia = parseFloat(document.getElementById('gia').value);
                    var giaKhuyenMai = parseFloat(document.getElementById('gia_khuyen_mai').value);

                    // Kiểm tra nếu giá nhỏ hơn giá khuyến mãi
                    if (gia <= giaKhuyenMai) {
                        // Hiển thị lỗi nếu giá không hợp lệ
                        alert('Giá phải lớn hơn giá khuyến mãi!');
                        document.getElementById('gia').setCustomValidity('Giá phải lớn hơn giá khuyến mãi!');
                    } else {
                        // Không có lỗi nếu giá hợp lệ
                        document.getElementById('gia').setCustomValidity('');
                    }
                }
            </script>

            <div class="mb-3">
                <label for="gia_khuyen_mai" class="form-label">Giá Khuyến Mãi</label>
                <input type="number" class="form-control @error('gia_khuyen_mai') is-invalid @enderror" id="gia_khuyen_mai" name="gia_khuyen_mai" value="{{ old('gia_khuyen_mai') }} "required min="0">
                @error('gia_khuyen_mai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <script>
                document.getElementById('gia_khuyen_mai').addEventListener('input', function () {
                    if (this.value < 0) {
                        this.value = 0; 
                    }
                });
            </script>

            <div class="mb-3">
                <label for="donvitinh" class="form-label">Đơn Vị Tính</label>
                <input type="text" class="form-control @error('donvitinh') is-invalid @enderror" id="donvitinh" name="donvitinh" value="{{ old('donvitinh') }}" required>
                @error('donvitinh')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <script>
                document.getElementById('donvitinh').addEventListener('input', function () {
                    if (this.value < 0) {
                        this.value = 0; 
                    }
                });
            </script>

            <div class="mb-3">
                <label for="xuatxu" class="form-label">Xuất Xứ</label>
                <input type="text" class="form-control @error('xuatxu') is-invalid @enderror" id="xuatxu" name="xuatxu" value="{{ old('xuatxu') }}" required>
                @error('xuatxu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="soluong" class="form-label">Số Lượng</label>
                <input type="number" class="form-control @error('soluong') is-invalid @enderror" id="soluong" name="soluong" value="{{ old('soluong') }}" required min="0">
                @error('soluong')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <script>
                document.getElementById('soluong').addEventListener('input', function () {
                    if (this.value < 0) {
                        this.value = 0;
                    }
                });
            </script>

            <div class="mb-3">
                <label for="trangthai" class="form-label">Trạng Thái</label>
                <select class="form-control @error('trangthai') is-invalid @enderror" id="trangthai" name="trangthai" required>
                    <option value="active" {{ old('trangthai') === 'active' ? 'selected' : '' }}>Hoạt động</option>
    <option value="inactive" {{ old('trangthai') === 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
                @error('trangthai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Hình Ảnh</label>
                <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple>
                @error('images')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Lưu Sản Phẩm</button>
        </form>
    </div>
@endsection

