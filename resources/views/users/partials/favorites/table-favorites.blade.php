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
                <td class="favorite__item">
                    <img src="{{ asset($favorite->product->thumbnail) }}" alt="">
                    <h5>{{ $favorite->product->tensanpham }}</h5>
                </td>
                <td class="favorite__price">
                    @if($favorite->product->gia_khuyen_mai)
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
                    <button onclick="addToCart({{ $favorite->product->id_sanpham }})"
                            class="site-btn"
                            {{ $favorite->product->soluong > 0 ? '' : 'disabled' }}>
                        ADD TO CART
                    </button>
                </td>
                <td>
                    <span class="icon_close" onclick="removeFavorite({{ $favorite->id_yeuthich }})"></span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Your favorites list is empty</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
