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
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-default">Tìm kiếm</button>
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
                            <td title="{{ $product->tensanpham }}">{{ Str::limit($product->tensanpham, 30) }}</td>
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
                                    <span class="label label-success">Kích hoạt</span>
                                @else
                                    <span class="label label-danger">Vô hiệu hóa</span>
                                @endif
                            </td>
                            <td>{{ $product->luotxem }}</td>
                            <td>
                                @foreach($product->images as $productImage)
                                    <img src="{{ asset('storage/' . $productImage->duongdan) }}" alt="{{ $productImage->alt }}" width="50">
                                @endforeach
                            </td>
                            <td>{{ $product->category ? $product->category->tendanhmuc : 'Chưa có danh mục' }}</td>
                            <td>
                                <a href="{{ route('admin.product.edit', $product->id_sanpham) }}" class="edit" data-toggle="tooltip" title="Sửa">
                                    <i class="material-icons">&#xE254;</i>
                                </a>
                                <a href="#deleteProductModal" class="delete" data-toggle="modal" title="Xóa">
                                    <i class="material-icons">&#xE872;</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Phân Trang -->
        <div class="clearfix">
            <div class="hint-text">Hiển thị <b>{{ $products->count() }}</b> trong tổng số <b>{{ $products->total() }}</b> sản phẩm</div>
            {{ $products->links() }}
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
