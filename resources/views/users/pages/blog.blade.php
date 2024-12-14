@extends('users.layouts.layout')

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Khi người dùng submit form tìm kiếm
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();  // Ngừng hành động mặc định của form (tải lại trang)

            var keyword = $('#searchInput').val();  // Lấy từ khóa tìm kiếm

            $.ajax({
                url: '{{ route('users.blogs') }}',  // Địa chỉ gửi yêu cầu đến
                method: 'GET',
                data: {
                    keyword: keyword,  // Gửi từ khóa tìm kiếm
                    page: 1  // Thêm tham số page để luôn bắt đầu từ trang 1
                },
                success: function(response) {
                    // Cập nhật lại danh sách bài viết
                    $('#blogItems').html(response.blogs);
                    // Cập nhật lại phân trang
                    $('#pagination').html(response.pagination);
                }
            });
        });

        // Xử lý khi nhấn vào phân trang (AJAX pagination)
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();  // Ngừng hành động mặc định của phân trang

            var page = $(this).attr('href').split('page=')[1];  // Lấy số trang từ URL

            $.ajax({
                url: '{{ route('users.blogs') }}',
                method: 'GET',
                data: {
                    keyword: $('#searchInput').val(),  // Lấy từ khóa tìm kiếm
                    page: page  // Gửi số trang
                },
                success: function(response) {
                    // Cập nhật lại danh sách bài viết
                    $('#blogItems').html(response.blogs);
                    // Cập nhật lại phân trang
                    $('#pagination').html(response.pagination);
                }
            });
        });
    });
</script>
@endpush

@section('content')
<!-- Blog Section Begin -->
<section class="blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="blog__sidebar">
                    <!-- Thanh tìm kiếm -->
                    <div class="blog__sidebar__item">
                        @include('users.partials.blog.search-blog')
                    </div>

                    <!-- Bài viết gần đây -->
                    <div class="blog__sidebar__item">
                        @include('users.partials.blog.recent-news')
                    </div>

                    <!-- Thẻ tìm kiếm -->
                    <div class="blog__sidebar__item">
                        <h4>Search By</h4>
                        <div class="blog__sidebar__item__tags">
                            <a href="#">Apple</a>
                            <a href="#">Beauty</a>
                            <a href="#">Vegetables</a>
                            <a href="#">Fruit</a>
                            <a href="#">Healthy Food</a>
                            <a href="#">Lifestyle</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách bài viết -->
            <div class="col-lg-8 col-md-7">
                <div class="row">
                    @include('users.partials.blog.blog-about-us')
                    @include('users.partials.blog.blog-item')
                    <!-- Phân trang -->
                <div class="col-lg-12 pagination-container">
                    <div class="product__pagination blog__pagination" id="pagination">
                            {{ $posts->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->
@endsection
