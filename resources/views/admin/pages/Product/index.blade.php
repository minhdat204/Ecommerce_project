@extends('Admin.Layout.Layout')

@section('namepage', 'Dashboard')

@section('content')
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Quản lý <b>Sản Phẩm</b></h2>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('admin.product.create') }}" class="btn btn-success">
                        <i class="material-icons">&#xE147;</i> <span>Thêm Sản Phẩm Mới</span>
                    </a>
                    <a onclick="xoanhieu()" href="javascript:void(0)" id="deleteSelected" class="btn btn-danger">
                            <i class="material-icons">&#xE15C;</i> <span>Xóa đã chọn</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Tìm Kiếm -->
        <form action="{{ route('admin.product.index') }}" method="GET" class="form-inline mb-3">
            <div class="form-group mr-2">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm tên sản phẩm..." value="{{ request('search') }}">
            </div>
            <div class="form-group mr-2">
                <input type="number" name="min_price" class="form-control" placeholder="Giá từ..." value="{{ request('min_price') }}">
            </div>
            <div class="form-group mr-2">
                <input type="number" name="max_price" class="form-control" placeholder="Giá đến..." value="{{ request('max_price') }}">
            </div>
            <div class="form-group mr-2">
                <select name="xuatxu" class="form-control">
                    <option value="">Chọn xuất xứ</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country }}" {{ request('xuatxu') == $country ? 'selected' : '' }}>
                            {{ $country }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mr-2">
                <select name="id_danhmuc" class="form-control">
                    <option value="">Chọn loại sản phẩm</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id_danhmuc }}" {{ request('id_danhmuc') == $category->id_danhmuc ? 'selected' : '' }}>
                            {{ $category->tendanhmuc }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>


        <!-- Bảng Sản Phẩm -->
        <div class="table-responsive">
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
                        <th>Hình Ảnh</th>
                        <th>Danh Mục</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox{{ $product->id_sanpham }}" name="options[]" value="{{ $product->id_sanpham }}">
                                    <label for="checkbox{{ $product->id_sanpham }}"></label>
                                </span>
                            </td>
                            <td>{{ $product->id_sanpham }}</td>
                            <td>
                                <!-- Chuyển tới trang chi tiết khi nhấn vào tên sản phẩm -->
                                <a href="{{ route('admin.product.show', $product->id_sanpham) }}" title="{{ $product->tensanpham }}">
                                    {{ Str::limit($product->tensanpham, 30) }}
                                </a>
                            </td>
                            <td>{{ $product->slug }}</td>
                            <td title="{{ $product->mota }}">{{ Str::limit($product->mota, 50) }}</td>
                            <td title="{{ $product->thongtin_kythuat }}">{{ Str::limit($product->thongtin_kythuat, 50) }}</td>
                            <td>{{ number_format($product->gia, 0, ',', '.') }} VNĐ</td>
                            <td>{{ number_format($product->gia_khuyen_mai, 0, ',', '.') }} VNĐ</td>
                            <td>{{ $product->donvitinh }}</td>
                            <td>{{ $product->xuatxu }}</td>
                            <td>{{ $product->soluong }}</td>
                            <td>
                                @if ($product->trangthai == 'active')
                                    <span class="label label-success">Hoạt Động</span>
                                @else
                                    <span class="label label-danger">Không Hoạt Động</span>
                                @endif
                            </td>
                            <td>{{ $product->luotxem }}</td>
                            <td>
                                @foreach($product->images as $productImage)
                                    <img src="{{ asset('storage/' . $productImage->duongdan) }}" alt="{{ $productImage->alt }}" width="100">
                                @endforeach
                            </td>
                            <td>{{ $product->category ? $product->category->tendanhmuc : 'Chưa có danh mục' }}</td>
                            <td>
                                <a href="{{ route('admin.product.edit', $product->id_sanpham) }}" class="edit" data-toggle="tooltip" title="Sửa">
                                    <i class="material-icons">&#xE254;</i>
                                </a>
                                <!-- Nút ẩn sản phẩm -->
                                <a href="#" class="delete" data-toggle="modal"
                                data-target="#deleteProductModal{{ $product->id_sanpham }}">
                                <i class="material-icons" data-toggle="tooltip" title="Xóa">&#xE872;</i>
                            </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Phân Trang -->
        <div class="clearfix">
            <div class="hint-text">
                Hiển thị <b>{{ $products->count() }}</b> trong tổng số <b>{{ $products->total() }}</b> sản phẩm
            </div>
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
        <!-- Form Xóa Đã Chọn (ẩn) -->
    <form id="deleteSelectedForm" method="POST">
        @csrf
        @method('DELETE')
    </form>
<div id="deleteProductModal{{ $product->id_sanpham }}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.product.destroy', $product->id_sanpham) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h4 class="modal-title">Xóa Sản Phẩm</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa sản phẩm 
                        <strong>{{ $product->ten_sanpham }}</strong>?
                    </p>
                    <p class="text-warning"><small>Hành động này không thể hoàn tác.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
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

            // Hàm xóa nhiều sản phẩm
            $('#deleteSelected').click(function() {
                var selectedIds = [];
                $('table tbody input[type="checkbox"]:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) {
                    alert("Vui lòng chọn ít nhất một sản phẩm để xóa.");
                    return;
                }

                if (confirm('Bạn có chắc chắn muốn xóa các sản phẩm đã chọn?')) {
                    $.ajax({
                        url: '{{ route("admin.product.destroy", "bulk") }}',
                        type: 'DELETE',
                        data: {
                            ids: selectedIds,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Xóa các hàng tương ứng trong bảng
                                selectedIds.forEach(function(id) {
                                    $('#product-' + id).fadeOut();
                                });

                                // Hiển thị thông báo thành công
                                alert(response.message);
                                // Hoặc reload trang
                                // window.location.reload();
                            } else {
                                alert('Có lỗi xảy ra: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('Đã xảy ra lỗi!');
                        }
                    });
                }
            });
        });
    </script>
@endpush

