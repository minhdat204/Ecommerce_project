<!-- filepath: /resources/views/users/pages/favorites.blade.php -->
<div class="favorites__table">
    <table>
        <thead>
            <tr>
                <th class="favorite__product">Products</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($favorites as $favorite)
            <tr id="favorite-item-{{ $favorite->id_yeuthich }}">
                <td class="favorite__item" onclick="window.location='{{ route('users.shop_details', $favorite->product->slug) }}'" style="cursor: pointer;">
                    <div class="img-cart-favorites">
                        <img src="{{ asset('storage/' . ($favorite->product->images->isNotEmpty() ? $favorite->product->images->first()->duongdan : 'img/products/default.jpg')) }}" alt="{{ $favorite->product->tensanpham }}" width="100">
                    </div>
                    <h5>{{ $favorite->product->tensanpham }}</h5>
                </td>
                <td class="favorite__price">
                    @if($favorite->product->gia_khuyen_mai != 0)
                        {{ number_format($favorite->product->gia_khuyen_mai) }}đ
                        <span>{{ number_format($favorite->product->gia) }}đ</span>
                    @else
                        {{ number_format($favorite->product->gia) }}đ
                    @endif
                </td>
                <td class="favorite__status">
                    @if($favorite->product->soluong > 0)
                        <span class="in-stock">In Stock</span>
                    @else
                        <span class="out-stock">Out of Stock</span>
                    @endif
                </td>
                <td>
                    <div class="action-icons">
                        <a href="javascript:void(0)"
                            onclick="quickAddToCart({{ $favorite->product->id_sanpham }})"
                            class="action-icon {{ $favorite->product->soluong > 0 ? '' : 'disabled' }}">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </div>
                </td>
                <td>
                    <span class="icon_close" onclick="removeFavorite({{ $favorite->id_yeuthich }})"></span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center range-cart-favorites">Your favorites list is empty</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
