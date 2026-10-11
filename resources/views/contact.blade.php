@extends('layouts.app')

@section('content')
<section class="py-5" style="background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1503951914875-452162b0f3f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="container py-5 text-center">
        <h6 class="text-uppercase" style="color: #d4af37; letter-spacing: 3px;" data-aos="fade-up">Get in Touch</h6>
        <h1 class="display-3 text-white font-weight-bold" style="font-family: 'Oswald'; letter-spacing: 5px;" data-aos="fade-down" data-aos-delay="200">CONTACT <span style="color: #d4af37;">US</span></h1>
        <div style="width: 80px; height: 3px; background: #d4af37; margin: 20px auto;" data-aos="zoom-in" data-aos-delay="400"></div>
    </div>
</section>

<section class="py-5" style="background-color: #050505; color: #fff; overflow: hidden;">
    <div class="container py-5">
        <div class="row g-5"> <div class="col-lg-5" data-aos="fade-right">
                <div class="mb-5">
                    <h2 class="mb-4" style="font-family: 'Oswald';">ข้อมูลการ<span style="color: #d4af37;">ติดต่อ</span></h2>
                    <p class="text-muted">หากคุณมีคำถามหรือต้องการจองคิวพิเศษ สามารถติดต่อเราผ่านช่องทางด้านล่างนี้ได้ทันที ช่างของเราพร้อมให้บริการคุณ</p>
                </div>

                <div class="d-flex mb-4 p-3" style="background: #111; border-radius: 15px; border: 1px solid #222; transition: 0.3s;" onmouseover="this.style.borderColor='#d4af37'" onmouseout="this.style.borderColor='#222'">
                    <div class="icon-box mr-3" style="min-width: 50px; height: 50px; background: #d4af37; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #000;">
                        <i class="fas fa-map-marker-alt fa-lg"></i>
                    </div>
                    <div>
                        <h6 style="color: #d4af37; font-weight: bold;">LOCATION</h6>
                        <p class="mb-0 text-white-50">{{ $contact->address ?? 'บุรีรัมย์, ประเทศไทย' }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <a href="tel:{{ $contact->phone }}" style="text-decoration: none; color: inherit;">
                            <div class="p-3" style="background: #111; border-radius: 15px; border: 1px solid #222; height: 100%;">
                                <h6 style="color: #d4af37; font-size: 0.8rem; letter-spacing: 1px;">CALL US</h6>
                                <p class="mb-0 font-weight-bold">{{ $contact->phone ?? '0xx-xxx-xxxx' }}</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3" style="background: #111; border-radius: 15px; border: 1px solid #222; height: 100%;">
                            <h6 style="color: #d4af37; font-size: 0.8rem; letter-spacing: 1px;">LINE ID</h6>
                            <p class="mb-0 font-weight-bold">{{ $contact->line_id ?? '@it-barber' }}</p>
                        </div>
                    </div>
                </div>

                <div class="social-links-wrapper">
                    <h6 class="mb-3 text-muted" style="letter-spacing: 2px;">SOCIAL MEDIA</h6>
                    <div class="d-flex">
                        <a href="{{ $contact->facebook ?? '#' }}" class="btn-social shadow-sm"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ $contact->instagram ?? '#' }}" class="btn-social mx-2 shadow-sm"><i class="fab fa-instagram"></i></a>
                        <a href="https://line.me/ti/p/~{{ $contact->line_id ?? '' }}" class="btn-social shadow-sm"><i class="fab fa-line"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left">
                <div class="map-box p-2" style="background: #111; border-radius: 25px; border: 1px solid #222;">
                    <div class="map-container" style="border-radius: 20px; overflow: hidden; position: relative; height: 450px;">
                        @if($contact && $contact->google_map_iframe)
                            <div class="dark-map">
                                {!! $contact->google_map_iframe !!}
                            </div>
                        @else
                            <div class="h-100 d-flex flex-column align-items-center justify-content-center bg-dark text-muted">
                                <i class="fas fa-map-marked-alt fa-4x mb-3"></i>
                                <p>ยังไม่ได้ติดตั้งแผนที่ในระบบ</p>
                            </div>
                        @endif
                        
                        <div style="position: absolute; bottom: 20px; right: 20px; background: #d4af37; color: #000; padding: 5px 15px; border-radius: 50px; font-weight: bold; font-size: 0.8rem;">
                            <i class="fas fa-directions mr-1"></i> Open in Google Maps
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* ปรับแต่ง Social Button ให้พรีเมียม */
    .btn-social {
        width: 55px;
        height: 55px;
        background: #1a1a1a;
        color: #d4af37;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        border: 1px solid #333;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none !important;
    }
    .btn-social:hover {
        background: #d4af37;
        color: #000;
        transform: translateY(-8px) rotate(8deg);
        border-color: #d4af37;
    }

    /* จัดการ Iframe ให้เต็มกรอบและเป็น Dark Mode */
    .dark-map, .dark-map iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
    .dark-map iframe {
        filter: grayscale(100%) invert(90%) contrast(90%);
    }

    /* เพิ่มความสวยงามให้ Font */
    @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Prompt:wght@300;400;600&display=swap');
    body {
        font-family: 'Prompt', sans-serif;
    }
</style>
@endsection
