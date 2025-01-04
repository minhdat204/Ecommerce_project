<div class="shoping__checkout">
    <h5>Cart Total</h5>
    <ul>
        <li>Tổng tiền hàng <span id="subtotal">${{ number_format($total, 2) }}</span></li>
        <li>Phí vận chuyển <span id="totalShip">${{ number_format($totalShip, 2) }}</span></li>

        <li>Tổng thanh toán <span id="total">${{ number_format($total * $totalShip, 2) }}</span></li>
    </ul>
    <a href="{{ route('checkout.index') }}" class="primary-btn">Tiến hành thành toán</a>
</div>
