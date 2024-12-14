@extends('Admin.Layout.Layout')
@section('namepage', 'Orders')

@section('content')
    <div class="container">
        <div class="table-wrapper">
            <!-- Tiêu đề bảng -->
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Quản lý <b>Đơn Hàng</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <!-- Nút Thêm Đơn hàng Mới -->
                        <a href="#addCategoryModal" class="btn btn-success" data-toggle="modal">
                            <i class="material-icons">&#xE147;</i> <span>Thêm Đơn hàng Mới</span>
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
            <!-- Bảng Đơn Hàng -->
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="selectAll">
                                <label for="selectAll"></label>
                            </span>
                        </th>
                        <th>STT</th>
                        <th>Mã Đơn Hàng</th>
                        <th>Tổng Tiền Hàng</th>
                        <th>Tổng Giảm Giá</th>
                        <th>Tổng Thanh Toán</th>
                        <th>Phương Thức Thanh Toán</th>
                        <th>Trạng Thái Thanh Toán</th>
                        <th>Địa Chỉ Giao</th>
                        <th>Tên Người Nhận</th>
                        <th>SĐT Nhận</th>
                        <th>Trạng Thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $stt = 1; // Khởi tạo giá trị
                    @endphp

                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox-{{ $order->id }}" name="options[]"
                                        value="{{ $order->id }}">
                                    <label for="checkbox-{{ $order->id }}"></label>
                                </span>
                            </td>

                            <td>{{ $stt++ }}</td>
                            <td>{{ $order->ma_don_hang }}</td>
                            <td>{{ number_format($order->tong_tien_hang, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($order->tong_giam_gia, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($order->phi_van_chuyen, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($order->tong_thanh_toan, 0, ',', '.') }} đ</td>
                            <td>{{ $order->pt_thanhtoan }}</td>
                            <td>
                                @if ($order->trangthai_thanhtoan)
                                    <span class="label label-success">Đã Thanh Toán</span>
                                @else
                                    <span class="label label-danger">Chưa Thanh Toán</span>
                                @endif
                            </td>
                            <td>{{ $order->dia_chi_giao }}</td>
                            <td>{{ $order->ten_nguoi_nhan }}</td>
                            <td>{{ $order->sdt_nhan }}</td>
                            <td>
                                <form action="{{ route('admin.order.update', $order->id_donhang) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select class="form-control" name="trangthai" onchange="this.form.submit()">
                                        <option value="pending" {{ $order->trangthai == 'pending' ? 'selected' : '' }}>Đang
                                            chờ xử lý</option>
                                        <option value="confirmed" {{ $order->trangthai == 'confirmed' ? 'selected' : '' }}>
                                            Đã xác nhận</option>
                                        <option value="processing"
                                            {{ $order->trangthai == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                        <option value="shipping" {{ $order->trangthai == 'shipping' ? 'selected' : '' }}>
                                            Đang giao hàng</option>
                                        <option value="completed" {{ $order->trangthai == 'completed' ? 'selected' : '' }}>
                                            Đã hoàn thành</option>
                                        <option value="cancelled" {{ $order->trangthai == 'cancelled' ? 'selected' : '' }}>
                                            Đã hủy</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="#deleteOrderModal-{{ $order->id }}" class="delete" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Xóa">&#xE872;</i>
                                </a>
                            </td>
                        </tr>


                        <!-- Modal Xóa Đơn Hàng -->
                        <div id="deleteOrderModal-{{ $order->id }}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.order.destroy', $order) }}" method="POST">
                                        @csrf
                                        @method('DELETE') <!-- Chỉnh sửa từ POST thành DELETE -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Xóa Đơn Hàng</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa đơn hàng này?</p>
                                            <p class="text-warning"><small>Hành động này không thể hoàn tác.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal"
                                                value="Hủy">
                                            <input type="submit" class="btn btn-danger" value="Xóa">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                            <input type="text" class="form-control" name="CategoryName" placeholder="Nhập tên danh mục"
                                required>
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
