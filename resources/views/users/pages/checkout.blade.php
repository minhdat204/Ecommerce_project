@extends('users.layouts.layout')

@section('content')
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Header styles */
        .page-header {
            border-bottom: 1px solid #e5e5e5;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        /* Form styles */
        .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            width: 100%;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        /* Address section */
        .address-selects select {
            margin-bottom: 10px;
        }

        /* Payment methods */
        .payment-methods {
            margin-top: 20px;
        }

        .form-check {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .form-check:last-child {
            border-bottom: none;
        }

        .form-check-input {
            margin-right: 8px;
        }

        .form-check-label {
            font-size: 14px;
            color: #333;
        }

        /* Order summary card */
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 15px;
            background: #fff;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .total-section {
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
            margin-top: 15px;
        }

        /* Button styles */
        .btn-primary {
            background-color: #2196f3;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #1976d2;
        }

        /* Price styling */
        .price {
            color: #333;
            font-weight: 500;
        }

        /* Shipping info */
        .shipping-info {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            .col-lg-7,
            .col-lg-5 {
                padding: 0;
            }
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
            /* Tăng margin bottom */
        }

        .form-control {
            padding: 1rem 0.75rem;
            height: auto;
            margin-bottom: 15px;
            /* Thêm margin bottom cho input */
        }

        .form-label {
            position: absolute;
            top: 0;
            left: 12px;
            font-size: 12px;
            color: #6c757d;
            background: white;
            padding: 0 5px;
            margin: -8px 0 0;
            pointer-events: none;
        }

        select.form-control {
            padding: 0.375rem 0.75rem;
            margin-bottom: 15px;
            /* Thêm margin cho select */
        }

        .row {
            margin-bottom: 20px;
            /* Thêm margin cho row */
        }

        .payment-title {
            font-size: 16px;
            font-weight: bold;
            margin: 30px 0 20px;
            /* Tăng margin top và bottom */
        }

        .form-check {
            border: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 15px;
            /* Tăng margin bottom */
        }

        /* Phần vận chuyển */
        .mb-4 {
            margin-bottom: 30px !important;
            /* Tăng margin */
        }

        /* Khoảng cách cho phần thanh toán */
        .form-group .form-check:last-child {
            margin-bottom: 30px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            /* Thêm margin top */
        }

        /* Điều chỉnh khoảng cách cho phần đơn hàng */
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card .mb-3 {
            margin-bottom: 1.5rem !important;
        }

        hr {
            margin: 20px 0;
            /* Tăng margin cho đường kẻ */
        }

        /* Tăng khoảng cách giữa các section */
        .col-lg-7,
        .col-lg-5 {
            margin-bottom: 30px;
        }
    </style>
    <div class="container mt-5 mb-5">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <form id="checkoutForm" method="POST" class="row g-4">
                @csrf
                <!-- Left Column - Shipping Info -->
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Thông Tin Giao Nhận Hàng</h5>

                            <div class="form-floating mb-3">
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Họ và tên">
                                <label for="name">Họ và tên</label>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Email">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" id="phone" name="phone" class="form-control"
                                            placeholder="Điện thoại">
                                        <label for="phone">Điện thoại</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-4">
                                <input type="text" id="address" name="address" class="form-control"
                                    placeholder="Địa chỉ">
                                <label for="address">Địa chỉ</label>
                            </div>

                            <h5 class="fw-bold mb-3">Phương Thức Thanh Toán</h5>
                            <div class="payment-methods">
                                <div class="form-check mb-3">
                                    <input type="radio" id="cod" name="payment" value="cod"
                                        class="form-check-input" checked>
                                    <label class="form-check-label d-flex align-items-center" for="cod">
                                        <i class="bi bi-cash me-2 fs-5"></i>
                                        Thanh toán khi giao hàng (COD)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="momo" name="payment" value="momo"
                                        class="form-check-input">
                                    <label class="form-check-label d-flex align-items-center" for="momo">
                                        <i class="bi bi-wallet2 me-2 fs-5"></i>
                                        Ví MoMo
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="submitCheckoutForm()"
                            class="btn btn-primary w-100 mt-4 py-3 fw-bold">
                            Hoàn Tất Đặt Hàng
                        </button>

                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Đơn Hàng Của Bạn</h5>

                            <!-- Cart Items -->
                            <div class="cart-items mb-4" style="max-height: 400px; overflow-y: auto;">
                                @forelse($cartItems as $item)
                                    @php
                                        $price = $item->product->gia_khuyen_mai ?? $item->product->gia;
                                        $quantity = $item->soluong;

                                    @endphp

                                    <input type="hidden" name="cartItems[{{ $loop->index }}][product_id]"
                                        value="{{ $item->id_sanpham }}">
                                    <input type="hidden" name="cartItems[{{ $loop->index }}][price]"
                                        value="{{ $price }}">
                                    <input type="hidden" name="cartItems[{{ $loop->index }}][quantity]"
                                        value="{{ $quantity }}">


                                    <div class="cart-item mb-3">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->product->image }}" alt="{{ $item->product->tensanpham }}"
                                                class="rounded-3 me-3"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $item->product->tensanpham }}</h6>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-muted">{{ $item->soluong }} x
                                                        {{ number_format($item->product->gia_khuyen_mai ?? $item->product->gia, 0, ',', '.') }}₫</span>
                                                    <span
                                                        class="fw-bold">{{ number_format(($item->product->gia_khuyen_mai ?? $item->product->gia) * $item->soluong, 0, ',', '.') }}₫</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-3">
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <i class="bi bi-cart-x fs-1 text-muted"></i>
                                        <p class="mt-2">Giỏ hàng của bạn đang trống</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Order Summary -->
                            @if ($cartItems->isNotEmpty())
                                <div class="order-summary bg-light p-3 rounded-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Tổng tiền hàng:</span>
                                        <span>{{ number_format($cartItems->sum(fn($item) => ($item->product->gia_khuyen_mai ?? $item->product->gia) * $item->soluong), 0, ',', '.') }}₫</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Phí giao hàng:</span>
                                        <span>{{ number_format($totalShip, 0, ',', '.') }}₫</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fw-bold mb-0">Tổng thanh toán</h6>
                                        <h6 class="fw-bold mb-0 text-primary">
                                            {{ number_format($cartItems->sum(fn($item) => ($item->product->gia_khuyen_mai ?? $item->product->gia) * $item->soluong) + $totalShip, 0, ',', '.') }}₫
                                        </h6>
                                    </div>
                                </div>

                                <input type="hidden" name="totalPrice"
                                    value="{{ $cartItems->sum(fn($item) => ($item->product->gia_khuyen_mai ?? $item->product->gia) * $item->soluong) }}">
                                <input type="hidden" name="totalShip" value="{{ $totalShip }}">
                                <input type="hidden" name="totalPayment"
                                    value="{{ $cartItems->sum(fn($item) => ($item->product->gia_khuyen_mai ?? $item->product->gia) * $item->soluong) + $totalShip }}">
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <style>
            .form-floating>.form-control:focus~label,
            .form-floating>.form-control:not(:placeholder-shown)~label {
                opacity: .85;
                transform: scale(.85) translateY(-1rem) translateX(.15rem);
            }

            .form-floating>.form-control:focus,
            .form-floating>.form-control:not(:placeholder-shown) {
                padding-top: 1.625rem;
                padding-bottom: .625rem;
            }

            .card {
                transition: all 0.3s ease;
            }

            .cart-items::-webkit-scrollbar {
                width: 6px;
            }

            .cart-items::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .cart-items::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 10px;
            }

            .cart-items::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            .payment-methods .form-check-label {
                cursor: pointer;
                padding: 10px;
                border-radius: 8px;
                transition: all 0.2s ease;
            }

            .payment-methods .form-check-input:checked+.form-check-label {
                background-color: #f8f9fa;
            }
        </style>
    </div>
