<div class="shoping__checkout">
    <h5>Cart Total</h5>
    <ul>
        <li>Subtotal <span id="subtotal">{{ number_format($total, 2) }} VNĐ</span></li>
        <li>Total <span id="total">{{ number_format($total, 2) }} VNĐ</span></li>
    </ul>
    <a href="{{ route('checkout') }}" class="primary-btn">PROCEED TO CHECKOUT</a>
</div>
