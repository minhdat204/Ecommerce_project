@extends('Admin.Layout.Layout')

@section('namepage', 'Dashboard')

@section('content')
    <div class="container">
        <div class="table-wrapper">
            <!-- Tiêu đề bảng -->
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Quản lý <b>Sản Phẩm</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <!-- Nút Thêm Sản Phẩm Mới -->
                        <a href="{{ route('admin.product.create') }}" class="btn btn-success">
                            <i class="material-icons">&#xE147;</i> <span>Thêm Sản Phẩm Mới</span>
                        </a>
                        <!-- Nút Xóa Đã Chọn -->
                        <a onclick="xoanhieu()" href="javascript:void(0)" id="deleteSelected" class="btn btn-danger">
                            <i class="material-icons">&#xE15C;</i> <span>Xóa đã chọn</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Tìm Kiếm -->
<form action="{{ route('admin.product.index') }}" method="GET" class="form-inline mb-3">
    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-default">Tìm kiếm</button>
</form>
@forelse ($products as $product)
    <!-- Hiển thị sản phẩm -->
@empty
    <tr>
        <td colspan="6" class="text-center">Không tìm thấy sản phẩm phù hợp với từ khóa "{{ request('search') }}".</td>
    </tr>
@endforelse
            <!-- Bảng Sản Phẩm -->
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
                        <th>Tên Sản Phẩm</th>
                        <th>Slug</th>
                        <th>Mô tả</th>
                        <th>Thông Tin Kỹ Thuật</th>
                        <th>Giá</th>
                        <th>Giá Khuyến Mãi</th>
                        <th>Đơn Vị Tính</th>
                        <th>Xuất Xứ</th>
                        <th>Số Lượng</th>
                        <th>Trạng Thái</th>
                        <th>Lượt Xem</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox" name="options[]" value="">
                                    <label for="checkbox"></label>
                                </span>
                            </td>
                            <td>{{ $product->id_sanpham }}</td>
                            <td>{{ $product->tensanpham }}</td>
                            <td>{{ $product->slug }}</td>
                            <td>{{ $product->mota }}</td>
                            <td>{{ $product->thongtin_kythuat }}</td>
                            <td>{{ number_format($product->gia, 0, ',', '.') }} VNĐ</td>
                            <td>{{ number_format($product->gia_khuyen_mai, 0, ',', '.') }} VNĐ</td>
                            <td>{{ $product->donvitinh }}</td>
                            <td>{{ $product->xuatxu }}</td>
                            <td>{{ $product->soluong }}</td>
                            <td>
                                @if ($product->trangthai == 'active')
                                    <span class="label label-success">Kích hoạt</span>
                                @else
                                    <span class="label label-danger">Vô hiệu hóa</span>
                                @endif
                            </td>
                            <td>{{ $product->luotxem }}</td>
                            <td>
                                <a href="{{ route('admin.product.edit', $product->id_sanpham) }}" class="edit" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Sửa">&#xE254;</i>
                                </a>
                                <a href="#deleteProductModal" class="delete" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Xóa">&#xE872;</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Phân Trang -->
            <div class="clearfix">
                <div class="hint-text">Hiển thị <b>4</b> trong tổng số <b>4</b> mục</div>
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Form Xóa Đã Chọn (ẩn) -->
    <form id="deleteSelectedForm" method="POST">
        @csrf
        @method('DELETE')
    </form>

    <!-- Modal Thêm Sản Phẩm Mới -->
    <div id="addProductModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ Route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm Sản Phẩm Mới</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tên Sản Phẩm</label>
                            <input type="text" class="form-control" name="ProductName" placeholder="Nhập tên sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="Slug" placeholder="Nhập slug sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <input type="text" class="form-control" name="ProductDescription" placeholder="Nhập mô tả sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <label>Thông Tin Kỹ Thuật</label>
                            <input type="text" class="form-control" name="ProductTechnicalInfo" placeholder="Nhập thông tin kỹ thuật" required>
                        </div>
                        <div class="form-group">
                            <label>Giá</label>
                            <input type="number" class="form-control" name="ProductPrice" placeholder="Nhập giá sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <label>Giá Khuyến Mãi</label>
                            <input type="number" class="form-control" name="ProductSalePrice" placeholder="Nhập giá khuyến mãi" required>
                        </div>
                        <div class="form-group">
                            <label>Đơn Vị Tính</label>
                            <input type="text" class="form-control" name="ProductUnit" placeholder="Nhập đơn vị tính" required>
                        </div>
                        <div class="form-group">
                            <label>Xuất Xứ</label>
                            <input type="text" class="form-control" name="ProductOrigin" placeholder="Nhập xuất xứ" required>
                        </div>
                        <div class="form-group">
                            <label>Số Lượng</label>
                            <input type="number" class="form-control" name="ProductQuantity" placeholder="Nhập số lượng" required>
                        </div>
                        <div class="form-group">
                            <label>Trạng Thái</label>
                            <select class="form-control" name="Status" required>
                                <option value="1">Kích hoạt</option>
                                <option value="0">Vô hiệu hóa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <input type="file" class="form-control" name="ProductImage" accept="image/*" required>
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
