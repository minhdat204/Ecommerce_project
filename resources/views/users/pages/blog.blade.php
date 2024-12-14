{{-- users/pages/blog.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Blog</h1>
        
        {{-- Hiển thị danh sách bài viết --}}
        <div class="row">
            @foreach ($posts as $post)
                @include('users.partials.blog.blog-item', ['post' => $post])
            @endforeach
        </div>

        {{-- Hiển thị phân trang --}}
        <div class="d-flex justify-content-center">
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
