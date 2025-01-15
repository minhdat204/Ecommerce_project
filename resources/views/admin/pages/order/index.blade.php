@extends('Admin.Layout.Layout')
@section('title', 'Quản lý Đơn Hàng')
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

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.875rem;
            text-align: center;
            white-space: nowrap;
        }

        .status-pending {
            background-color: #FEF3C7;
            color: #D97706;
            border: 1px solid #F59E0B;
        }

        .status-confirmed {
            background-color: #DBEAFE;
            color: #2563EB;
            border: 1px solid #3B82F6;
        }

        .status-processing {
            background-color: #E0E7FF;
            color: #4F46E5;
            border: 1px solid #6366F1;
        }

        .status-shipping {
            background-color: #F3E8FF;
            color: #7C3AED;
            border: 1px solid #8B5CF6;
        }

        .status-completed {
            background-color: #DCFCE7;
            color: #16A34A;
            border: 1px solid #22C55E;
        }

        .status-cancelled {
            background-color: #FEE2E2;
            color: #DC2626;
            border: 1px solid #EF4444;
        }

        .status-select {
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            padding: 8px;
            width: 100%;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,...");
            background-repeat: no-repeat;
            background-position: right 8px center;
        }

        .status-select:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .status-dropdown {
            position: relative;
            display: inline-block;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-badge:after {
            content: '▼';
            font-size: 10px;
        }

        .status-options {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            min-width: 160px;
            padding: 8px 0;
            margin: 4px 0 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .status-option {
            padding: 8px 16px;
            cursor: pointer;
        }

        .status-option:hover {
            background-color: #f3f4f6;
        }

        /* Status Colors */
        .status-pending {
            background-color: #FEF3C7;
            color: #D97706;
        }

        .status-pending {
            background: #FEF3C7 !important;
            color: #D97706 !important;
            border: 1px solid #F59E0B !important;
        }

        .status-processing {
            background: #E0E7FF !important;
            color: #4F46E5 !important;
            border: 1px solid #6366F1 !important;
        }

        .status-shipping {
            background: #F3E8FF !important;
            color: #7C3AED !important;
            border: 1px solid #8B5CF6 !important;
        }

        .status-completed {
            background: #DCFCE7 !important;
            color: #16A34A !important;
            border: 1px solid #22C55E !important;
        }

        .status-cancelled {
            background: #FEE2E2 !important;
            color: #DC2626 !important;
            border: 1px solid #EF4444 !important;
        }

        .status-select {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
            width: 140px;
        }

        .status-select:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.875rem;
            display: inline-block;
        }

        /* Status Colors */
        .status-pending {
            background: #FEF3C7;
            color: #D97706;
        }

        .status-processing {
            background: #E0E7FF;
            color: #4F46E5;
        }

        .status-shipping {
            background: #F3E8FF;
            color: #7C3AED;
        }

        .status-completed {
            background: #DCFCE7;
            color: #16A34A;
        }

        .status-cancelled {
            background: #FEE2E2;
            color: #DC2626;
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
    <div >
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
                                        <option value="pending" {{ $order->trangthai == 'pending' ? 'selected' : '' }}>
                                            Chờ xử lý
                                        </option>
                                        <option value="processing"
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

        $(document).ready(function() {
            $('.status-select').change(function() {
                const form = $(this).closest('form');
                const currentStatus = $(this).data('current');
                const newStatus = $(this).val();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        toastr.success(response.success);
                        location.reload();
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        toastr.error(response.error);
                        // Reset về trạng thái cũ
                        $(this).val(currentStatus);
                    }
                });

                return false;
            });
        });

        $(document).ready(function() {
            // ...existing checkbox code...

            // Handle status change
            $('.status-select').change(function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                const select = $(this);
                const currentStatus = select.find('option:selected').val();

                if (confirm('Bạn có chắc muốn thay đổi trạng thái đơn hàng?')) {
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            toastr.success(response.success);
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            toastr.error(response.error);
                            select.val(currentStatus); // Reset về giá trị cũ
                        }
                    });
                } else {
                    select.val(currentStatus); // Reset nếu không confirm
                }
            });
        });
    </script>

    <!-- Add Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@endsection
