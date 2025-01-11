<div class="shoping__cart__table">
    <table>
        <thead>
            <tr>
                <th class="shoping__product">Products</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($cartItems as $item)
            <tr data-id="{{ $item->id_sp_giohang }}" id="cart-item-{{ $item->id_sp_giohang }}">
                <td class="shoping__cart__item" onclick="window.location='{{ route('users.shop_details', $item->product->slug) }}'" style="cursor: pointer;">
                    <img src="{{ asset('storage/' . ($item->product->images->isNotEmpty() ? $item->product->images->first()->duongdan : 'img/products/default.jpg')) }}" alt="{{ $item->product->tensanpham }}" width="100">
                    <h5>{{ $item->product->tensanpham }}</h5>
                </td>
                <td class="shoping__cart__price">
                    @if ($item->product->gia_khuyen_mai != 0)
                        {{ number_format($item->product->gia_khuyen_mai, 0, ',', '.') }}đ
                    @else
                        {{ number_format($item->product->gia, 0, ',', '.') }}đ
                    @endif
                </td>
                <td class="shoping__cart__quantity">
                    <div class="quantity">
                        <div class="pro-qty">
                            <span class="dec qtybtn">-</span>
                            <input
                                value="{{ $item->soluong }}"
                                min="1"
                                max="{{ $item->product->soluong }}"
                                class="quantity-input"
                                data-id="{{ $item->id_sp_giohang }}"
                                data-original-value="{{ $item->soluong }}"
                                onchange="handleQuantityChange(this)"
                                >
                            <span class="inc qtybtn">+</span>
                        </div>
                    </div>
                </td>
                <td class="shoping__cart__total">
                    @if ($item->product->gia_khuyen_mai != 0)
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
                <td colspan="5" class="text-center">Your cart is empty</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

