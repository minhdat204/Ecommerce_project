@extends('users.layouts.layout')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/blog.css')}}">
@endpush
@section('content')
<!-- Blog Section Begin -->
<section class="blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7">
                <div class="row">
                    <!-- Duyệt qua các bài viết blog -->
                    @foreach($blogs as $blog)
                        <div class="col-lg-6 col-md-6 col-sm-6 blog-item">
                            @include('users.partials.blog.blog-item', ['blog' => $blog])
                        </div>
                    @endforeach
                    
                    <!-- Phân trang -->
                    <div class="col-lg-12 pagination-container">
                        <div class="product__pagination blog__pagination">
                            <!-- Phân trang có thể được tùy chỉnh theo yêu cầu -->
                            {{ $blogs->links() }} <!-- Laravel sẽ tự động hiển thị phân trang -->
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4 col-md-5 d-flex flex-column">
                <div class="blog__sidebar flex-grow-1">
                    <div class="blog__sidebar__item">
                        @include('users.partials.blog.search-blog')
                        @include('users.partials.blog.recent-news')
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
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->
@endsection
