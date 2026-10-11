<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart | IT BARBER STORE</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;700&family=Oswald:wght@500;600&family=Montserrat:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --gold: #ffcc00;
            --dark: #0a0a0a;
            --gray-card: #121212;
            --border-color: #222;
            --text-muted: #888;
        }

        body {
            background-color: var(--dark);
            color: #fff;
            font-family: 'Chakra Petch', sans-serif;
            overflow-x: hidden;
        }

        .cart-nav-path {
            padding: 30px 0;
            font-size: 0.7rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .cart-nav-path a {
            color: var(--text-muted);
            text-decoration: none;
        }

        .cart-nav-path span {
            color: var(--gold);
            margin-left: 8px;
            font-weight: 700;
        }

        .cart-title {
            font-family: 'Oswald';
            font-size: 2.5rem;
            text-transform: uppercase;
            margin-bottom: 40px;
            border-left: 5px solid var(--gold);
            padding-left: 20px;
        }

        .cart-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .cart-table thead th {
            border: none;
            color: var(--text-muted);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 10px 20px;
        }

        .cart-item-row {
            background: var(--gray-card);
            transition: 0.3s;
        }

        .cart-item-row:hover {
            background: #1a1a1a;
        }

        .product-cell {
            display: flex;
            align-items: center;
            padding: 20px;
            border-radius: 8px 0 0 8px;
        }

        .img-box {
            width: 90px;
            height: 90px;
            background: #fff;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            overflow: hidden;
        }

        .img-box img {
            width: 85%;
            height: 85%;
            object-fit: contain;
        }

        .p-name {
            font-family: 'Oswald';
            font-size: 1.1rem;
            text-transform: uppercase;
            color: #fff;
            margin-bottom: 2px;
        }

        .p-cat {
            font-size: 0.65rem;
            color: var(--gold);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .qty-control {
            display: flex;
            align-items: center;
            background: #000;
            border: 1px solid #333;
            width: fit-content;
        }

        .qty-btn {
            background: transparent;
            border: none;
            color: #fff;
            width: 35px;
            height: 35px;
            cursor: pointer;
            transition: 0.2s;
            outline: none !important;
        }

        .qty-btn:hover {
            background: var(--gold);
            color: #000;
        }

        .qty-input {
            background: transparent;
            border: none;
            color: #fff;
            width: 40px;
            text-align: center;
            font-weight: 700;
        }

        .summary-box {
            background: var(--gray-card);
            padding: 35px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            position: sticky;
            top: 100px;
        }

        .summary-title {
            font-family: 'Oswald';
            font-size: 1.4rem;
            text-transform: uppercase;
            margin-bottom: 25px;
            border-bottom: 1px solid #222;
            padding-bottom: 15px;
            letter-spacing: 1px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 18px;
            font-size: 0.9rem;
            color: #bbb;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #222;
            color: var(--gold);
            font-family: 'Montserrat';
            font-size: 1.6rem;
            font-weight: 700;
        }

        .btn-checkout {
            background: var(--gold);
            color: #000;
            border: none;
            width: 100%;
            padding: 20px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 1rem;
            transition: 0.3s;
            margin-top: 30px;
            cursor: pointer;
            display: block;
            text-align: center;
            text-decoration: none !important;
        }

        .btn-checkout:hover {
            background: #fff;
            color: #000;
            transform: translateY(-3px);
        }

        .remove-link {
            color: #ff4444;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            margin-top: 8px;
            display: inline-block;
            opacity: 0.6;
            transition: 0.3s;
            cursor: pointer;
        }

        .remove-link:hover {
            opacity: 1;
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container mb-5">
        <nav class="cart-nav-path">
            <a href="{{ route('shop.index') }}">STORE</a> / <span>SHOPPING CART</span>
        </nav>

        <h1 class="cart-title">Your Bag</h1>

        <div class="row">
            <div class="col-lg-8">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product Details</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @forelse($cart as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <tr class="cart-item-row" data-id="{{ $id }}"
                                data-price="{{ $details['price'] }}">
                                <td class="product-cell">
                                    <div class="img-box">
                                        <img
                                            src="{{ str_starts_with($details['img'], 'http') ? $details['img'] : asset('storage/' . $details['img']) }}">
                                    </div>
                                    <div class="product-info">
                                        <div class="p-cat">Authentic Gear</div>
                                        <div class="p-name">{{ $details['name'] }}</div>

                                        <a href="javascript:void(0)" class="remove-link remove-from-cart"
                                            data-id="{{ $id }}">
                                            <i class="fas fa-times mr-1"></i> Remove Item
                                        </a>
                                    </div>
                                </td>
                                <td class="align-middle">฿{{ number_format($details['price']) }}</td>
                                <td class="align-middle">
                                    <div class="qty-control">
                                        <button class="qty-btn btn-minus"><i class="fas fa-minus fa-xs"></i></button>
                                        <input type="text" value="{{ $details['quantity'] }}" class="qty-input"
                                            readonly>
                                        <button class="qty-btn btn-plus"><i class="fas fa-plus fa-xs"></i></button>
                                    </div>
                                </td>
                                <td class="align-middle text-right font-weight-bold text-white pr-4 row-total">
                                    ฿{{ number_format($details['price'] * $details['quantity']) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="fas fa-shopping-basket fa-3x mb-3" style="opacity: 0.2;"></i>
                                    <p class="text-muted">ตะกร้าของคุณยังว่างเปล่า</p>
                                    <a href="{{ route('shop.index') }}"
                                        class="btn btn-outline-warning mt-3">เลือกดูสินค้า</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <a href="{{ route('shop.index') }}" class="text-muted small text-decoration-none mt-4 d-inline-block">
                    <i class="fas fa-chevron-left mr-2"></i> BACK TO SHOPPING
                </a>
            </div>

            <div class="col-lg-4">
                <div class="summary-box">
                    <h2 class="summary-title">Order Summary</h2>
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span class="text-white" id="subtotal">฿{{ number_format($total) }}.00</span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping Fee</span>
                        <span class="text-success">FREE</span>
                    </div>
                    <div class="summary-total">
                        <span>TOTAL</span>
                        <span id="grand-total">฿{{ number_format($total) }}.00</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn-checkout">Checkout Now</a>

                    <div class="mt-4 pt-4 border-top border-dark">
                        <p class="small text-muted mb-3"><i class="fas fa-lock mr-2"></i> Secure SSL Encryption</p>
                        <div class="d-flex gap-2 opacity-50">
                            <i class="fab fa-cc-visa fa-2x mr-2"></i>
                            <i class="fab fa-cc-mastercard fa-2x mr-2"></i>
                            <i class="fab fa-cc-apple-pay fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // --- 1. ฟังก์ชันส่งค่าไปอัปเดต Session ที่ Server (เพิ่มใหม่) ---
            function updateCartSession(id, qty) {
                $.ajax({
                    url: '{{ route('cart.update') }}', // ตรวจสอบว่ามี route นี้ใน web.php หรือยัง
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        quantity: qty
                    },
                    success: function(response) {
                        console.log("Session updated successfully");
                    },
                    error: function(xhr) {
                        console.error("Error updating session:", xhr.responseText);
                    }
                });
            }

            // --- 2. ฟังก์ชันคำนวณราคาทั้งหมดบนหน้าจอ (UI Only) ---
            function updateAllTotals() {
                let grandTotal = 0;
                let itemCount = 0;

                $('.cart-item-row').each(function() {
                    let price = parseFloat($(this).data('price'));
                    let qty = parseInt($(this).find('.qty-input').val());
                    let rowTotal = price * qty;
                    $(this).find('.row-total').text('฿' + rowTotal.toLocaleString());
                    grandTotal += rowTotal;
                    itemCount++;
                });

                $('#subtotal').text('฿' + grandTotal.toLocaleString() + '.00');
                $('#grand-total').text('฿' + grandTotal.toLocaleString() + '.00');

                if (itemCount === 0) {
                    location.reload();
                }
            }

            // --- 3. ปุ่มเพิ่มจำนวน (+) ---
            $('.btn-plus').click(function() {
                let row = $(this).closest('.cart-item-row');
                let productId = row.data('id');
                let input = $(this).siblings('.qty-input');
                let newQty = parseInt(input.val()) + 1;

                input.val(newQty); // อัปเดตตัวเลขในช่อง input
                updateAllTotals(); // อัปเดตยอดรวมบนหน้าจอ
                updateCartSession(productId, newQty); // ส่งไปบันทึกที่ Server (Session)
            });

            // --- 4. ปุ่มลดจำนวน (-) ---
            $('.btn-minus').click(function() {
                let row = $(this).closest('.cart-item-row');
                let productId = row.data('id');
                let input = $(this).siblings('.qty-input');
                let val = parseInt(input.val());

                if (val > 1) {
                    let newQty = val - 1;
                    input.val(newQty); // อัปเดตตัวเลขในช่อง input
                    updateAllTotals(); // อัปเดตยอดรวมบนหน้าจอ
                    updateCartSession(productId, newQty); // ส่งไปบันทึกที่ Server (Session)
                }
            });

            // --- 5. ปุ่มลบสินค้าออกจากตะกร้า ---
            $('.remove-from-cart').click(function(e) {
                e.preventDefault();
                let ele = $(this);
                let productId = ele.data('id');

                if (confirm('คุณต้องการลบสินค้านี้ออกจากตะกร้าใช่หรือไม่?')) {
                    $.ajax({
                        url: '{{ route('cart.remove') }}',
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: productId
                        },
                        success: function(response) {
                            ele.closest('.cart-item-row').fadeOut(300, function() {
                                $(this).remove();
                                updateAllTotals();
                            });
                        }
                    });
                }
            });
        });
    </script>

</body>