@endsection
@push('scripts')
    <script>
        function submitCheckoutForm() {
            const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
            const form = document.getElementById('checkoutForm');

            // Xác định route theo phương thức thanh toán
            if (paymentMethod === 'cod') {
                form.action = "{{ route('checkout.checkoutCOD') }}";
            } else if (paymentMethod === 'momo') {
                form.action = "{{ route('checkout.momo.payment') }}";
            }

            form.submit(); // Gửi form
        }
    </script>
@endpush
{{-- @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkoutForm = document.querySelector('#checkout-form');

            checkoutForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate form
                const name = document.querySelector('#name').value;
                const phone = document.querySelector('#phone').value;
                const address = document.querySelector('#address').value;
                const city = document.querySelector('#city').value;
                const district = document.querySelector('#district').value;
                const ward = document.querySelector('#ward').value;

                if (!name || !phone || !address || !city || !district || !ward) {
                    alert('Vui lòng điền đầy đủ thông tin giao hàng');
                    return;
                }

                // Validate phone number
                const phoneRegex = /(84|0[3|5|7|8|9])+([0-9]{8})\b/;
                if (!phoneRegex.test(phone)) {
                    alert('Số điện thoại không hợp lệ');
                    return;
                }

                // Validate email if provided
                const email = document.querySelector('#email').value;
                if (email) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        alert('Email không hợp lệ');
                        return;
                    }
                }

                // Submit form if validation passes
                this.submit();
            });

            // Load địa chỉ
            const citySelect = document.querySelector('#city');
            const districtSelect = document.querySelector('#district');
            const wardSelect = document.querySelector('#ward');

            // Gọi API để load dữ liệu tỉnh/thành phố
            fetch('/api/cities')
                .then(response => response.json())
                .then(cities => {
                    cities.forEach(city => {
                        const option = new Option(city.name, city.id);
                        citySelect.add(option);
                    });
                });

            // Load quận/huyện khi chọn tỉnh/thành phố
            citySelect.addEventListener('change', function() {
                fetch(`/api/districts/${this.value}`)
                    .then(response => response.json())
                    .then(districts => {
                        districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
                        districts.forEach(district => {
                            const option = new Option(district.name, district.id);
                            districtSelect.add(option);
                        });
                    });
            });

            // Load phường/xã khi chọn quận/huyện
            districtSelect.addEventListener('change', function() {
                fetch(`/api/wards/${this.value}`)
                    .then(response => response.json())
                    .then(wards => {
                        wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                        wards.forEach(ward => {
                            const option = new Option(ward.name, ward.id);
                            wardSelect.add(option);
                        });
                    });
            });
        });
    </script>
@endpush --}}
