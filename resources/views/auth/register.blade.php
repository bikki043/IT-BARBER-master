@extends('adminlte::auth.register')

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;600&display=swap');

    /* พื้นหลังรูปเดียวกับหน้า Login เน้นความชัดเจน */
    body.register-page {
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

    /* ซ่อน Text Logo เดิม */
    .register-logo { display: none !important; }

    .register-box {
        width: 100%;
        max-width: 440px;
        padding: 15px;
    }

    /* กล่อง Card สีขาวพรีเมียม */
    .card-outline.card-primary {
        border-top: 5px solid #c5a059 !important;
        background: rgba(255, 255, 255, 0.98) !important;
        border-radius: 20px !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2) !important;
        border: none !important;
    }

    .brand-header { text-align: center; padding: 30px 20px 10px; }
    
    .brand-logo {
        width: 90px; height: 90px;
        border-radius: 50%;
        border: 2px solid #c5a059;
        padding: 4px;
        background: #fff;
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        margin-bottom: 15px;
    }

    .brand-name {
        color: #111827;
        font-size: 1.7rem;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .brand-sub {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    /* Input สไตล์เรียบหรู */
    .input-group { margin-bottom: 15px !important; }
    .form-control {
        background: #fdfdfd !important;
        border: 1px solid #d1d5db !important;
        color: #111827 !important;
        height: 52px !important;
        border-radius: 12px !important;
        padding-left: 15px !important;
    }
    .form-control:focus {
        border-color: #c5a059 !important;
        box-shadow: 0 0 0 4px rgba(197, 160, 89, 0.1) !important;
    }

    .input-group-text {
        background: transparent !important;
        border: none !important;
        color: #c5a059 !important;
    }

    /* ปุ่มสมัครสมาชิกสีเข้มตัดทอง */
    .btn-primary {
        background: #111827 !important;
        border: none !important;
        height: 52px;
        border-radius: 12px !important;
        font-weight: 600;
        font-size: 1rem;
        letter-spacing: 1px;
        margin-top: 10px;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: #c5a059 !important;
        color: #111827 !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(197, 160, 89, 0.3) !important;
    }

    .auth-link {
        color: #c5a059 !important;
        font-weight: 600;
        transition: 0.3s;
    }
    .auth-link:hover {
        text-decoration: underline;
    }
</style>
@stop

@section('auth_header')
    <div class="brand-header">
        <img src="{{ asset('images/pipoo.jpg') }}" class="brand-logo" alt="Logo">
        <div class="brand-name">IT BARBER</div>
        <div class="brand-sub">สร้างบัญชีผู้ใช้งานใหม่</div>
    </div>
@stop

@section('auth_body')
    <form action="{{ route('register') }}" method="post">
        @csrf

        {{-- Name --}}
        <div class="input-group">
            <input type="text" name="name" class="form-control" placeholder="ชื่อ-นามสกุล" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-user"></span></div>
            </div>
        </div>

        {{-- Email --}}
        <div class="input-group">
            <input type="email" name="email" class="form-control" placeholder="อีเมลแอดเดรส" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
        </div>

        {{-- Password --}}
        <div class="input-group">
            <input type="password" name="password" class="form-control" placeholder="รหัสผ่าน (8 ตัวขึ้นไป)" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
        </div>

        {{-- Confirm Password --}}
        <div class="input-group">
            <input type="password" name="password_confirmation" class="form-control" placeholder="ยืนยันรหัสผ่านอีกครั้ง" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-check-circle"></span></div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">
            ยืนยันลงทะเบียน <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </form>
@stop

@section('auth_footer')
    <p class="text-center mt-3">
        <span style="color: #6b7280;">เป็นสมาชิกอยู่แล้ว?</span>
        <a href="{{ route('login') }}" class="auth-link ml-1">เข้าสู่ระบบ</a>
    </p>
@stop
