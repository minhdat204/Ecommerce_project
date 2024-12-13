@extends('users.layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/aboutUs.css') }}">
@endpush

@section('content')
<!-- Phần Giới Thiệu Bắt Đầu -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <!-- Hình Ảnh -->
            <div class="col-lg-6 col-md-12 mb-4 mb-lg-0 text-center">
                <img src="/img/categories/cat-3.jpg" alt="Giới Thiệu" class="img-fluid rounded shadow-lg">
            </div>
            <!-- Nội Dung Giới Thiệu -->
            <div class="col-lg-6 col-md-12">
                <h1 class="mb-4 text-success">Giới Thiệu</h1>
                <p class="mb-3"><strong>Địa chỉ:</strong> 65 Đ. Huỳnh Thúc Kháng, Bến Nghé, Quận 1, Hồ Chí Minh, Việt Nam.</p>
                <p class="mb-3">Organi là một cửa hàng trực tuyến chuyên cung cấp các sản phẩm hữu cơ bao gồm trái cây, rau củ và thịt, đảm bảo tiêu chuẩn chất lượng cao nhất.</p>
                <p class="mb-4">Chúng tôi cam kết mang đến sự hài lòng cho khách hàng thông qua các chính sách rõ ràng:</p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fa fa-check-circle text-success mr-2"></i><strong>Đảm bảo chất lượng:</strong> Tất cả sản phẩm đều được chứng nhận hữu cơ và kiểm tra nghiêm ngặt.</li>
                    <li class="mb-2"><i class="fa fa-check-circle text-success mr-2"></i><strong>Đóng gói thân thiện môi trường:</strong> Sử dụng vật liệu phân hủy sinh học để giảm tác động đến môi trường.</li>
                    <li><i class="fa fa-check-circle text-success mr-2"></i><strong>Chính sách đổi trả linh hoạt:</strong> Giúp khách hàng an tâm khi mua sắm.</li>
                </ul>
                <p>Chúng tôi tự hào hỗ trợ các hoạt động bền vững và cung cấp những sản phẩm hữu cơ chất lượng cao đến khách hàng.</p>
            </div>
        </div>
    </div>
</section>
<!-- Phần Giới Thiệu Kết Thúc -->
@endsection
