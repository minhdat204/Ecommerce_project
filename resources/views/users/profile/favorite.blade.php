@extends('users.layouts.layout')
@section('title', 'Favorites')

@section('content')
<div class="favorites">
    <ul class="tabs">
        <li><a href="{{ route('profile.index') }}">Imformation</a></li>
        <li><a href="#">Order</a></li>
        <li class="active"><a href="#">Favorites</a></li>
        <li><a href="#">Ratings</a></li>
    </ul>
    <div class="favorite-list">
        @for ($i = 0; $i < 2; $i++)
            <div class="favorite-item">
                <div class="item-info">
                    <img src="#" alt="Image" class="item-image">
                    <div>
                        <h3>Bò Wagyu</h3>
                        <p>Thành tiền: 1.000.000đ</p>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="btn btn-redeem">Redeem again</button>
                    <button class="btn btn-contact">Contact Seller</button>
                </div>
            </div>
        @endfor
    </div>
    <div class="pagination">
        <button class="prev">« Previous</button>
        <button>1</button>
        <button class="active">2</button>
        <button>3</button>
        <button>4</button>
        <button class="next">Next »</button>
    </div>
</div>
@endsection
