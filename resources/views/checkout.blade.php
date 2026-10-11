<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | IT BARBER STORE</title>

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
        }

        .checkout-title {
            font-family: 'Oswald';
            font-size: 2rem;
            text-transform: uppercase;
            margin: 40px 0;
            border-left: 5px solid var(--gold);
            padding-left: 20px;
        }

        .checkout-card {
            background: var(--gray-card);
            border: 1px solid var(--border-color);
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .card-h {
            font-family: 'Oswald';
            font-size: 1.2rem;
            color: var(--gold);
            margin-bottom: 20px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
        }

        .card-h i {
            margin-right: 10px;
        }

        .form-control {
            background: #000;
            border: 1px solid #333;
            color: #fff;
            border-radius: 0;
            padding: 25px 15px;
            height: auto;
        }

        .form-control:focus {
            background: #050505;
            border-color: var(--gold);
            color: #fff;
            box-shadow: none;
        }

        label {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #222;
        }

        .item-info img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
        }

        .total-box {
            background: #000;
            padding: 20px;
            margin-top: 20px;
            border: 1px dashed var(--gold);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 1.1rem;
        }

        .grand-total {
            font-family: 'Montserrat';
            font-size: 1.8rem;
            color: var(--gold);
            font-weight: 700;
        }

        .btn-confirm {
            background: var(--gold);
            color: #000;
            border: none;
            width: 100%;
            padding: 20px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 1.1rem;
            transition: 0.3s;
            margin-top: 20px;
            cursor: pointer;
        }

        .btn-confirm:hover {
            background: #fff;
            transform: translateY(-3px);
            text-decoration: none;
            color: #000;
        }

        .payment-option {
            border: 1px solid #333;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
        }

        .payment-option.active {
            border-color: var(--gold);
            background: #1a1a1a;
        }
    </style>
</head>

<body>

    <div class="container mb-5">
        <h1 class="checkout-title">Checkout</h1>

        <form action="{{ route('checkout.processPayment') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-7">
                    <div class="checkout-card">
                        <div class="card-h"><i class="fas fa-truck"></i> Shipping Information</div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>ชื่อ-นามสกุล</label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>เบอร์โทรศัพท์</label>
                                <input type="text" name="phone" class="form-control" placeholder="08X-XXX-XXXX"
                                    required>
                            </div>
                            <div class="col-12 mb-3">
                                <label>ที่อยู่การจัดส่ง</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="บ้านเลขที่, ถนน, ซอย..." required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>จังหวัด</label>
                                <input type="text" name="province" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>รหัสไปรษณีย์</label>
                                <input type="text" name="zipcode" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-card">
                        <div class="card-h"><i class="fas fa-credit-card"></i> Payment Method</div>
                        <div class="payment-option active">
                            <input type="radio" name="payment_method" value="bank_transfer" checked>
                            <span class="ml-2">โอนเงินผ่านธนาคาร (Bank Transfer)</span>
                        </div>
                        <div class="payment-option text-muted">
                            <input type="radio" name="payment_method" disabled>
                            <span class="ml-2">บัตรเครดิต (Coming Soon)</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="checkout-card sticky-top" style="top: 20px;">
                        <div class="mb-3 small text-muted">
                            <i class="far fa-clock mr-1"></i> เวลาทำรายการ: {{ now()->format('d/m/Y H:i') }} น.
                        </div>

                        @php $total = 0; @endphp
                        @if (isset($cart) && count($cart) > 0)
                            @foreach ($cart as $id => $details)
                                @php $total += $details['price'] * $details['quantity']; @endphp
                                <div class="order-item">
                                    <div class="item-info d-flex align-items-center">
                                        <img src="{{ str_starts_with($details['img'], 'http') ? $details['img'] : asset('storage/' . $details['img']) }}"
                                            alt="product">
                                        <div>
                                            <div class="small font-weight-bold">{{ $details['name'] }}</div>
                                            <div class="small text-muted">Qty: {{ $details['quantity'] }}</div>
                                        </div>
                                    </div>
                                    <div class="text-white small">
                                        ฿{{ number_format($details['price'] * $details['quantity']) }}</div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">ไม่มีสินค้าในตะกร้า</p>
                        @endif

                        <div class="mt-4">
                            <div class="total-row mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span>฿{{ number_format($total) }}</span>
                            </div>
                            <div class="total-row mb-2">
                                <span class="text-muted">Shipping</span>
                                <span class="text-success">FREE</span>
                            </div>
                            <div class="total-box">
                                <div class="total-row align-items-center">
                                    <span class="font-weight-bold">TOTAL</span>
                                    <span class="grand-total">฿{{ number_format($total) }}</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-confirm" {{ $total == 0 ? 'disabled' : '' }}>
                            ไปหน้าชำระเงิน <i class="fas fa-chevron-right ml-2"></i>
                        </button>

                        <p class="text-center mt-3 small text-muted">
                            <i class="fas fa-shield-alt mr-1"></i> Your data is protected by SSL
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>

</body>

</html>

