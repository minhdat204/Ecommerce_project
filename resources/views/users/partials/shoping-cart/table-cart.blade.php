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
    @foreach ($cartItems as $cartItem)
        <tr>
            <td class="shoping__cart__item">
                <!-- Hình ảnh sản phẩm -->
                <img src="{{ asset('img/cart/cart-1.jpg') }}" alt="{{ $cartItem->product->tensanpham }}">
                <h5>{{ $cartItem->product->tensanpham }}</h5>
            </td>
            <td class="shoping__cart__price">
                <!-- Giá sản phẩm -->
                <span>{{ number_format($cartItem->product->gia, 0, ',', '.') }} VND</span>
            </td>
            <td class="shoping__cart__quantity">
                <div class="quantity">
                    <!-- Form cập nhật số lượng -->
                    <form action="{{ route('cart.update', $cartItem->id_sp_giohang) }}" method="POST" class="cart-update-form">
                        @csrf
                        @method('PATCH')
                        <div class="pro-qty">
                            <input type="number" name="quantity" value="{{ $cartItem->soluong }}" min="1" class="quantity-input" data-id="{{ $cartItem->id_sp_giohang }}">
                        </div>
                    </form>
                </div>
            </td>
            <td class="shoping__cart__total">
                <!-- Tính tổng tiền của sản phẩm -->
                <span class="product-price-total">{{ number_format($cartItem->product->gia * $cartItem->soluong, 0, ',', '.') }} VND</span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

