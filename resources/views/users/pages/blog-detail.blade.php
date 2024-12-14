@extends('users.layouts.layout')
@section('title', $post->tieude)

@section('content')
<div class="container py-5">
    <div class="blog-detail">
        <h1 class="text-center mb-4">{{ $post->tieude }}</h1>
        <div class="blog-meta text-center mb-4">
            <span class="me-3"><i class="fa fa-calendar-o"></i> {{ $post->created_at->format('d M, Y') }}</span>
            <span class="me-3"><i class="fa fa-eye"></i> {{ number_format($post->luotxem) }} lượt xem</span>
        </div>
        <div class="blog-thumbnail mb-4 text-center">
            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->tieude }}" class="img-fluid rounded">
        </div>
        <div class="blog-content">
            @if($post->slug == 'loi-ich-cua-rau-cu-organic')
            <h2>{{$post->title}}</h2>
            <p>{{$post->noidung}}</p>
                @elseif($post->slug == 'bi-quyet-bao-quan-thuc-pham-organic')
                <h2>{{$post->title}}</h2>
                <p>{{$post->noidung}}</p>
                @elseif($post->slug == 'cach-chon-trai-cay-tuoi-ngon')
                <h2>{{$post->title}}</h2>
                <p>{{$post->noidung}}</p>
                @elseif($post->slug == 'cong-thuc-mon-an-tu-thuc-pham-organic')
                <h2>{{$post->title}}</h2>
                <p>{{$post->noidung}}</p>        
            @endif
        </div>
    </div>
</div>
@endsection
