<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-primary">Chi tiết đơn hàng #{{ $order->id_donhang }}</h4>
                <div class="order-status">
                    <span
                        class="badge rounded-pill 
                        @if ($order->trangthai == 'cho_xac_nhan') bg-warning
                        @elseif($order->trangthai == 'da_xac_nhan') bg-info 
                        @elseif($order->trangthai == 'dang_giao') bg-primary
                        @elseif($order->trangthai == 'da_giao') bg-success
                        @elseif($order->trangthai == 'da_huy') bg-danger @endif">
                        {{ ucfirst(str_replace('_', ' ', $order->trangthai)) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row g-4">
                <!-- Cột thông tin đơn hàng -->
                <div class="col-md-8">
                    <!-- Thông tin người nhận -->
                    <div class="info-card p-3 h-100 border rounded bg-light mb-4">
                        <h5 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Thông tin người nhận</h5>
                        <div class="info-item mb-2">
                            <span class="fw-bold">Người nhận:</span>
                            <span class="ms-2">{{ $order->ten_nguoi_nhan }}</span>
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">Số điện thoại:</span>
                            <span class="ms-2">{{ $order->sdt_nhan }}</span>
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">Địa chỉ:</span>
                            <span class="ms-2">{{ $order->dia_chi_giao }}</span>
                        </div>
                        <div class="info-item">
                            <span class="fw-bold">Ngày đặt:</span>
                            <span class="ms-2">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    <!-- Thông tin thanh toán -->
                    <div class="info-card p-3 h-100 border rounded bg-light mb-4">
                        <h5 class="text-primary mb-3"><i class="fas fa-credit-card me-2"></i>Thông tin thanh toán</h5>
                        <div class="info-item mb-2">
                            <span class="fw-bold">Tổng tiền hàng:</span>
                            <span class="ms-2">{{ number_format($order->tong_tien_hang) }}đ</span>
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">Giảm giá:</span>
                            <span class="ms-2">{{ number_format($order->tong_giam_gia) }}đ</span>
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">Phí vận chuyển:</span>
                            <span class="ms-2">{{ number_format($order->phi_van_chuyen) }}đ</span>
                        </div>
                        <div class="info-item mb-2">
                            <span class="fw-bold">Tổng thanh toán:</span>
                            <span
                                class="ms-2 text-danger fw-bold fs-5">{{ number_format($order->tong_thanh_toan) }}đ</span>
                        </div>
                        <div class="info-item">
                            <span class="fw-bold">Phương thức thanh toán:</span>
                            <span class="ms-2">{{ $order->pt_thanhtoan }}</span>
                        </div>
                    </div>

                    <!-- Chi tiết sản phẩm -->
                    <div class="order-items mb-4">
                        <h5 class="text-primary mb-3"><i class="fas fa-box me-2"></i>Chi tiết sản phẩm</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Hình ảnh</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderDetails as $detail)
                                        <tr>
                                            <td class="align-middle">{{ $detail->product->tensanpham }}</td>
                                            <td class="align-middle">
                                                <img src="{{ asset('storage/' . $detail->product->hinhanh) }}"
                                                    class="rounded shadow-sm" alt="{{ $detail->product->tensanpham }}"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            </td>
                                            <td class="align-middle">{{ number_format($detail->gia) }}đ</td>
                                            <td class="align-middle">{{ $detail->soluong }}</td>
                                            <td class="align-middle fw-bold">
                                                {{ number_format($detail->gia * $detail->soluong) }}đ</td>
                                            @if ($order->trangthai === 'completed')
                                                <td>
                                                    <a href="{{ Route('users.shop_details', ['slug' => $detail->product->slug]) }}"
                                                        class="btn btn-primary btn-sm">đánh
                                                        giá</a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Cột timeline -->
                <div class="col-md-4">
                    <div class="timeline-section p-3 h-100 border rounded bg-light">
                        <h5 class="text-primary mb-3"><i class="fas fa-history me-2"></i>Trạng thái đơn hàng</h5>
                        <div class="timeline">
                            <div class="timeline-item {{ $order->trangthai === 'pending' ? 'active' : '' }}">
                                <div class="timeline-date">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                                <div class="timeline-content">Đơn hàng chờ xử lý</div>
                            </div>
                            <div class="timeline-item {{ $order->trangthai === 'confirmed' ? 'active' : '' }}">
                                @if ($order->trangthai === 'confirmed')
                                    {{ $order->updated_at->format('d/m/Y H:i') }}
                                @endif
                                <div class="timeline-content">Đơn hàng đã xác nhận</div>
                            </div>
                            <div class="timeline-item {{ $order->trangthai === 'processing' ? 'active' : '' }}">
                                @if ($order->trangthai === 'processing')
                                    {{ $order->updated_at->format('d/m/Y H:i') }}
                                @endif
                                <div class="timeline-content">Đơn hàng đang xử lý</div>
                            </div>
                            <div class="timeline-item {{ $order->trangthai === 'shipping' ? 'active' : '' }}">
                                @if ($order->trangthai === 'shipping')
                                    {{ $order->updated_at->format('d/m/Y H:i') }}
                                @endif
                                <div class="timeline-content">Đơn hàng đang giao</div>
                            </div>
                            <div class="timeline-item {{ $order->trangthai === 'completed' ? 'active' : '' }}">
                                @if ($order->trangthai === 'completed')
                                    {{ $order->updated_at->format('d/m/Y H:i') }}
                                @endif
                                <div class="timeline-content">Đơn hàng hoàn thành</div>
                            </div>

                            @if ($order->trangthai == 'cancelled')
                                <div class="timeline-item active cancelled">
                                    <div class="timeline-date">{{ $order->updated_at->format('d/m/Y H:i') }}</div>
                                    <div class="timeline-content">Đơn hàng đã bị hủy</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                @if (in_array($order->trangthai, ['pending', 'confirmed', 'processing']))
                    <button class="btn btn-danger" onclick="cancelOrder({{ $order->id_donhang }})">
                        <i class="fas fa-times me-2"></i>Hủy đơn hàng
                    </button>
                @endif
                <button class="btn btn-secondary" onclick="window.history.back()">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </button>
            </div>
        </div>
    </div>
</div>



<style>
    .info-card {
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        padding: 20px 0;
        border-left: 2px solid #dee2e6;
        margin-left: 20px;
        position: relative;
        padding-left: 30px;
    }

    .timeline-item:before {
        content: '';
        width: 15px;
        height: 15px;
        background: #007bff;
        border: 3px solid #fff;
        border-radius: 50%;
        position: absolute;
        left: -8.5px;
        top: 24px;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
    }

    .timeline-date {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .timeline-content {
        color: #495057;
    }

    .badge {
        padding: 8px 16px;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .btn {
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .timeline-item {
        padding: 20px 0;
        border-left: 2px solid #dee2e6;
        margin-left: 20px;
        position: relative;
        padding-left: 30px;
        opacity: 0.5;
        /* Mờ đối với trạng thái chưa đạt */
        transition: all 0.3s ease;
    }

    .timeline-item:before {
        content: '';
        width: 15px;
        height: 15px;
        background: #dee2e6;
        /* Màu mặc định cho trạng thái chưa đạt */
        border: 3px solid #fff;
        border-radius: 50%;
        position: absolute;
        left: -8.5px;
        top: 24px;
        box-shadow: 0 0 0 3px rgba(222, 226, 230, 0.2);
        transition: all 0.3s ease;
    }

    .timeline-item.active {
        opacity: 1;
    }

    .timeline-item.active:before {
        background: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
    }

    .timeline-item.cancelled:before {
        background: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.2);
    }

    .timeline-date {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .timeline-content {
        color: #495057;
        font-weight: 500;
    }

    .timeline-item.active .timeline-content {
        color: #000;
    }

    .timeline-item.cancelled .timeline-content {
        color: #dc3545;
    }

    /* Thêm hiệu ứng cho trạng thái đã hoàn thành */
    .timeline-item.active .timeline-content {
        font-weight: bold;
        color: #007bff;
        /* Màu xanh nổi bật */
    }

    .timeline-item.active .timeline-date {
        color: #0056b3;
        /* Màu đậm hơn cho thời gian */
    }

    .timeline-item.cancelled .timeline-content {
        color: #dc3545;
        /* Màu đỏ cho trạng thái hủy */
    }

    .timeline-item.cancelled .timeline-date {
        color: #b32d3a;
        /* Màu đỏ đậm hơn */
    }
</style>

<script></script>
