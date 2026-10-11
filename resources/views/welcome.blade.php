<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT BARBER ตัดผมชาย</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;700&family=Oswald:wght@500;700&family=Montserrat:wght@900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --gold: #ffcc00;
            --dark: #000;
            --gray: #111;
        }

        body {
            background-color: var(--dark);
            color: #fff;
            font-family: 'Chakra Petch', sans-serif;
            overflow-x: hidden;
        }

        /* --- Navbar --- */
        .navbar-custom {
            padding: 15px 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* แยกโลโก้ไปซ้าย ไอคอนไปขวา */
            background: rgba(0, 0, 0, 0.9);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 204, 0, 0.2);
        }

        .nav-logo {
            width: 70px;
            /* ปรับขนาดให้พอดี */
            height: 70px;
            border-radius: 50%;
            border: 2px solid var(--gold);
            transition: 0.3s;
        }

        /* ส่วนที่ทำให้เมนูอยู่กึ่งกลางเป๊ะ */
        .nav-links {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            position: absolute;
            /* ดีดออกจากแถวปกติ */
            left: 50%;
            /* ไปเริ่มที่กลางจอ */
            transform: translateX(-50%);
            /* ดึงตัวเองกลับมาครึ่งหนึ่งเพื่อให้กลางเป๊ะ */
        }

        .nav-links li {
            margin: 0 20px;
        }

        .nav-links a {
            color: #fff;
            text-transform: uppercase;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-decoration: none;
            transition: 0.3s;
            position: relative;
        }

        /* เพิ่มเส้นใต้สวยๆ เวลา Hover */
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: 0.3s;
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--gold);
        }

        /* ส่วนไอคอนฝั่งขวา */
        .nav-icons {
            display: flex;
            align-items: center;
            z-index: 10;
            /* ให้กดได้ไม่โดนเมนูบัง */
        }

        .nav-icons i {
            color: #fff;
            margin-left: 20px;
            font-size: 1.3rem;
            transition: 0.3s;
        }

        .nav-icons i:hover {
            color: var(--gold);
            transform: scale(1.1);
        }

        .btn-login-header {
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold);
            padding: 8px 22px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            transition: 0.3s;
            text-decoration: none !important;
            margin-left: 20px;
        }

        .btn-login-header:hover {
            background: var(--gold);
            color: #000;
            box-shadow: 0 0 20px rgba(255, 204, 0, 0.4);
        }

        /* จัดการมือถือ: ถ้าจอน้อยกว่า 992px ให้ซ่อนเมนูกลาง (เพราะจะทับโลโก้) */
        @media (max-width: 991px) {
            .nav-links {
                display: none;
            }

            .navbar-custom {
                padding: 10px 20px;
            }
        }

        /* --- Hero Slider --- */
        .hero-carousel-item {
            height: 90vh;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero-title {
            font-family: 'Montserrat';
            font-size: clamp(3rem, 10vw, 7rem);
            font-weight: 900;
            text-transform: uppercase;
            line-height: 0.9;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .hero-title span {
            color: var(--gold);
        }

        .btn-booking {
            background: #fff;
            color: #000 !important;
            font-weight: 800;
            padding: 20px 60px;
            font-size: 1.8rem;
            border-radius: 10px;
            margin-top: 50px;
            transition: 0.4s;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            text-decoration: none !important;
        }

        .btn-booking:hover {
            background: var(--gold);
            transform: translateY(-5px);
        }

        /* --- Showcase Section --- */
        .section-title {
            text-align: center;
            margin-bottom: 60px;
            margin-top: 60px;
        }

        .section-title h2 {
            font-family: 'Oswald';
            font-size: 3rem;
            font-weight: 700;
            letter-spacing: 5px;
        }

        .section-title div {
            width: 80px;
            height: 4px;
            background: var(--gold);
            margin: 10px auto;
        }

        /* --- Barber Section --- */
        .barber-box {
            position: relative;
            height: 500px;
            overflow: hidden;
            border-right: 1px solid #222;
            cursor: pointer;
            background: #111;
        }

        .barber-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.8s;
            opacity: 0.9;
        }

        .barber-mask {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.4) 40%, transparent 100%);
            transition: 0.5s;
        }

        .barber-details {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px 20px;
            transform: translateY(110px);
            transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-align: center;
            z-index: 2;
        }

        .barber-box:hover img {
            opacity: 1;
            transform: scale(1.05);
            filter: brightness(0.5);
        }

        .barber-box:hover .barber-details {
            transform: translateY(0);
        }

        /* --- Quote Section --- */
        .quote-container {
            padding: 150px 20px;
            background: fixed url('https://images.unsplash.com/photo-1512690196252-7c703fd99f92?q=80&w=2000') center/cover;
            text-align: center;
            position: relative;
        }

        .quote-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
        }

        .quote-content {
            position: relative;
            z-index: 1;
        }

        .quote-content i {
            font-size: 3rem;
            color: var(--gold);
            margin-bottom: 30px;
        }

        .quote-content p {
            font-size: 2.5rem;
            font-weight: 700;
            font-style: italic;
            max-width: 800px;
            margin: 0 auto;
        }

        /* --- Footer --- */
        .footer {
            padding: 80px 0 30px;
            background: #050505;
            border-top: 1px solid #222;
        }

        .footer-logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .info-box h5 {
            color: var(--gold);
            font-family: 'Oswald';
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .navbar-custom {
                padding: 15px 20px;
            }

            .nav-links {
                display: none;
            }

            .hero-title {
                font-size: 3.5rem;
            }

            .barber-box {
                height: 400px;
                border-bottom: 1px solid #111;
            }

            .barber-details {
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <nav class="navbar-custom">
        <div class="d-flex align-items-center">
            <img src="https://i.postimg.cc/wBXNS8BC/634279408-927069233189594-6692013687990253917-n.jpg"
                class="nav-logo" alt="Logo">
        </div>
        <ul class="nav-links">
            <li><a href="#" class="active">Dashboard</a></li>
            <li><a href="{{ route('about') }}">About Us</a></li>
            <li><a href="{{ route('shop.index') }}">Shop</a></li>
            <li><a href="{{ route('contact.index') }}">Contact</a></li>
        </ul>
        <div class="nav-icons d-flex align-items-center">
            <a href="{{ route('cart.index') }}" class="position-relative mr-4"
                style="color: inherit; text-decoration: none;">
                <i class="fas fa-shopping-cart" style="font-size: 1.4rem;"></i>
                @if (isset($cartCount) && $cartCount > 0)
                    <span class="badge badge-pill badge-warning"
                        style="font-size: 0.7rem; position: absolute; top: -8px; right: -10px; border: 2px solid var(--dark);">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            @if (Auth::guard('customer')->check())
                @php $user = Auth::guard('customer')->user(); @endphp
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle d-flex align-items-center" id="userDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        style="text-decoration: none; color: white;">
                        <div class="profile-frame">
                            <img src="{{ $user->image_path ? asset('storage/' . $user->image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=d4af37&color=fff' }}"
                                alt="Profile"
                                style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid var(--gold); object-fit: cover;">
                        </div>
                        <span class="ml-2 d-none d-md-inline-block"
                            style="font-size: 0.9rem; font-weight: 600;">{{ $user->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mt-3 shadow-lg" aria-labelledby="userDropdown"
                        style="background: #111; border: 1px solid #333; min-width: 200px;">
                        <a class="dropdown-item text-white py-2" href="{{ route('customer.profile') }}">
                            <i class="fas fa-user-circle mr-2 text-warning"></i> ข้อมูลส่วนตัว
                        </a>
                        <a class="dropdown-item text-white py-2" href="{{ route('booking.history') }}">
                            <i class="fas fa-history mr-2 text-warning"></i> ประวัติการจอง
                        </a>
                        <div class="dropdown-divider" style="border-top: 1px solid #333;"></div>
                        <form method="POST" action="{{ route('customer.logout') }}" class="px-3 py-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning btn-sm btn-block">
                                <i class="fas fa-sign-out-alt mr-2"></i> ออกจากระบบ
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ url('/customer/login') }}" class="btn-login-header">
                    <i class="fas fa-user-circle mr-1"></i> เข้าสู่ระบบ
                </a>
            @endif
        </div>
    </nav>

    <div id="itBarberHero" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="hero-carousel-item" data-aos="fade-up"
                    style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.8)), url('{{ asset('images/pictoo.png') }}');">
                    <h1 class="hero-title">IT<br><span>BARBER SHOP</span></h1>
                    <a href="{{ url('/booking') }}" class="btn-booking">จองคิวออนไลน์</a>
                </div>
            </div>
            <div class="carousel-item">
                <div class="hero-carousel-item"
                    style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.8)), url('https://img5.pic.in.th/file/secure-sv1/Gemini_Generated_Image_96zjoa96zjoa96zj.png');">
                    <p style="letter-spacing: 5px; color: var(--gold);">PREMIUM CUTS</p>
                    <h1 class="hero-title">CLASSIC<br><span>STYLE</span></h1>
                    <a href="{{ url('/booking') }}" class="btn-booking">จองคิวออนไลน์</a>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#itBarberHero" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#itBarberHero" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
    </div>

    <section id="portfolio" class="py-5" style="background-color: #050505; color: #fff; overflow: hidden;"
        data-aos="fade-up">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

        <div class="container-fluid px-md-5">
            <div class="row mb-5 align-items-end">
                <div class="col-md-8">
                    <h6 style="letter-spacing: 5px; color: #d4af37; font-weight: 300; text-transform: uppercase;">Our
                        Portfolio</h6>
                    <h2 class="display-4 font-weight-bold" style="font-family: 'Oswald', sans-serif;">TRENDING <span
                            style="color: #d4af37;">STYLES</span></h2>
                </div>
                <div class="col-md-4 d-none d-md-flex justify-content-end">
                    <div id="portfolio-prev" class="custom-nav"><i class="fas fa-chevron-left"></i></div>
                    <div id="portfolio-next" class="custom-nav ml-3"><i class="fas fa-chevron-right"></i></div>
                </div>
            </div>

            <div class="swiper portfolio-swiper">
                <div class="swiper-wrapper">
                    @forelse($latestWorks as $work)
                        @php
                            $imgUrl = $work->image_url
                                ? (str_starts_with($work->image_url, 'http')
                                    ? $work->image_url
                                    : asset('storage/' . $work->image_url))
                                : 'https://via.placeholder.com/400x500?text=No+Image';
                        @endphp
                        <div class="swiper-slide">
                            <a href="{{ $imgUrl }}" data-fancybox="gallery"
                                data-caption="{{ $work->title }}" class="premium-work-card">
                                <div class="work-inner">
                                    <div class="work-image">
                                        <img src="{{ $imgUrl }}" alt="{{ $work->title }}" loading="lazy">
                                    </div>
                                    <div class="work-info-overlay">
                                        <div class="work-border"></div>
                                        <div class="work-text">
                                            <span class="category">MASTERPIECE</span>
                                            <h4 class="title">{{ $work->title }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="text-center w-100 py-5">
                            <p class="text-muted">Coming Soon...</p>
                        </div>
                    @endforelse
                </div>
                <div class="swiper-pagination mt-4 d-md-none"></div>
            </div>
        </div>

        <style>
            .portfolio-swiper {
                padding: 10px 0 40px;
            }

            .custom-nav {
                width: 50px;
                height: 50px;
                border: 1px solid #d4af37;
                color: #d4af37;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: 0.3s;
                border-radius: 50%;
                z-index: 10;
            }

            .custom-nav:hover {
                background: #d4af37;
                color: #000;
            }

            .premium-work-card {
                display: block;
                position: relative;
                overflow: hidden;
                background: #000;
            }

            .work-inner {
                position: relative;
                aspect-ratio: 4/5;
                overflow: hidden;
                border-radius: 4px;
            }

            .work-image {
                width: 100%;
                height: 100%;
                transition: 1.2s cubic-bezier(0.19, 1, 0.22, 1);
            }

            .work-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                filter: brightness(0.8);
            }

            .work-info-overlay {
                position: absolute;
                inset: 0;
                padding: 25px;
                display: flex;
                align-items: flex-end;
                z-index: 2;
                opacity: 0;
                transition: 0.5s;
            }

            .work-border {
                position: absolute;
                inset: 15px;
                border: 1px solid #d4af37;
                transform: scale(1.1);
                transition: 0.5s;
            }

            .work-text .title {
                color: #fff;
                font-family: 'Oswald', sans-serif;
                font-size: 1.2rem;
                text-transform: uppercase;
            }

            .work-text .category {
                font-size: 0.6rem;
                letter-spacing: 2px;
                color: #d4af37;
            }

            .premium-work-card:hover .work-image {
                transform: scale(1.1);
            }

            .premium-work-card:hover .work-info-overlay {
                opacity: 1;
            }

            .premium-work-card:hover .work-border {
                transform: scale(1);
            }

            .swiper-pagination-bullet {
                background: #d4af37 !important;
            }

            .stat-card {
                background: #111;
                padding: 40px 20px;
                border-radius: 10px;
                text-align: center;
                border: 1px solid #222;
                transition: 0.4s;
                height: 100%;
            }

            .stat-card:hover {
                border-color: var(--gold);
                transform: translateY(-10px);
                box-shadow: 0 10px 30px rgba(255, 204, 0, 0.1);
            }

            .stat-icon {
                font-size: 2.5rem;
                color: var(--gold);
                margin-bottom: 20px;
            }

            .stat-number {
                font-family: 'Oswald', sans-serif;
                font-size: 3.5rem;
                font-weight: 700;
                color: #fff;
                margin-bottom: 5px;
            }

            .stat-label {
                color: #888;
                text-transform: uppercase;
                letter-spacing: 2px;
                font-size: 0.85rem;
            }
        </style>
    </section>

    <section class="py-5" style="background: #000; border-top: 1px solid #111;"data-aos="fade-up">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 style="color: #fff; font-family: 'Oswald';">OUR MASTER BARBERS</h2>
                <div style="background: #d4af37; height: 3px; width: 60px; margin: 15px auto;"></div>
            </div>

            <div class="row justify-content-center">
                @foreach ($barbers as $barber)
                    @php
                        $barberImg = $barber->image_path
                            ? (str_starts_with($barber->image_path, 'http')
                                ? $barber->image_path
                                : asset('storage/' . $barber->image_path))
                            : 'https://via.placeholder.com/600x800';
                    @endphp
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="barber-box" data-toggle="modal" data-target="#barberModal{{ $barber->id }}"
                            style="cursor: pointer; border: 1px solid #222; border-radius: 4px; height: 500px; position: relative; overflow: hidden; background: #111;">
                            <img src="{{ $barberImg }}" alt="{{ $barber->name }}"
                                style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(30%); transition: 0.5s;">
                            <div class="barber-mask"
                                style="position: absolute; inset: 0; background: linear-gradient(to top, #000 20%, transparent 100%);">
                            </div>
                            <div class="barber-details"
                                style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 20px; transition: 0.5s;">
                                <span
                                    style="color: #d4af37; font-family: 'Oswald'; letter-spacing: 2px; font-size: 0.8rem;">{{ strtoupper($barber->position) }}</span>
                                <h3
                                    style="font-family: 'Oswald'; font-size: 1.5rem; color: #fff; text-transform: uppercase; margin: 5px 0;">
                                    {{ $barber->name }}</h3>
                                <div style="background: #d4af37; width: 40px; height: 2px; margin-bottom: 15px;"></div>
                                <p style="color: #eee; font-size: 0.9rem; margin-bottom: 5px;"><i
                                        class="fas fa-cut mr-2" style="color: #d4af37;"></i>{{ $barber->expertise }}
                                </p>
                                <p class="small text-muted">{{ $barber->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-5" style="background: #050505; border-top: 1px solid #111;"data-aos="fade-up">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
                        <h3 class="stat-number" data-target="{{ $totalSales ?? 0 }}">0</h3>
                        <p class="stat-label">จำนวนสินค้าที่ขายได้ทั้งหมด</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <h3 class="stat-number" data-target="{{ $totalCustomers }}">0</h3>
                        <p class="stat-label">จำนวนสมาชิกทั้งหมด</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-cut"></i></div>
                        <h3 class="stat-number" data-target="{{ $totalStyles ?? 0 }}">0</h3>
                        <p class="stat-label">จำนวนหัวลูกค้าที่ตัดทั้งหมด</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="quote-container"data-aos="fade-up">
        <div class="quote-overlay"></div>
        <div class="quote-content container">
            <i class="fas fa-quote-left"></i>
            <p>" ไอที นอกจากจะเรียนคอม เเต่ก็คือช่างตัดผม ที่อยากให้ทุกคนหันมาดูแลตัวเอง "</p>
            <p class="mt-4" style="font-size: 1.2rem; color: var(--gold); font-family: 'Oswald';">CEO OF IT BARBER
            </p>
        </div>
    </div>

    <footer class="footer">
        <div class="container text-center">
            <img src="https://i.postimg.cc/wBXNS8BC/634279408-927069233189594-6692013687990253917-n.jpg"
                class="footer-logo" alt="Footer Logo">
            <div class="row text-left mt-5">
                <div class="col-md-4 info-box">
                    <h5>LOCATION</h5>
                    <p class="text-muted">บ้านโป่ง | หนองอ้อ | ในเมือง<br>จังหวัดบุรีรัมย์</p>
                </div>
                <div class="col-md-4 info-box">
                    <h5>OPENING HOURS</h5>
                    <p class="text-muted">จันทร์ - อาทิตย์<br>10:00 AM - 20:00 PM</p>
                </div>
                <div class="col-md-4 info-box">
                    <h5>CONTACT US</h5>
                    <p class="text-muted">Line ID: @IT-BARBER<br>Tel: 0984784512</p>
                </div>
            </div>
            <hr style="border-color: #222;" class="my-5">
            <p class="text-muted small">© 2026 IT BARBER SQUAD. ALL RIGHTS RESERVED.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const swiper = new Swiper('.portfolio-swiper', {
                slidesPerView: 1.2,
                spaceBetween: 20,
                speed: 800,
                autoplay: {
                    delay: 3000
                },
                navigation: {
                    nextEl: '#portfolio-next',
                    prevEl: '#portfolio-prev'
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 4
                    }
                }
            });

            Fancybox.bind("[data-fancybox='gallery']", {
                infinite: false,
                Toolbar: {
                    display: {
                        right: ["zoom", "close"]
                    }
                }
            });

            // ฟังก์ชันทำให้ตัวเลขวิ่ง (Counter Animation)
            const counters = document.querySelectorAll('.stat-number');
            const speed = 200;

            const runCounter = () => {
                counters.forEach(counter => {
                    const updateCount = () => {
                        const target = +counter.getAttribute('data-target');
                        const count = +counter.innerText.replace(/,/g, ''); // ลบคอมม่าออกก่อนคำนวณ
                        const inc = target / speed;

                        if (count < target) {
                            counter.innerText = Math.ceil(count + inc);
                            setTimeout(updateCount, 1);
                        } else {
                            counter.innerText = target.toLocaleString();
                        }
                    };
                    updateCount();
                });
            };

            // ตรวจสอบ Scroll
            let counterStarted = false;
            window.addEventListener('scroll', () => {
                const statsSection = document.querySelector('.stat-number');
                if (statsSection) {
                    const sectionPos = statsSection.getBoundingClientRect().top;
                    const screenPos = window.innerHeight;
                    if (sectionPos < screenPos && !counterStarted) {
                        runCounter();
                        counterStarted = true;
                    }
                }
            });
        });
    </script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // ความเร็ว 1 วินาที
            once: true, // เล่นรอบเดียวตอนเลื่อนมาเจอ
            offset: 100 // เริ่มเล่นเมื่อเลื่อนมาถึงระยะ 100px
        });
    </script>
</body>

</html>

