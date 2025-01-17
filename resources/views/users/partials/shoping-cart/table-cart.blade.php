
<table>
    <thead>
        <tr>
            <th class="shoping__product">Products</th>
            <th>Status</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($cartItems as $item)
        <tr data-id="{{ $item->id_sp_giohang }}" id="cart-item-{{ $item->id_sp_giohang }}" class="{{ $item->product->soluong < $item->soluong ? 'check' : '' }}">
            <td class="shoping__cart__item" onclick="window.location='{{ route('users.shop_details', $item->product->slug) }}'" style="cursor: pointer;">
                <div class="img-cart-favorites">
                    <img src="{{ asset('storage/' . ($item->product->images->isNotEmpty() ? $item->product->images->first()->duongdan : 'img/products/default.jpg')) }}" alt="{{ $item->product->tensanpham }}" width="100">
                </div>
                <h5>{{ $item->product->tensanpham }}</h5>
            </td>
            <td class="item__status">
                @if($item->product->soluong > 0)
                    <span class="in-stock">In Stock ({{ $item->product->soluong }})</span>
                @else
                    <span class="out-stock">Out of Stock</span>
                @endif
            </td>
            <td class="shoping__cart__price">
                @if ($item->product->gia_khuyen_mai !== null && $item->product->gia_khuyen_mai >= 0)
                    {{ number_format($item->product->gia_khuyen_mai, 0, ',', '.') }}đ
                    <span class="text-decoration-line-through text-muted">{{ number_format($item->product->gia, 0, ',', '.') }}đ</span>
                @else
                    {{ number_format($item->product->gia, 0, ',', '.') }}đ
                @endif
            </td>

            <td class="shoping__cart__quantity">
                <div class="quantity">
                    @if ($item->product->soluong < $item->soluong)
                        <div class="text-danger checkQuantity">Only {{ $item->product->soluong }} left</div>
                    @endif
                    <div class="pro-qty">
                        <span class="dec qtybtn">-</span>
                        <input
                            value="{{ $item->soluong }}"
                            min="1"
                            class="quantity-input"
                            data-id="{{ $item->id_sp_giohang }}"
                            data-original-value="{{ $item->soluong }}"
                            onchange="handleQuantityChange(this, {{ $item->product->soluong }})"
                            >
                        <span class="inc qtybtn">+</span>
                    </div>
                </div>
            </td>
            <td class="shoping__cart__total">
                @if ($item->product->gia_khuyen_mai !== null && $item->product->gia_khuyen_mai >= 0)
                    {{ number_format($item->product->gia_khuyen_mai * $item->soluong, 0, ',', '.') }}đ
                @else
                    {{ number_format($item->product->gia * $item->soluong, 0, ',', '.') }}đ
                @endif
            </td>
            <td class="shoping__cart__item__close">
                <span class="icon_close" onclick="removeItem({{ $item->id_sp_giohang }})"></span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center range-cart-favorites">Your cart is empty</td>
        </tr>
        @endforelse
    </tbody>
</table>
<div class="mt-4" style="text-align: center">
    @include('users.components.pagination', ['paginator' => $cartItems, 'customUrl' => route('cart.index')])
</div>



