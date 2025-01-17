@extends('Admin.Layout.Layout')

@section('title', 'Quản lý Đơn Hàng')

@section('content')
    <style>
        .status-select {
            padding: 8px 12px;
            border-radius: 20px;
            border: 1px solid #ddd;
            cursor: pointer;
            min-width: 140px;
            appearance: none;
            text-align: center;
        }

        /* Status Colors */
        /* Ghi đè màu sắc cho từng trạng thái */
        .status-pending {
            background-color: #FFE4B5 !important;
            /* Màu pastel nhẹ hơn */
            color: #FFA500 !important;
            /* Đổi màu chữ */
            border-color: #FFE4B5 !important;
        }

        .status-processing {
            background-color: #D1C4E9 !important;
            color: #5E35B1 !important;
            border-color: #D1C4E9 !important;
        }

        .status-shipping {
            background-color: #E1BEE7 !important;
            color: #8E24AA !important;
            border-color: #E1BEE7 !important;
        }

        .status-completed {
            background-color: #C8E6C9 !important;
            color: #388E3C !important;
            border-color: #C8E6C9 !important;
        }

        .status-cancelled {
            background-color: #FFCDD2 !important;
            color: #D32F2F !important;
            border-color: #FFCDD2 !important;
        }

        /* Ghi đè để xóa màu khi mở dropdown */
        .status-select:focus option {
            background-color: #ffffff !important;
            color: #333333 !important;
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
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }
    </style>
    @php
        $statusOrder = [
            'pending' => 1,
            'processing' => 2,
            'shipping' => 3,
            'completed' => 4,
            'cancelled' => 5,
        ];
    @endphp
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

    <div>
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
                        <a href="{{ route('admin.order.index') }}"
                            class="filter-btn {{ !request('status') || request('status') == 'all' ? 'active' : '' }}">
                            Tất cả
                        </a>
                        <a href="{{ route('admin.order.index', ['status' => 'pending']) }}"
                            class="filter-btn {{ request('status') == 'pending' ? 'active' : '' }}">
                            Chờ xử lý
                        </a>
                        <a href="{{ route('admin.order.index', ['status' => 'processing']) }}"
                            class="filter-btn {{ request('status') == 'processing' ? 'active' : '' }}">
                            Đang xử lý
                        </a>
                        <a href="{{ route('admin.order.index', ['status' => 'shipping']) }}"
                            class="filter-btn {{ request('status') == 'shipping' ? 'active' : '' }}">
                            Đang giao
                        </a>
                        <a href="{{ route('admin.order.index', ['status' => 'completed']) }}"
                            class="filter-btn {{ request('status') == 'completed' ? 'active' : '' }}">
                            Đã giao
                        </a>
                        <a href="{{ route('admin.order.index', ['status' => 'cancelled']) }}"
                            class="filter-btn {{ request('status') == 'cancelled' ? 'active' : '' }}">
                            Đã hủy
                        </a>
                        <a href="{{ route('admin.order.index', ['status' => 'inactive']) }}"
                            class="filter-btn {{ request('status') == 'inactive' ? 'active' : '' }}">
                            Đã xóa
                        </a>

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
                        {{-- <th>Trạng Thái Thanh Toán</th> --}}
                        <th>Địa Chỉ Giao</th>
                        <th>Tên Người Nhận</th>
                        <th>SĐT Nhận</th>
                        <th>Trạng Thái</th>
                        {{-- <th>Hành động</th> --}}
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
                            {{-- <td>
                                @if ($order->trangthai_thanhtoan)
                                    <span class="label label-success">Đã Thanh Toán</span>
                                @else
                                    <span class="label label-danger">Chưa Thanh Toán</span>
                                @endif
                            </td> --}}
                            <td>{{ $order->dia_chi_giao }}</td>
                            <td>{{ $order->ten_nguoi_nhan }}</td>
                            <td>{{ $order->sdt_nhan }}</td>
                            <td>
                                <form action="{{ route('admin.order.update', $order->id_donhang) }}" method="POST"
                                    class="status-form">
                                    @csrf
                                    @method('PUT')
                                    <select name="trangthai" class="status-select" onchange="this.form.submit()">
                                        <option value="pending"
                                            class="status-pending"{{ $order->trangthai == 'pending' ? 'selected' : '' }}>
                                            Chờ xử lý
                                        </option>
                                        <option value="processing" class="status-processing"
                                            {{ $order->trangthai == 'processing' ? 'selected' : '' }}>
                                            Đang xử lý
                                        </option>
                                        <option value="shipping" {{ $order->trangthai == 'shipping' ? 'selected' : '' }}>
                                            Đang giao
                                        </option>
                                        <option value="completed" {{ $order->trangthai == 'completed' ? 'selected' : '' }}>
                                            Đã hoàn thành
                                        </option>
                                        <option value="cancelled" {{ $order->trangthai == 'cancelled' ? 'selected' : '' }}>
                                            Đã hủy
                                        </option>
                                        <option value="" {{ $order->trangthai == 'inactive' ? 'selected' : '' }}>
                                            Đã xóa
                                        </option>

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
                <div class="hint-text">
                    Hiển thị <b>{{ $orders->count() }}</b> trong tổng số <b>{{ $orders->total() }}</b> mục
                </div>
                {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <!-- Form Xóa Đã Chọn (ẩn) -->
    <form id="deleteSelectedForm" method="POST">
        @csrf
        @method('DELETE')
    </form>

    <script>
        //checked
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

            // Toggle dropdown
            $('.status-badge').click(function(e) {
                e.stopPropagation();
                $(this).siblings('.status-options').toggle();
            });

            // Close dropdown when clicking outside
            $(document).click(function() {
                $('.status-options').hide();
            });

            // Handle status change
            $('.status-option').click(function() {
                const orderId = $(this).closest('.status-dropdown').data('order-id');
                const newStatus = $(this).data('status');
                const statusText = $(this).text();

                if (confirm('Bạn có chắc muốn thay đổi trạng thái đơn hàng?')) {
                    $.ajax({
                        url: `/admin/order/${orderId}`,
                        method: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            trangthai: newStatus
                        },
                        success: function() {
                            const badge = $(this).closest('.status-dropdown').find(
                                '.status-badge');
                            badge.removeClass().addClass(`status-badge status-${newStatus}`);
                            badge.html(statusText);
                        }
                    });
                }

                $(this).closest('.status-options').hide();
            });
        });


        // $(document).ready(function() {
        //     $('.status-select').change(function() {
        //         const form = $(this).closest('form');
        //         const currentStatus = $(this).data('current');
        //         const newStatus = $(this).val();

        //         if (confirm('Bạn có chắc muốn thay đổi trạng thái đơn hàng?')) {
        //             $.ajax({
        //                 url: form.attr('action'),
        //                 method: 'POST',
        //                 data: {
        //                     _token: $('meta[name="csrf-token"]').attr('content'),
        //                     trangthai: newStatus
        //                 },
        //                 success: function(response) {
        //                     if (response.success) {
        //                         // Chỉ hiển thị thông báo thành công
        //                         toastr.info('Trạng thái đã được cập nhật.');
        //                     } else {
        //                         // Reset trạng thái nhưng không hiển thị thông báo lỗi
        //                         $(this).val(currentStatus);
        //                     }
        //                 },
        //                 error: function() {
        //                     toastr.error('Có lỗi xảy ra trong quá trình cập nhật!');
        //                     $(this).val(currentStatus); // Reset trạng thái nếu gặp lỗi
        //                 }
        //             });
        //         } else {
        //             $(this).val(currentStatus); // Reset trạng thái nếu không xác nhận
        //         }
        //     });
        // });

        // $(document).ready(function() {
        //     $('.status-select').change(function() {
        //         const form = $(this).closest('form');
        //         const currentStatus = $(this).data('current');
        //         const newStatus = $(this).val();

        //         $.ajax({
        //             url: form.attr('action'),
        //             method: 'POST',
        //             data: form.serialize(),
        //             success: function(response) {
        //                 toastr.success(response.success);
        //                 location.reload();
        //             },
        //             error: function(xhr) {
        //                 const response = xhr.responseJSON;
        //                 toastr.error(response.error);
        //                 // Reset về trạng thái cũ
        //                 $(this).val(currentStatus);
        //             }
        //         });

        //         return false;
        //     });
        // });

        // $(document).ready(function() {
        //     $('.status-select').change(function() {
        //         const form = $(this).closest('form');
        //         const currentStatus = $(this).data('current');
        //         const newStatus = $(this).val();

        //         if (confirm('Bạn có chắc muốn thay đổi trạng thái đơn hàng?')) {
        //             $.ajax({
        //                 url: form.attr('action'),
        //                 method: 'POST',
        //                 data: {
        //                     _token: $('meta[name="csrf-token"]').attr('content'),
        //                     trangthai: newStatus
        //                 },
        //                 success: function(response) {
        //                     if (response.success) {
        //                         toastr.success(response.message);
        //                         location.reload();
        //                     } else {
        //                         toastr.error('Cập nhật thất bại!');
        //                         $(this).val(currentStatus);
        //                     }
        //                 },
        //                 error: function(xhr) {
        //                     const response = xhr.responseJSON;
        //                     toastr.error(response.error || 'Có lỗi xảy ra!');
        //                     $(this).val(currentStatus);
        //                 }
        //             });
        //         } else {
        //             $(this).val(currentStatus); // Reset nếu không confirm
        //         }
        //     });
        // });
    </script>

    <!-- Add Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@endsection
