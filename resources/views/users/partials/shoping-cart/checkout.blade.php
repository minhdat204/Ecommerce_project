<div class="shoping__checkout">
    <h5>Cart Total</h5>
    <ul>
        <li>Subtotal <span id="subtotal">{{ number_format($subTotal, 0, ',', '.') }}đ</span></li>
        <li>Shipping <span>Free</span></li>
        <li>Total <span id="total">{{ number_format($total, 0, ',', '.') }}đ
                {{ $discount ? '(-' . floor($discount) . '%)' : '' }}</span></li>
    </ul>
    <a href="{{ route('checkout.index') }}" class="primary-btn">PROCEED TO CHECKOUT</a>
</div>
