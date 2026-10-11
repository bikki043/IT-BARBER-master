<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | IT BARBER</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;700&family=Oswald:wght@500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <style>
        :root {
            --gold: #ffcc00;
            --dark: #000;
            --gray-text: #888;
            --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        body {
            background-color: var(--dark);
            color: #fff;
            font-family: 'Chakra Petch', sans-serif;
            overflow-x: hidden;
        }

        /* --- Navbar: ลบเส้นเหลืองออกแล้ว --- */
        .navbar-custom {
            padding: 15px 40px;
            background: rgba(0, 0, 0, 0.95);
            /* border-bottom ถูกเอาออกตามคำสั่ง */
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-left {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .nav-center {
            flex: 2;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .nav-right-spacer {
            flex: 1;
            display: none;
        }

        @media (min-width: 992px) {
            .nav-right-spacer {
                display: block;
            }
        }

        .nav-logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid var(--gold);
        }

        .nav-brand-text {
            color: #fff;
            font-weight: 700;
            letter-spacing: 2px;
            margin-left: 15px;
            text-transform: uppercase;
        }

        .nav-menu-link {
            color: #fff;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 2px;
            font-size: 0.85rem;
            padding: 8px 15px;
            text-decoration: none;
            transition: 0.3s;
        }

        .nav-menu-link:hover,
        .nav-menu-link.active {
            color: var(--gold);
            text-decoration: none;
        }

        /* --- Header Section --- */
        .about-header {
            padding: 100px 0;
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.95)),
                url('https://images.unsplash.com/photo-1585747860715-2ba37e788b70?q=80&w=2074') center/cover;
        }

        /* --- Slider Styling --- */
        .slider-frame {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }

        .slider-frame::after {
            content: '';
            position: absolute;
            top: 15px;
            right: -15px;
            width: 100%;
            height: 100%;
            border: 2px solid var(--gold);
            border-radius: 8px;
            z-index: 1;
        }

        .about-slider {
            position: relative;
            z-index: 2;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #222;
        }

        .about-slider img {
            width: 100%;
            height: 450px;
            object-fit: cover;
        }

        .slick-prev,
        .slick-next {
            z-index: 10;
            width: 40px;
            height: 40px;
            background: rgba(255, 204, 0, 0.9) !important;
            border-radius: 50%;
        }

        .slick-prev {
            left: 15px;
        }

        .slick-next {
            right: 15px;
        }

        /* --- Stats Box --- */
        .stat-box {
            padding: 20px;
            background: #0a0a0a;
            border: 1px solid #111;
            border-radius: 8px;
            text-align: center;
            margin-top: 15px;
            transition: var(--transition);
        }

        .stat-box:hover {
            border-color: var(--gold);
            transform: translateY(-5px);
        }

        .stat-number {
            font-family: 'Oswald';
            font-size: 2.2rem;
            color: var(--gold);
            font-weight: 700;
            display: block;
        }

        .stat-label {
            font-size: 0.7rem;
            letter-spacing: 1px;
            color: var(--gray-text);
            text-transform: uppercase;
        }

        footer {
            border-top: 1px solid #111;
            background: #000;
            padding: 40px 0;
        }
    </style>
</head>

<body>

    <nav class="navbar-custom">
        <div class="nav-left">
            <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                <img src="https://i.postimg.cc/wBXNS8BC/634279408-927069233189594-6692013687990253917-n.jpg"
                    class="nav-logo" alt="Logo">
                <span class="nav-brand-text d-none d-md-inline">IT BARBER</span>
            </a>
        </div>

        <div class="nav-center">
            <a href="{{ url('/') }}" class="nav-menu-link">Dashboard</a>
            <a href="{{ route('about') }}" class="nav-menu-link active">About Us</a>
            <a href="{{ route('shop.index') }}" class="nav-menu-link">Shop</a>
            <a href="{{ route('contact.index') }}" class="nav-menu-link">Contact</a>
        </div>

        <div class="nav-right-spacer"></div>
    </nav>

    @if ($about)
        <div data-aos="fade-up" data-aos-duration="1000">
            <section class="about-header text-center">
                <div class="container">
                    <h2
                        style="font-family: 'Oswald'; font-size: clamp(2.5rem, 5vw, 4rem); text-transform: uppercase; font-weight: 700;">
                        @php
                            $words = explode(' ', trim($about->hero_title));
                            $first = $words[0];
                        @endphp
                        {{ $first }} <span
                            style="color: var(--gold);">{{ Str::after($about->hero_title, $first) }}</span>
                    </h2>
                    <div style="background: var(--gold); width: 80px; height: 3px; margin: 25px auto;"></div>
                </div>
            </section>

            <section style="padding: 100px 0; background: #050505;">
                <div class="container">
                    <div class="row align-items-center">

                        <div class="col-lg-6 mb-5 mb-lg-0">
                            <div class="slider-frame">
                                <div class="about-slider">
                                    @if ($about->image_path)
                                        <div><img src="{{ asset('storage/' . $about->image_path) }}" alt="Main Image">
                                        </div>
                                    @endif

                                    @foreach ($about->images as $img)
                                        <div><img src="{{ asset('storage/' . $img->image_path) }}" alt="Gallery Image">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 pl-lg-5">
                            <h4
                                style="color: var(--gold); letter-spacing: 3px; text-transform: uppercase; margin-bottom: 25px; font-size: 0.9rem;">
                                The Art of Barbering</h4>
                            <div
                                style="line-height: 1.8; font-size: 1.15rem; color: #ccc; margin-bottom: 40px; text-align: justify;">
                                {!! nl2br(e($about->story_description)) !!}
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="stat-box">
                                        <span class="stat-number">{{ (int) $about->stat_years }}+</span>
                                        <span class="stat-label">Years</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box">
                                        <span class="stat-number">{{ number_format((int) $about->stat_cuts) }}</span>
                                        <span class="stat-label">Clients</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box">
                                        <span class="stat-number">{{ (int) $about->stat_satisfaction }}%</span>
                                        <span class="stat-label">Rating</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    @endif

    <footer class="text-center">
        <p class="small text-muted mb-0">© 2026 IT BARBER STORE — PRECISE CUTS, PREMIUM PRODUCTS</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        $(document).ready(function() {
            // เริ่มต้นใช้งานอนิเมชั่น
            AOS.init({
                once: true // ให้แสดงแค่ครั้งเดียวตอนเปิดหน้า
            });

            $('.about-slider').slick({
                dots: true,
                infinite: true,
                speed: 600,
                fade: true,
                cssEase: 'linear',
                autoplay: true,
                autoplaySpeed: 4000,
                arrows: true,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>'
            });
        });
    </script>
</body>

</html>

