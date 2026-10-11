@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('title', 'ลืมรหัสผ่าน')

@section('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;600&display=swap');

        /* พื้นหลังรูปต้นฉบับ ชัดแจ๋ว 100% สไตล์ IT BARBER */
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

        .login-logo {
            display: none !important;
        }

        .login-box {
            width: 100%;
            max-width: 440px;
            padding: 15px;
        }

        /* กล่องสีขาวสะอาด ขอบบนทอง */
        .card-outline.card-primary {
            border-top: 5px solid #c5a059 !important;
            background: rgba(255, 255, 255, 0.98) !important;
            border-radius: 20px !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2) !important;
            border: none !important;
        }

        .brand-header {
            text-align: center;
            padding: 35px 20px 10px;
        }

        .brand-logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 2px solid #c5a059;
            padding: 4px;
            background: #fff;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        .system-title {
            color: #111827;
            font-weight: 600;
            margin-top: 15px;
            font-size: 1.5rem;
        }

        .text-instruction {
            color: #6b7280 !important;
            font-size: 0.95rem;
            margin-bottom: 25px;
        }

        /* กล่องข้อความแจ้งเตือนเมื่อส่งเมลสำเร็จ (Success Alert) */
        .alert-success-custom {
            background: #f0fdf4 !important;
            border: 1px solid #bbf7d0 !important;
            color: #166534 !important;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
        }

        /* Input สไตล์เรียบหรู */
        .input-group {
            margin-bottom: 20px !important;
        }

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

        /* ปุ่มส่งอีเมลสีเข้ม */
        .btn-primary {
            background: #111827 !important;
            border: none !important;
            height: 52px;
            border-radius: 12px !important;
            font-weight: 600;
            font-size: 1rem;
            color: #ffffff !important;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #c5a059 !important;
            color: #111827 !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(197, 160, 89, 0.3) !important;
        }

        .back-link {
            color: #c5a059 !important;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
@stop

@section('auth_header')
    <div class="brand-header">
        <img src="{{ asset('images/pipoo.jpg') }}"
            class="brand-logo" alt="Logo">
        <h4 class="system-title">ลืมรหัสผ่านใช่ไหม?</h4>
        <p class="text-instruction">กรอกอีเมลที่ใช้สมัครสมาชิก <br>เราจะส่งลิงก์สำหรับตั้งรหัสผ่านใหม่ไปให้ครับ</p>
    </div>
@stop

@section('auth_body')
    @if (session('status'))
        <div class="alert-success-custom animate__animated animate__fadeIn">
            <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="post">
        @csrf
        <div class="input-group">
            <input type="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror" placeholder="อีเมลของคุณ" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
            @error('email')
                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <button type="submit" class="btn btn-block btn-primary shadow-sm">
            ส่งลิงก์รีเซ็ตรหัสผ่าน <i class="fas fa-paper-plane ml-2"></i>
        </button>
    </form>
@stop

@section('auth_footer')
    <p class="text-center mt-4">
        <a href="{{ route('login') }}" class="back-link">
            <i class="fas fa-chevron-left mr-1"></i> กลับไปหน้าเข้าสู่ระบบ
        </a>
    </p>
@stop

