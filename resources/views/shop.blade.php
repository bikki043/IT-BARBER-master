<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | IT BARBER</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;700&family=Oswald:wght@500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --gold: #ffcc00;
            --dark: #000;
            --gray-text: #888;
            --light-bg: #f9f9f9;
            --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        body {
            background-color: var(--dark);
            color: #fff;
            font-family: 'Chakra Petch', sans-serif;
            overflow-x: hidden;
        }

        /* --- Entrance Animation --- */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-entry {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        /* --- Floating Cart --- */
        .cart-floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--gold);
            color: #000;
            width: 65px;
            height: 65px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            z-index: 2000;
            box-shadow: 0 8px 25px rgba(255, 204, 0, 0.4);
            transition: var(--transition);
            text-decoration: none !important;
            border: none;
        }

        .cart-floating-btn:hover {
            transform: scale(1.1) rotate(-8deg);
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
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--dark);
            font-weight: 700;
        }

        /* --- Navbar --- */
        .navbar-custom {
            padding: 20px 50px;
            background: rgba(0, 0, 0, 0.95);
            border-bottom: 1px solid #111;
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .nav-logo {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 1px solid var(--gold);
        }

        .nav-menu a {
            color: #fff;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 2px;
            font-size: 0.85rem;
            margin: 0 20px;
            text-decoration: none;
            transition: 0.3s;
            position: relative;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            color: var(--gold);
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: 0.3s;
        }

        .nav-menu a:hover::after {
            width: 100%;
        }

        /* --- Sidebar --- */
        .filter-sidebar {
            border-right: 1px solid #111;
            padding-right: 25px;
            position: sticky;
            top: 120px;
            height: fit-content;
        }

        .filter-title {
            font-family: 'Oswald';
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--gold);
            margin-bottom: 20px;
        }

        .filter-list {
            list-style: none;
            padding: 0;
        }

        .filter-list a {
            color: var(--gray-text);
            font-size: 0.85rem;
            text-decoration: none;
            transition: var(--transition);
            display: block;
            margin-bottom: 12px;
        }

        .filter-list a:hover {
            color: #fff;
            transform: translateX(8px);
        }

        /* --- Product Card --- */
        .product-card {
            background: transparent;
            margin-bottom: 40px;
            position: relative;
        }

        .img-wrapper {
            background: var(--light-bg);
            position: relative;
            overflow: hidden;
            width: 100%;
            aspect-ratio: 1/1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .img-wrapper img {
            max-width: 85%;
            max-height: 85%;
            object-fit: contain;
            transition: 0.8s cubic-bezier(0.19, 1, 0.22, 1);
        }

        .cart-overlay {
            position: absolute;
            bottom: -65px;
            left: 0;
            width: 100%;
            background: var(--gold);
            padding: 15px;
            text-align: center;
            transition: var(--transition);
        }

        .product-card:hover .cart-overlay {
            bottom: 0;
        }

        .product-card:hover .img-wrapper img {
            transform: scale(1.1);
        }

        .btn-view {
            color: #000;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-decoration: none;
            display: block;
            width: 100%;
        }

        .product-content {
            padding: 18px 2px;
        }

        .brand-label {
            font-size: 0.6rem;
            color: var(--gold);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .p-name {
            font-family: 'Oswald';
            font-size: 1rem;
            color: #eee;
            margin: 6px 0;
            text-transform: uppercase;
            height: 2.6rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            transition: 0.3s;
        }

        .product-card:hover .p-name {
            color: var(--gold);
        }

        .p-price {
            font-weight: 700;
            color: #fff;
            font-size: 1.1rem;
        }

        @media (max-width: 991px) {
            .navbar-custom {
                padding: 15px 20px;
            }

            .nav-menu {
                display: none;
            }

            .filter-sidebar {
                display: none;
            }
        }
    </style>
</head>

<body>

    <a href="{{ route('cart.index') }}" class="cart-floating-btn">
        <i class="fas fa-shopping-basket"></i>
        @php $count = count(session('cart', [])); @endphp
        @if ($count > 0)
            <span class="cart-count-badge">{{ $count }}</span>
        @endif
    </a>

    <nav class="navbar-custom d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
            <img src="https://i.postimg.cc/wBXNS8BC/634279408-927069233189594-6692013687990253917-n.jpg"
                class="nav-logo" alt="Logo">
            <span class="ml-3 text-white font-weight-bold" style="letter-spacing: 2px;">IT BARBER</span>
        </a>

        <div class="nav-menu d-none d-lg-block">
            <a href="{{ url('/') }}">Dashboard</a>
            <a href="{{ route('about') }}">About Us</a></li>
            <a href="{{ route('shop.index') }}" class="active">Shop</a>           
            <a href="{{ url('contact') }}">Contact</a>
        </div>

        <div style="width: 45px;" class="d-none d-lg-block"></div>
    </nav>

    <div class="container-fluid shop-container px-lg-5 fade-in-entry mt-5">
        <div class="container-fluid shop-container px-lg-5 fade-in-entry mt-5">

            @if (session('success'))
                <div class="alert alert-dismissible fade show mb-4" role="alert"
                    style="background: rgba(255, 204, 0, 0.1); border: 1px solid var(--gold); color: var(--gold); border-radius: 8px;">
                    <i class="fas fa-check-circle mr-2"></i>
                    <strong>สำเร็จ!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        style="color: var(--gold); opacity: 1;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert"
                    style="border-radius: 8px;">
                    <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="row">

                    <aside class="col-lg-2 filter-sidebar">
                        <div class="filter-group">
                            <div class="filter-title">Categories</div>
                            <ul class="filter-list">
                                <li><a href="{{ route('shop.index') }}">All Products</a></li>
                                <li><a href="#">Apparel</a></li>
                                <li><a href="#">Barber Tools</a></li>
                                <li><a href="#">Hair Care</a></li>
                            </ul>
                        </div>
                        <div class="filter-group mt-5">
                            <div class="filter-title">Price Filter</div>
                            <ul class="filter-list">
                                <li><a href="#">฿0 - ฿500</a></li>
                                <li><a href="#">฿501 - ฿2,000</a></li>
                                <li><a href="#">฿2,001+</a></li>
                            </ul>
                        </div>
                    </aside>

                    <main class="col-lg-10">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3"
                            style="border-bottom: 1px solid #111;">
                            <div class="results-count text-muted small" style="letter-spacing: 1px;">SHOWING
                                {{ count($products) }} RESULTS</div>
                            <div class="d-flex align-items-center">
                                <span class="text-muted small mr-2">SORT:</span>
                                <select class="bg-transparent text-white border-0 small font-weight-bold"
                                    style="outline:none; cursor:pointer;">
                                    <option class="bg-dark">NEWEST</option>
                                    <option class="bg-dark">PRICE: LOW-HIGH</option>
                                    <option class="bg-dark">PRICE: HIGH-LOW</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            @forelse($products as $p)
                                <div class="col-6 col-md-4 col-xl-3 px-3">
                                    <div class="product-card">
                                        {{-- แก้ไขจุดที่ 1: $p['id'] -> $p->id --}}
                                        <a href="{{ route('shop.show', $p->id) }}" class="text-decoration-none">
                                            <div class="img-wrapper">
                                                <img src="{{ str_starts_with($p->img, 'http') ? $p->img : asset('storage/' . $p->img) }}"
                                                    alt="{{ $p->name }}">
                                                <div class="cart-overlay">
                                                    <div class="btn-view">
                                                        <i class="fas fa-eye mr-2"></i> View Details
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <a href="{{ route('shop.show', $p->id) }}" class="text-decoration-none">
                                            <span class="brand-label">{{ $p->cat ?? 'Barber Choice' }}</span>
                                            <h3 class="p-name">{{ $p->name }}</h3>
                                            <div class="p-price">฿{{ number_format($p->price) }}.00</div>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <p class="text-muted" style="letter-spacing: 2px;">NO PRODUCTS FOUND</p>
                                </div>
                            @endforelse
                        </div>
                    </main>
                </div>
            </div>

            <footer class="py-5 text-center mt-5" style="border-top: 1px solid #111;">
                <p class="small text-muted mb-0">© 2026 IT BARBER STORE — PRECISE CUTS, PREMIUM PRODUCTS</p>
            </footer>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>

