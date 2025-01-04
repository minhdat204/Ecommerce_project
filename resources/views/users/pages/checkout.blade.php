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
    </style>
    <div class="container mt-5 mb-5">
        <style>
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

        <div class="row">
            <!-- Phần code HTML giữ nguyên như cũ -->
            <div class="col-lg-7">
                <h5 class="mb-4"><strong>Thông Tin Giao Nhận Hàng</strong></h5>
                <form action="#" method="POST">
                    <!-- Họ và tên -->
                    <div class="form-group">
                        <input type="text" id="name" name="name" class="form-control" placeholder=" ">
                        <label for="name" class="form-label">Họ và tên</label>
                    </div>

                    <!-- Email và Điện thoại -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" id="email" name="email" class="form-control" placeholder=" ">
                                <label for="email" class="form-label">Email</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" id="phone" name="phone" class="form-control" placeholder=" ">
                                <label for="phone" class="form-label">Điện thoại</label>
                            </div>
                        </div>
                    </div>

                    <!-- Địa chỉ -->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" id="address" name="address" class="form-control" placeholder=" ">
                                <label for="address" class="form-label">Địa chỉ</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="city" class="form-control">
                                    <option value="">Chọn thành phố</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="district" class="form-control">
                                    <option value="">Chọn quận</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="ward" class="form-control">
                                    <option value="">Chọn phường</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Phương thức vận chuyển -->
                    <div class="mb-4">
                        <label class="payment-title">Vận chuyển:</label>
                        <p>Vận chuyển tới: 99 Hoàng Hoa Thám, Phường 6, Quận Bình Thạnh, TP.HCM</p>
                    </div>

                    <!-- Phương thức thanh toán -->
                    <h5 class="payment-title">Chọn Phương Thức Thanh Toán</h5>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="radio" id="cod" name="payment" class="form-check-input" checked>
                            <label for="cod" class="form-check-label">Thanh toán khi giao hàng (COD)</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="momo" name="payment" class="form-check-input">
                            <label for="momo" class="form-check-label">Ví MoMo</label>
                        </div>
                    </div>

                    <!-- Nút đặt hàng -->
                    <button type="submit" class="btn btn-primary">Hoàn Tất Đặt Hàng</button>
                </form>
            </div>

            <!-- Đơn hàng -->
            <div class="col-lg-5">
                <h5 class="mb-4"><strong>Đơn Hàng Của Bạn</strong></h5>
                <div class="card p-3">
                    <div class="d-flex justify-content-between mb-3">
                        <p>Vải Quất Farm size Regular - 125GR/ Hộp</p>
                        <p><strong>60.000₫</strong></p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span>60.000₫</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Phí giao hàng:</span>
                        <span>0₫</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h6><strong>Tổng thanh toán</strong></h6>
                        <h6><strong>60.000₫</strong></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
