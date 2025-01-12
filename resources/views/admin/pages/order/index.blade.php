@extends('Admin.Layout.Layout')
@section('namepage', 'Orders')

@section('content')
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #16a34a;
            --warning-color: #eab308;
            --danger-color: #dc2626;
            --background-color: #f1f5f9;
            --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .filters {
            display: flex;
            gap: 1rem;
            padding: 1rem 1.5rem;
            background: #f8fafc;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            background: white;
            color: var(--secondary-color);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
    </style>
    <div class="container">
        <div class="table-wrapper">
            <!-- Tiêu đề bảng -->
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Quản lý <b>Đơn Hàng</b></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="filters">
                        <button class="filter-btn active">Tất cả</button>
                        <button class="filter-btn">Chờ xử lý</button>
                        <button class="filter-btn">Đang xử lý</button>
                        <button class="filter-btn">Đang giao</button>
                        <button class="filter-btn">Đã giao</button>
                        <button class="filter-btn">Đã hủy</button>
                    </div>
                </div>
                <div class="col-sm">
                    <!-- Form Tìm Kiếm -->
                    <form method="GET" action="" class="form-inline mb-3">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm danh mục..."
                                value=" ">
                        </div>
                        <button type="submit" class="btn btn-default">Tìm kiếm</button>
                    </form>

                </div>
            </div>
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
                        {{-- <th>Tổng Tiền Hàng</th>
                        <th>Tổng Giảm Giá</th>
                        <th>Phí Vận Chuyển</th> --}}
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
                            {{-- <td>{{ number_format($order->tong_tien_hang, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($order->tong_giam_gia, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($order->phi_van_chuyen, 0, ',', '.') }} đ</td> --}}
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
                                        <option value="pending" {{ $order->trangthai == 'pending' ? 'selected' : '' }}>
                                            Đang
                                            chờ xử lý</option>
                                        <option value="confirmed" {{ $order->trangthai == 'confirmed' ? 'selected' : '' }}>
                                            Đã xác nhận</option>
                                        <option value="processing"
                                            {{ $order->trangthai == 'processing' ? 'selected' : '' }}>Đang xử lý
                                        </option>
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
                                <a href="#deleteOrderModal-{{ $order->id_donhang }}" class="delete" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Xóa">&#xE872;</i>
                                </a>
                            </td>
                        </tr>


                        <!-- Modal Xóa Đơn Hàng -->
                        <div id="deleteOrderModal-{{ $order->id_donhang }}" class="modal fade">
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
