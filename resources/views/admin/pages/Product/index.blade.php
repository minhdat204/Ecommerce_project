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

                    </div>
                </div>
            </div>

            <!-- Form Tìm Kiếm -->
            <form action="{{ route('admin.product.index') }}" method="GET" class="form-inline mb-3">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..."
                    value="{{ request('search') }}">
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
                            {{-- <th>Slug</th>
                        <th>Mô tả</th>
                        <th>Thông Tin Kỹ Thuật</th> --}}
                            <th>Giá</th>
                            <th>Giá Khuyến Mãi</th>
                            <th>Đơn Vị Tính</th>
                            <th>Xuất Xứ</th>
                            <th>Số Lượng</th>
                            <th>Trạng Thái</th>
                            <th>Lượt Xem</th>
                            {{-- <th>Hình Ảnh</th> --}}
                            <th>Danh Mục</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="checkbox{{ $product->id_sanpham }}" name="options[]"
                                            value="{{ $product->id_sanpham }}">
                                        <label for="checkbox{{ $product->id_sanpham }}"></label>
                                    </span>
                                </td>
                                <td>{{ $product->id_sanpham }}</td>
                                <td>
                                    <!-- Chuyển tới trang chi tiết khi nhấn vào tên sản phẩm -->
                                    <a href="{{ route('admin.product.show', $product->id_sanpham) }}"
                                        title="{{ $product->tensanpham }}">
                                        {{ Str::limit($product->tensanpham, 30) }}
                                    </a>
                                </td>
                                {{-- <td>{{ $product->slug }}</td>
                                <td title="{{ $product->mota }}">{{ Str::limit($product->mota, 50) }}</td>
                                <td title="{{ $product->thongtin_kythuat }}">
                                    {{ Str::limit($product->thongtin_kythuat, 50) }}</td> --}}
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
                                {{-- <td>
                                    @foreach ($product->images as $productImage)
                                        <img src="{{ asset('storage/' . $productImage->duongdan) }}"
                                            alt="{{ $productImage->alt }}" width="100">
                                    @endforeach
                                </td> --}}
                                <td>{{ $product->category ? $product->category->tendanhmuc : 'Chưa có danh mục' }}</td>
                                <td>
                                    <a href="{{ route('admin.product.edit', $product->id_sanpham) }}" class="edit"
                                        data-toggle="tooltip" title="Sửa">
                                        <i class="material-icons">&#xE254;</i>
                                    </a>
                                    <!-- Nút ẩn sản phẩm -->
                                    <form action="{{ route('admin.product.destroy', $product->id_sanpham) }}"
                                        method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn ẩn sản phẩm này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Ẩn sản phẩm">
                                            <i class="material-icons">&#xE872;</i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Phân Trang -->
            <div class="clearfix">
                <div class="hint-text">Hiển thị <b>{{ $products->count() }}</b> trong tổng số
                    <b>{{ $products->total() }}</b> sản phẩm
                </div>
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <!-- Form ẩn -->
    <form action="{{ route('admin.product.destroy', ':product') }}" method="POST" id="deleteProductForm">
        @csrf
        @method('PATCH') <!-- Sử dụng PATCH thay vì POST -->
        <input type="hidden" name="product_id" id="product_id">
    </form>


    <!-- Modal Ẩn Sản Phẩm -->
    <div id="deleteProductModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Xác nhận ẩn sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn ẩn sản phẩm này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" onclick="submitDeleteForm()">Ẩn</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Xác nhận xóa các sản phẩm đã chọn
        function confirmDeleteSelected() {
            var selectedIds = [];
            // Thu thập các ID sản phẩm đã chọn
            $('table tbody input[type="checkbox"]:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm để xóa!');
                return;
            }

            // Hiển thị hộp thoại xác nhận
            if (confirm('Bạn có chắc chắn muốn xóa các sản phẩm đã chọn?')) {
                // Gán giá trị danh sách ID vào form và gửi
                $('#deleteSelectedForm').submit();
            }
        }

        // Đặt ID cho sản phẩm để ẩn
        function setProductId(element) {
            var productId = $(element).data('id');
            var formAction = '{{ route('admin.product.destroy', ':product') }}';
            formAction = formAction.replace(':product', productId);
            $('#deleteProductForm').attr('action', formAction);
            $('#product_id').val(productId);
        }


        // Gửi form xác nhận ẩn sản phẩm
        function submitDeleteForm() {
            // Kiểm tra action của form
            var action = $('#deleteProductForm').attr('action');
            if (action) {
                $('#deleteProductForm').submit();
            } else {
                alert('Lỗi: Không có hành động cho form!');
            }
        }
    </script>
@endpush
