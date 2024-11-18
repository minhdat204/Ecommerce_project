@extends('Admin.Layout.Layout')
@section('namepage', 'Dashboard')

@section('content')
    <div class="container">
        <div class="table-wrapper">
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
            <form method="GET" action="" class="form-inline mb-3">
                <div class="form-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm danh mục..."
                        value=" ">
                </div>
                <button type="submit" class="btn btn-default">Tìm kiếm</button>
            </form>

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
                        <th>Tên Danh Mục</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="checkbox" name="options[]" value="">
                                <label for="checkbox"></label>
                            </span>

                        </td>
                        <td></td>
                        <td></td>
                        <td>
                            <span class="label label-success">Kích hoạt</span>

                            <span class="label label-danger">Vô hiệu hóa</span>

                        </td>
                        <td>
                            <a href="#editCategoryModal" class="edit" data-toggle="modal">
                                <i class="material-icons" data-toggle="tooltip" title="Sửa">&#xE254;</i>
                            </a>
                            <a href="#deleteCategoryModal" class="delete" data-toggle="modal">
                                <i class="material-icons" data-toggle="tooltip" title="Xóa">&#xE872;</i>
                            </a>
                        </td>
                    </tr>

                    <!-- Modal Sửa Danh Mục -->
                    <div id="editCategoryModal " class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h4 class="modal-title">Sửa Danh Mục</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Tên Danh Mục</label>
                                            <input type="text" class="form-control" name="CategoryName" value=""
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select class="form-control" name="Status" required>
                                                <option value="1">Kích
                                                    hoạt
                                                </option>
                                                <option value="0">Vô
                                                    hiệu hóa
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Hủy">
                                        <input type="submit" class="btn btn-info" value="Lưu">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Xóa Danh Mục -->
                    <div id="deleteCategoryModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h4 class="modal-title">Xóa Danh Mục</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Bạn có chắc chắn muốn xóa danh mục này?</p>
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

            <!-- Phân Trang -->
            <div class="clearfix">
                <div class="hint-text">Hiển thị <b>4</b> trong tổng số
                    <b>4</b> mục
                </div>
                5
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
                <form action="" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm Danh Mục Mới</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tên Danh Mục</label>
                            <input type="text" class="form-control" name="CategoryName"
                                placeholder="Nhập tên danh mục" required>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" name="Status" required>
                                <option value="1">Kích hoạt</option>
                                <option value="0">Vô hiệu hóa</option>
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
        });
    </script>
@endpush
