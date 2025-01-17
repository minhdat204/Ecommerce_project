@extends('users.layouts.layout')

@section('title', 'Giới thiệu')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endpush

@section('content')
<!-- Phần Giới Thiệu Bắt Đầu -->
<section class="py-5 bg-light">
    <div class="container-aboutUs">
        <div class="row align-items-center">
            <!-- Hình Ảnh -->
            <div class="col-lg-6 col-md-12 mb-4 mb-lg-0 text-center">
                <img src="/img/categories/cat-3.jpg" alt="Giới Thiệu" class="img-fluid rounded shadow-lg">
            </div>
            <!-- Nội Dung Giới Thiệu -->
            <div class="col-lg-6 col-md-12">
                <h2 class="mb-3 text-success text-center font-weight-bold">Giới Thiệu Về Organi</h2>
                <p class="mb-3"><strong>Địa chỉ:</strong> 65 Đ. Huỳnh Thúc Kháng, Bến Nghé, Quận 1, Hồ Chí Minh, Việt Nam.</p>
                <p class="mb-3"><strong>Lĩnh vực kinh doanh:</strong> Cửa hàng trực tuyến chuyên cung cấp thực phẩm hữu cơ, bao gồm trái cây, rau củ và thịt tươi sống.</p>
                <p class="mb-4">Tại Organi, chúng tôi cam kết mang đến sản phẩm chất lượng cao, an toàn cho sức khỏe và thân thiện với môi trường. Dưới đây là những chính sách mà chúng tôi thực hiện để đảm bảo sự hài lòng của khách hàng:</p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fa fa-check-circle text-success mr-2"></i><strong>Chính sách đảm bảo chất lượng:</strong> Tất cả sản phẩm đều được chứng nhận hữu cơ, kiểm tra chất lượng nghiêm ngặt để bảo vệ sức khỏe của bạn và gia đình.</li>
                    <li class="mb-2"><i class="fa fa-check-circle text-success mr-2"></i><strong>Chính sách đóng gói bền vững:</strong> Chúng tôi sử dụng vật liệu phân hủy sinh học, giảm thiểu tác động đến môi trường trong mỗi đơn hàng.</li>
                    <li><i class="fa fa-check-circle text-success mr-2"></i><strong>Chính sách đổi trả linh hoạt:</strong> Nếu bạn không hài lòng với sản phẩm, bạn có thể yêu cầu đổi trả trong vòng 7 ngày kể từ ngày nhận hàng, đảm bảo sự an tâm cho mỗi giao dịch.</li>
                </ul>
                <p>Chúng tôi mong muốn tạo ra một cộng đồng yêu thích thực phẩm sạch và bền vững. Hãy cùng Organi đồng hành trên hành trình hướng đến lối sống khỏe mạnh!</p>
            </div>
        </div>
    </div>
</section>
@endsection
