<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | IT BARBER STORE</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;700&family=Oswald:wght@400;600&family=Montserrat:wght@300;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --gold: #ffcc00;
            --dark: #0a0a0a;
            --gray-inner: #151515;
            --text-muted: #888;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: var(--dark);
            color: #fff;
            font-family: 'Chakra Petch', sans-serif;
            overflow-x: hidden;
        }

        /* --- Floating Cart Icon --- */
        .cart-floating-btn {
            position: fixed;
            top: 25px;
            right: 30px;
            background: var(--gold);
            color: #000;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(255, 204, 0, 0.4);
            transition: var(--transition);
            text-decoration: none !important;
        }

        .cart-floating-btn:hover {
            transform: scale(1.1) rotate(-5deg);
            background: #fff;
            color: #000;
        }

        .cart-count-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #ff3e3e;
            color: #fff;
            font-size: 0.75rem;
            padding: 2px 7px;
            border-radius: 50%;
            border: 2px solid var(--dark);
            font-weight: 700;
        }

        /* --- Success Toast Alert --- */
        .custom-alert {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            background: #28a745;
            color: white;
            padding: 16px 28px;
            border-radius: 8px;
            display: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            font-weight: 500;
            border-left: 5px solid #1e7e34;
        }

        /* Path Navigation */
        .shop-nav-path {
            padding: 30px 0 15px;
            font-size: 0.7rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .shop-nav-path a {
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition);
        }

        .shop-nav-path a:hover {
            color: var(--gold);
        }

        .shop-nav-path span {
            color: #fff;
            margin-left: 8px;
            font-weight: 400;
            opacity: 0.6;
        }

        /* Gallery Section */
        .gallery-container {
            position: sticky;
            top: 30px;
        }

        .main-image-box {
            background: #fff;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            aspect-ratio: 1/1;
        }

        .main-image-box img {
            width: 90%;
            height: 90%;
            object-fit: contain;
            transition: transform 0.6s ease;
        }

        .main-image-box:hover img {
            transform: scale(1.1);
        }

        .thumb-group {
            display: flex;
            gap: 10px;
            justify-content: start;
        }

        .thumb-box {
            width: 70px;
            height: 70px;
            border: 1px solid #333;
            background: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .thumb-box img {
            width: 85%;
            height: 85%;
            object-fit: contain;
            opacity: 0.6;
        }

        .thumb-box.active {
            border: 2px solid var(--gold);
        }

        .thumb-box.active img {
            opacity: 1;
        }

        /* Detail Section */
        .detail-card {
            padding-left: 40px;
        }

        .brand-badge {
            color: var(--gold);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            display: block;
            margin-bottom: 10px;
        }

        .product-name {
            font-family: 'Oswald';
            font-size: 2.8rem;
            font-weight: 600;
            line-height: 1.1;
            text-transform: uppercase;
            margin-bottom: 15px;
            color: #fff;
        }

        .sku-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .price-tag {
            font-family: 'Montserrat';
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 30px;
            border-bottom: 1px solid #222;
            padding-bottom: 20px;
        }

        .section-label {
            font-size: 0.75rem;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            display: block;
        }

        .description-box {
            font-size: 0.95rem;
            color: #aaa;
            line-height: 1.8;
            margin-bottom: 40px;
        }

        /* Action Buttons */
        .qty-control {
            display: flex;
            align-items: center;
            background: #000;
            border: 1px solid #333;
            width: fit-content;
            margin-bottom: 30px;
        }

        .qty-btn {
            background: transparent;
            border: none;
            color: #fff;
            width: 45px;
            height: 45px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .qty-btn:hover {
            background: #1a1a1a;
        }

        .qty-input {
            background: transparent;
            border: none;
            color: #fff;
            width: 60px;
            text-align: center;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .btn-buy-now {
            background: var(--gold);
            color: #000;
            border: none;
            width: 100%;
            padding: 20px;
            font-weight: 800;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: var(--transition);
        }

        .btn-buy-now:hover {
            background: #fff;
            transform: translateY(-3px);
        }

        .trust-list {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .trust-item {
            font-size: 0.8rem;
            color: #888;
            display: flex;
            align-items: center;
        }

        .trust-item i {
            color: var(--gold);
            margin-right: 12px;
            font-size: 1rem;
            width: 20px;
        }

        @media (max-width: 991px) {
            .detail-card {
                padding-left: 0;
                margin-top: 40px;
            }
            .product-name {
                font-size: 2rem;
            }
            .gallery-container {
                position: relative;
                top: 0;
            }
        }
    </style>
</head>

<body>

    <a href="{{ route('cart.index') }}" class="cart-floating-btn">
        <i class="fas fa-shopping-basket"></i>
        @php $cartCount = count(session('cart', [])); @endphp
        @if($cartCount > 0)
            <span class="cart-count-badge">{{ $cartCount }}</span>
        @endif
    </a>

    @if(session('added_to_cart'))
        <div id="cartAlert" class="custom-alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('added_to_cart') }}
        </div>
    @endif

    <div class="container mb-5">
        {{-- Navigation Path --}}
        <nav class="shop-nav-path">
            <a href="{{ route('shop.index') }}">HOME</a> /
            <a href="#">{{ $product->cat ?? 'EQUIPMENT' }}</a> /
            <span>{{ $product->name }}</span>
        </nav>

        <div class="row">
            {{-- Left: Image Gallery --}}
            <div class="col-lg-7">
                <div class="gallery-container">
                    <div class="main-image-box">
                        <img id="mainImage"
                            src="{{ str_starts_with($product->img, 'http') ? $product->img : asset('storage/' . $product->img) }}"
                            alt="{{ $product->name }}">
                    </div>

                    <div class="thumb-group">
                        <div class="thumb-box active"
                            onclick="updateImage('{{ str_starts_with($product->img, 'http') ? $product->img : asset('storage/' . $product->img) }}', this)">
                            <img src="{{ str_starts_with($product->img, 'http') ? $product->img : asset('storage/' . $product->img) }}">
                        </div>
                        @if (isset($product->img2) && $product->img2)
                            <div class="thumb-box"
                                onclick="updateImage('{{ str_starts_with($product->img2, 'http') ? $product->img2 : asset('storage/' . $product->img2) }}', this)">
                                <img src="{{ str_starts_with($product->img2, 'http') ? $product->img2 : asset('storage/' . $product->img2) }}">
                            </div>
                        @endif
                        @if (isset($product->img3) && $product->img3)
                            <div class="thumb-box"
                                onclick="updateImage('{{ str_starts_with($product->img3, 'http') ? $product->img3 : asset('storage/' . $product->img3) }}', this)">
                                <img src="{{ str_starts_with($product->img3, 'http') ? $product->img3 : asset('storage/' . $product->img3) }}">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: Product Info --}}
            <div class="col-lg-5">
                <div class="detail-card">
                    <span class="brand-badge">{{ $product->brand ?? 'IT BARBER EXCLUSIVE' }}</span>
                    <h1 class="product-name">{{ $product->name }}</h1>
                    <div class="sku-text">SKU: ITB-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }} | STATUS: พร้อมส่ง</div>

                    <div class="price-tag">฿{{ number_format($product->price) }} THB</div>

                    <span class="section-label">Description</span>
                    <div class="description-box">
                        {{ $product->description ?? 'ยกระดับการทำงานของคุณด้วยอุปกรณ์คุณภาพระดับพรีเมียม ดีไซน์เน้นการใช้งานจริงและทนทาน ผ่านการทดสอบจากช่างมืออาชีพ' }}
                    </div>

                    <form action="{{ route('cart.store', $product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <span class="section-label">Quantity</span>
                        <div class="qty-control">
                            <button type="button" class="qty-btn" onclick="changeQty(-1)"><i class="fas fa-minus"></i></button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" class="qty-input" readonly>
                            <button type="button" class="qty-btn" onclick="changeQty(1)"><i class="fas fa-plus"></i></button>
                        </div>

                        <button type="submit" class="btn-buy-now">เพิ่มใส่ตะกร้า</button>
                    </form>

                    <div class="trust-list">
                        <div class="trust-item"><i class="fas fa-check-circle"></i> รับประกันสินค้าของแท้ 100%</div>
                        <div class="trust-item"><i class="fas fa-truck-moving"></i> จัดส่งฟรีเมื่อสั่งซื้อครบ 2,000.-</div>
                        <div class="trust-item"><i class="fas fa-sync-alt"></i> เปลี่ยนคืนสินค้าได้ภายใน 7 วัน</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-5 text-center mt-5" style="background: #050505;">
        <p class="small text-muted mb-0">© 2026 IT BARBER STORE — QUALITY NEVER COMPROMISED</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // ระบบแจ้งเตือน Auto-hide
            if ($('#cartAlert').length) {
                $('#cartAlert').fadeIn(500).delay(3000).fadeOut(500);
            }
        });

        function updateImage(src, element) {
            $('#mainImage').fadeOut(200, function() {
                $(this).attr('src', src).fadeIn(200);
            });
            $('.thumb-box').removeClass('active');
            $(element).addClass('active');
        }

        function changeQty(amt) {
            let qty = $('#quantity');
            let val = parseInt(qty.val()) + amt;
            if (val >= 1) qty.val(val);
        }
    </script>
</body>

</html>
