@extends('users.layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/favorite.js') }}"></script>
    <script src="{{ asset('js/quickAddToCart') }}"></script>
@endpush

@section('content')
<div class="container mt-5">
    <!-- Navigation Tabs -->
    <ul class="profile-navigation">
        <li><a href="#" class="active">Personal Info</a></li>
        <li><a href="#">Favorites List</a></li>
        <li><a href="#">Scored List</a></li>
        <li><a href="#">Order List</a></li>

    </ul>

    <!-- Tab Content -->
    <div class="profile-content mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- Personal Tab -->
        <div class="profile-tab-pane" style="display: block;">
            <form method="POST" action="{{ route('profile.update', Auth::id()) }}">
                @csrf
                @method('PUT')
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="user-fullname" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="user-fullname" name="hoten"
                                    value="{{ old('hoten', Auth::user()->hoten) }}" maxlength="50">
                            </div>
                            <div class="col-md-6">
                                <label for="user-id" class="form-label">User ID</label>
                                <input type="text" class="form-control" id="user-id" name="id_nguoidung"
                                    value="{{ Auth::user()->id_nguoidung }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="user-gender" class="form-label">Gender</label>
                                <select class="form-select" id="user-gender" name="gioitinh">
                                    <option value="male" {{ Auth::user()->gioitinh == 'male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="female" {{ Auth::user()->gioitinh == 'female' ? 'selected' : '' }}>
                                        Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="user-nationality" class="form-label">Nationality</label>
                                <input type="text" class="form-control" id="user-nationality" name="quoctich"
                                    value="Việt Nam" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="user-address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="user-address" name="diachi"
                                    value="{{ Auth::user()->diachi }}" maxlength="50">
                            </div>
                            <div class="col-md-6">
                                <label for="user-phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="user-phone" name="sodienthoai"
                                    value="{{ old('sodienthoai', Auth::user()->sodienthoai) }}" maxlength="10">
                                @if ($errors->has('sodienthoai'))
                                    <div class="text-danger mt-1">The phone number must be 10 digits</div>
                                @endif
                            </div>
                        </div>

                        <div class="email-address-section border p-3 rounded mb-3">
                            <h5>Email Address</h5>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-envelope me-2 text-primary" style="font-size: 1.5rem;"></i>
                                <div>
                                    <p class="mb-0">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-sm btn-primary">Edit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Favorites List Tab -->
        <div class="profile-tab-pane" style="display: none;">
            <div class="favorite-page-container">
                <div class="row">
                    @forelse ($favorites as $favorite)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ asset('img/product/' . $favorite->image) }}" class="card-img-top"
                                    alt="{{ $favorite->tensanpham }}" style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $favorite->tensanpham }}</h5>
                                    <p class="card-text text-muted">{{ number_format($favorite->gia, 0, ',', '.') }}đ</p>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-sm btn-success me-auto"
                                            onclick="quickAddToCart('{{ $favorite->id_sanpham }}')">
                                            Add to Cart
                                        </button>
                                        <form action="{{ route('favorites.destroy', $favorite->id_sanpham) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Remove this product from favorites?')">
                                            Delete
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center">Không tìm thấy sản phẩm yêu thích!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>



        <!-- Pagination -->
        <div class="pagination-container mt-4">
            {{ $favorites->links() }}
        </div>
    </div>
    <!-- Score List -->
    <div class="profile-tab-pane" style="display: none;">
        <div class="favorite-page-container">
            <div class="row">
                @forelse ($scores as $score)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $score->product->tensanpham }}</h5>
                                <p class="card-text text-muted">
                                    {{ number_format($score->product->gia, 0, ',', '.') }}đ
                                </p>
                                <p><strong>Thời gian đánh giá</strong> {{ $score->created_at }}</p>
                                <p><strong>Điểm đánh giá:</strong> {{ $score->danhgia }}/5</p>
                                <p><strong>Nội dung:</strong> {{ $score->noidung }}</p>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('users.shop_details', ['slug' => $score->product->slug]) }}"
                                        class="btn btn-sm btn-primary">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Không tìm thấy sản phẩm đã đánh giá!</p>
                    </div>
                @endforelse
            </div>
            
        </div>
    </div>
    <div class="pagination-container mt-4">
            {{ $scores->links() }}
        </div>
    <!-- orders-list.blade.php -->
    <div class="profile-tab-pane">
        <div class="orders-page-container">
            <h3 class="mb-4">Đơn hàng của tôi</h3>
            <div class="row">
                @forelse ($orders as $order)
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Mã đơn: #{{ $order->ma_don_hang }}</strong>
                                    <span class="ms-3">{{ $order->created_at }}</span>
                                </div>
                                <span class="badge bg-{{ $order->trangthai }}">
                                    {{ $order->trangthai }}
                                </span>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Người nhận:</strong> {{ $order->ten_nguoi_nhan }}</p>
                                        <p><strong>SĐT:</strong> {{ $order->sdt_nhan }}</p>
                                        <p><strong>Địa chỉ:</strong> {{ $order->dia_chi_giao }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Tổng tiền hàng:</strong>
                                            {{ number_format($order->tong_tien_hang) }}đ</p>
                                        <p><strong>Giảm giá:</strong> {{ number_format($order->tong_giam_gia) }}đ
                                        </p>
                                        <p><strong>Phí vận chuyển:</strong>
                                            {{ number_format($order->phi_van_chuyen) }}đ</p>
                                        <p><strong>Tổng thanh toán:</strong>
                                            <span class="text-danger fw-bold">
                                                {{ number_format($order->tong_thanh_toan) }}đ
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="order-items mt-3">
                                    <h5>Chi tiết đơn hàng</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderDetails as $detail)
                                                    <tr>
                                                        <td>{{ $detail->product->tensanpham }}</td>
                                                        <td>{{ number_format($detail->gia) }}đ</td>
                                                        <td>{{ $detail->soluong }}</td>
                                                        <td>{{ number_format($detail->gia * $detail->soluong) }}đ
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    @if (in_array($order->trangthai, ['pending', 'confirmed', 'processing']))
                                        <button class="btn btn-danger btn-sm me-2"
                                            onclick="cancelOrder({{ $order->id_donhang }})">
                                            Hủy đơn hàng
                                        </button>
                                    @endif <button class="btn btn-primary btn-sm"
                                        onclick="window.location='{{ route('orders.detail', $order->id_donhang) }}'">
                                        Xem chi tiết
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            Bạn chưa có đơn hàng nào!
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="pagination-container mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function getOrderStatusClass(status) {
        const statusClasses = {
            'cho_xac_nhan': 'warning',
            'da_xac_nhan': 'info',
            'dang_giao': 'primary',
            'da_giao': 'success',
            'da_huy': 'danger'
        };
        return statusClasses[status] || 'secondary';
    }

    function getOrderStatusText(status) {
        const statusTexts = {
            'cho_xac_nhan': 'Chờ xác nhận',
            'da_xac_nhan': 'Đã xác nhận',
            'dang_giao': 'Đang giao',
            'da_giao': 'Đã giao',
            'da_huy': 'Đã hủy'
        };
        return statusTexts[status] || status;
    }

    function cancelOrder(orderId) {
        if (confirm('Bạn có chắc muốn hủy đơn hàng này?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                url: '/orders/' + orderId + '/cancel',
                type: 'POST',
                success: function (response) {
                    if (response.success) {
                        alert('Đã hủy đơn hàng thành công');
                        // Ẩn nút hủy đơn hàng
                        $('.btn-danger[onclick="cancelOrder(' + orderId + ')"]').hide();
                    } else {
                        alert(response.message || 'Có lỗi xảy ra');
                    }
                },
                error: function (xhr) {
                    alert('Có lỗi xảy ra: ' + (xhr.responseJSON?.message || 'Không thể hủy đơn hàng'));
                }
            });
        }
    }
</script> 