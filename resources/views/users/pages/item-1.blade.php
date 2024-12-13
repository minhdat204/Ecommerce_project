@extends('users.layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endpush

@section('content')
<!-- Phần Chi Tiết Sản Phẩm Bắt Đầu -->
<section class="py-5 bg-light">
    <div class="container-item-1">
        <h2 class="mb-3 text-success text-center font-weight-bold">Lý Do Nên Chọn Sản Phẩm Của Ogani</h2>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <p class="mb-4 text-center">Tại Ogani, chúng tôi tự hào cung cấp thực phẩm hữu cơ chất lượng cao, đáp ứng nhu cầu của khách hàng và góp phần bảo vệ sức khỏe cộng đồng. Dưới đây là những lý do khiến bạn nên chọn sản phẩm của chúng tôi:</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="fa fa-check-circle mr-2"></i>Chất lượng vượt trội</h5>
                        <p class="card-text">Tất cả sản phẩm đều được chứng nhận hữu cơ, đảm bảo không chứa hóa chất độc hại, thuốc trừ sâu hay phân bón hóa học. Điều này giúp bảo vệ sức khỏe của bạn và gia đình, đồng thời mang lại hương vị tự nhiên và tươi ngon cho từng món ăn.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="fa fa-check-circle mr-2"></i>Thân thiện với môi trường</h5>
                        <p class="card-text">Sản phẩm của Ogani được sản xuất bằng các phương pháp bền vững, giảm thiểu tác động đến hệ sinh thái thông qua việc sử dụng nguyên liệu tái chế và quy trình sản xuất thân thiện với tự nhiên.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="fa fa-check-circle mr-2"></i>Hỗ trợ cộng đồng</h5>
                        <p class="card-text">Mua sắm tại Ogani không chỉ giúp bạn có những sản phẩm chất lượng mà còn hỗ trợ nông dân địa phương. Chúng tôi hợp tác với các trang trại hữu cơ và cộng đồng nông dân, giúp họ phát triển và cải thiện sinh kế.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="fa fa-check-circle mr-2"></i>Chính sách đổi trả linh hoạt</h5>
                        <p class="card-text">Nếu bạn không hài lòng với sản phẩm đã mua, chúng tôi cung cấp chính sách đổi trả trong vòng 7 ngày, giúp bạn yên tâm khi lựa chọn sản phẩm của chúng tôi.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="fa fa-check-circle mr-2"></i>Giá trị dinh dưỡng cao</h5>
                        <p class="card-text">Sản phẩm hữu cơ của Ogani không chỉ ngon mà còn giàu dinh dưỡng, giúp bạn và gia đình duy trì một lối sống khỏe mạnh.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="fa fa-check-circle mr-2"></i>Dịch vụ khách hàng tận tâm</h5>
                        <p class="card-text">Đội ngũ nhân viên của chúng tôi luôn sẵn sàng hỗ trợ bạn trong mọi thắc mắc và yêu cầu, lắng nghe phản hồi từ khách hàng để không ngừng cải thiện chất lượng dịch vụ và sản phẩm.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p class="text-center mt-4">Hãy trải nghiệm sự khác biệt với sản phẩm hữu cơ từ Ogani ngay hôm nay! Chúng tôi không chỉ cung cấp thực phẩm, mà còn một lối sống khỏe mạnh và bền vững cho bạn và gia đình.</p>
            </div>
        </div>
    </div>
</section>
@endsection
