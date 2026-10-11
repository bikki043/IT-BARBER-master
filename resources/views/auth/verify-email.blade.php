@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('title', 'ยืนยันอีเมลของคุณ')

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;600&display=swap');

    /* พื้นหลังรูปเดียวกับหน้า Login เน้นความชัดเจน 100% */
    body.login-page {
        background-color: #ffffff !important;
        background-image: url('https://img5.pic.in.th/file/secure-sv1/Gemini_Generated_Image_96zjoa96zjoa96zjf8230d272727ec34.png') !important;
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
        font-family: 'Kanit', sans-serif;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-logo { display: none !important; }

    .login-box {
        width: 100%;
        max-width: 450px;
        padding: 15px;
    }

    /* กล่อง Card สีขาวพรีเมียม (สไตล์เดียวกับหน้า Login) */
    .card-outline.card-primary {
        border-top: 5px solid #c5a059 !important;
        background: rgba(255, 255, 255, 0.98) !important;
        border-radius: 20px !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2) !important;
        border: none !important;
    }

    .brand-display {
        text-align: center;
        padding: 35px 20px 10px 20px;
    }

    .brand-display img {
        width: 90px; height: 90px;
        border-radius: 50%;
        border: 2px solid #c5a059;
        padding: 4px;
        background: #fff;
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        object-fit: cover;
    }

    .system-title { 
        color: #111827; 
        font-weight: 600; 
        margin-top: 20px; 
        font-size: 1.5rem;
    }
    
    /* ข้อความแจ้งเตือนให้อ่านง่ายขึ้น */
    .verify-msg {
        color: #4b5563 !important;
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 25px;
    }

    /* Alert เวลากดส่งเมลซ้ำ */
    .alert-success-custom {
        background: #f0fdf4 !important;
        border: 1px solid #bbf7d0 !important;
        color: #166534 !important;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        font-size: 0.9rem;
        font-weight: 400;
    }

    /* ปุ่มกดสีเข้ม (Slate Dark) สลับทองเวลา Hover */
    .btn-primary {
        background: #111827 !important;
        border: none !important;
        height: 55px;
        font-weight: 600;
        color: #ffffff !important;
        border-radius: 12px !important;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
    }

    .btn-primary:hover {
        background: #c5a059 !important;
        color: #111827 !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(197, 160, 89, 0.3) !important;
    }

    .btn-logout {
        color: #9ca3af;
        text-decoration: none;
        background: none;
        border: none;
        font-size: 0.9rem;
        transition: color 0.3s;
        font-weight: 300;
    }

    .btn-logout:hover { 
        color: #c5a059;
        text-decoration: underline;
    }
</style>
@stop

@section('auth_header')
    <div class="brand-display">
        <img src="{{ asset('images/pipoo.jpg') }}" alt="Logo">
        <h4 class="system-title">ยืนยันตัวตนของคุณ</h4>
    </div>
@stop

@section('auth_body')
    <div class="verify-msg text-center">
        ขอบคุณที่ร่วมเป็นส่วนหนึ่งกับเรา! <br>
        ระบบได้ส่งลิงก์ยืนยันไปที่อีเมลของคุณแล้ว <br>
        <b>กรุณาตรวจสอบกล่องจดหมายเพื่อเปิดใช้งานบัญชี</b>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert-success-custom text-center animate__animated animate__fadeIn">
            <i class="fas fa-check-circle mr-2"></i> ลิงก์ยืนยันใหม่ถูกส่งไปเรียบร้อยแล้วครับ!
        </div>
    @endif

    <div class="mt-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-block btn-primary">
                ส่งอีเมลยืนยันอีกครั้ง <i class="fas fa-paper-plane ml-2"></i>
            </button>
        </form>
    </div>
@stop

@section('auth_footer')
    <div class="text-center mt-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt mr-1"></i> ออกจากระบบชั่วคราว
            </button>
        </form>
    </div>
@stop
