@extends('Admin.Layout.Layout')
@section('namepage', 'Dashboard')

@section('content')
    <div class="container">
        <div class="table-wrapper">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tiêu đề bảng -->
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Quản lý <b>Danh Mục</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <!-- Nút Thêm Danh Mục Mới -->
                        <a href="#addCategoryModal" class="btn btn-success" data-toggle="modal">
                            <i class="material-icons">&#xE147;</i> <span>Thêm Danh Mục Mới</span>
                        </a>
                        <!-- Nút Xóa Đã Chọn -->
                        <a onclick="xoanhieu()" href="javascript:void(0)" id="deleteSelected" class="btn btn-danger">
                            <i class="material-icons">&#xE15C;</i> <span>Xóa đã chọn</span>
                        </a>

                    </div>
                </div>
            </div>

            <!-- Form Tìm Kiếm -->
            <form method="GET" action="{{ route('admin.category.index') }}" class="form-inline mb-3">
                <div class="form-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm danh mục..."
                        value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
            </form>

            <!-- Hiển thị kết quả tìm kiếm -->
            @if (request('search'))
                <div class="alert alert-info">
                    Kết quả tìm kiếm cho: <strong>{{ request('search') }}</strong>
                    <span class="ml-2">({{ $categories->count() }} kết quả)</span>
                </div>
            @endif
            <!-- Bảng Danh Mục -->
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="selectAll">
                                <label for="selectAll"></label>
                            </span>
                        </th>
                        <th>ID</th>
                        <th>Danh mục cha</th>
                        <th>Tên Danh Mục</th>
                        <th>Slug</th>
                        <th>Mô tả</th>
                        <th>Hình</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox" name="options[]" value="">
                                    <label for="checkbox"></label>
                                </span>

                            </td>
                            <td>
                                {{ $category->id_danhmuc }}
                            </td>
                            <td>
                                {{ $category->parentCategory ? $category->parentCategory->tendanhmuc : 'Không có' }}

                            </td>
                            <td>
                                {{ $category->tendanhmuc }}

                            </td>
                            <td>
                                {{ $category->slug }}

                            </td>
                            <td>
                                {{ $category->mota }}

                            </td>
                            <td>
                                @if ($category->thumbnail)
                                    <img src="{{ asset('storage/' . $category->thumbnail) }}"
                                        alt="{{ $category->tendanhmuc }}" width="100">
                                @else
                                    <span>No image</span>
                                @endif
                            </td>


                            <td>

                                @if ($category->trangthai == 'active')
                                    <span class="label label-success">Kích hoạt</span>
                                @else
                                    <span class="label label-danger">Vô hiệu hóa</span>
                                @endif


                            </td>
                            <td>
                                <a href="#editCategoryModal{{ $category->id_danhmuc }}" class="edit" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Sửa">&#xE254;</i>
                                </a>
                                <a href="#" class="delete" data-toggle="modal"
                                    data-target="#deleteCategoryModal{{ $category->id_danhmuc }}">
                                    <i class="material-icons" data-toggle="tooltip" title="Xóa">&#xE872;</i>

                                </a>

                            </td>
                        </tr>

                        <!-- Modal Sửa Danh Mục -->
                        <div id="editCategoryModal{{ $category->id_danhmuc }}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Sửa Danh Mục</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <form action="{{ route('admin.category.update', $category->id_danhmuc) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="CategoryParent">Danh mục cha</label>
                                                <select name="CategoryParent" id="CategoryParent" class="form-control">
                                                    <option value="">-- Không chọn danh mục cha --</option>
                                                    @foreach ($parentCategories as $parent)
                                                        <option value="{{ $parent->id_danhmuc }}"
                                                            {{ $parent->id_danhmuc == $category->id_danhmuc_cha ? 'selected' : '' }}>
                                                            {{ $parent->tendanhmuc }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label>Tên Danh Mục</label>
                                                <input type="text" class="form-control" name="CategoryName"
                                                    value="{{ old('CategoryName', $category->tendanhmuc) }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Mô tả</label>
                                                <input type="text" class="form-control" name="CategoryContent"
                                                    value="{{ old('CategoryContent', $category->mota) }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Trạng thái</label>
                                                <select class="form-control" name="Status" required>
                                                    <option value="active"
                                                        {{ old('Status', $category->trangthai) == 'active' ? 'selected' : '' }}>
                                                        Kích hoạt
                                                    </option>
                                                    <option value="inactive"
                                                        {{ old('Status', $category->trangthai) == 'inactive' ? 'selected' : '' }}>
                                                        Vô hiệu hóa
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Hình ảnh</label>
                                                <input type="file" class="form-control" name="CategoryImage"
                                                    accept="image/*">
                                                @if ($category->thumbnail)
                                                    <div class="mt-2">
                                                        <img src="{{ asset('storage/' . $category->thumbnail) }}"
                                                            class="img-thumbnail" width="100" alt="Ảnh hiện tại">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- Modal Xóa Danh Mục -->
                        <div id="deleteCategoryModal{{ $category->id_danhmuc }}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.category.destroy', $category->id_danhmuc) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h4 class="modal-title">Xóa Danh Mục</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa danh mục
                                                <strong>{{ $category->tendanhmuc }}</strong>?
                                            </p>
                                            <p class="text-warning"><small>Hành động này không thể hoàn tác.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Hủy</button>
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
                <div class="hint-text">
                    Hiển thị <b>{{ $categories->count() }}</b> trong tổng số <b>{{ $categories->total() }}</b> mục
                </div>
                {{ $categories->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <!-- Form Xóa Đã Chọn (ẩn) -->
    <form id="deleteSelectedForm" method="POST">
        @csrf
        @method('DELETE')
    </form>


    <!-- Modal Thêm Danh Mục Mới -->
    <div id="addCategoryModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ Route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm Danh Mục Mới</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Danh mục cha</label>
                            <select id="CategoryParent" class="form-control" name="CategoryParent">
                                <option value="">-- Chọn danh mục cha --</option>
                                @foreach ($parentCategories as $parent)
                                    <option value="{{ $parent->id_danhmuc }}">{{ $parent->tendanhmuc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tên Danh Mục</label>
                            <input type="text" class="form-control" name="CategoryName"
                                placeholder="Nhập tên danh mục" required>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <input type="text" class="form-control" name="CategoryContent" placeholder="Nhập mô tả"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" class="form-control" name="CategoryImage" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" name="TrangThai" required>
                                <option value="active">Kích hoạt</option>
                                <option value="inactive">Vô hiệu hóa</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Hủy">
                        <input type="submit" class="btn btn-success" value="Thêm">
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Kích hoạt tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Chọn/Bỏ chọn tất cả checkbox
            var checkbox = $('table tbody input[type="checkbox"]');
            $("#selectAll").click(function() {
                checkbox.prop('checked', this.checked);
            });

            checkbox.click(function() {
                if (!this.checked) {
                    $("#selectAll").prop("checked", false);
                }
            });

            // Tự động ẩn thông báo sau 3 giây
            $('.alert').delay(3000).fadeOut(500);
        });

        function deleteCategory(id) {
            if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
                $.ajax({
                    url: '/admin/category/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Cập nhật giao diện
                            $('#category-' + id).fadeOut();
                            // Hoặc reload trang
                            // window.location.reload();

                            // Hiển thị thông báo
                            alert(response.message);
                        } else {
                            alert('Có lỗi xảy ra: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Đã xảy ra lỗi!');
                    }
                });
            }
        }
    </script>
@endpush
