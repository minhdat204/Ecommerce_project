@extends('users.layouts.layout')

@section('content')
    <h2>Kết quả tìm kiếm</h2>

    <div class="search-results">
        @if($products->isEmpty())
            <p>Không có sản phẩm nào phù hợp với tiêu chí tìm kiếm.</p>
        @else
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4">
                        <div class="product-card">
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->tensanpham }}">
                            <h3>{{ $product->tensanpham }}</h3>
                            <p>{{ number_format($product->gia, 0, ',', '.') }} VND</p>
                            <a href="{{ route('users.shop_details', $product->slug) }}" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
