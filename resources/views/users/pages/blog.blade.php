@extends('users.layouts.layout')

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on('submit', '.search-form', function (e) {
    e.preventDefault();

    let form = $(this);
    let url = form.attr('action');
    let data = form.serialize();

    $.ajax({
        url: url,
        type: 'GET',
        data: data,
        success: function (response) {
            $('.blog-list').html(response.posts); // Cập nhật danh sách bài viết
            $('.pagination-container').html(response.pagination); // Cập nhật phân trang
        },
        error: function () {
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        }
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
                    

                    <!-- Danh sách bài viết -->
                    @include('users.partials.blog.blog-item', ['posts' => $posts])



                </div>
            </div>



        </div>
    </div>
</section>
<!-- Blog Section End -->
@endsection
