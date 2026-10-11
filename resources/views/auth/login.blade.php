@extends('adminlte::auth.login')

@section('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;600&display=swap');

        body.login-page {
            background-color: #ffffff !important;
            background-image: url('https://img5.pic.in.th/file/secure-sv1/Gemini_Generated_Image_96zjoa96zjoa96zjf8230d272727ec34.png') !important;
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            background-attachment: fixed !important;
            font-family: 'Kanit', sans-serif;
            height: 100vh;
        }

        .login-logo {
            display: none !important;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
        }

        .card-outline.card-primary {
            border-top: 5px solid #c5a059 !important;
            background: rgba(255, 255, 255, 0.98) !important;
            border-radius: 20px !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2) !important;
            border: none !important;
        }

        .brand-header {
            text-align: center;
            padding: 30px 20px 10px;
        }

        .brand-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #c5a059;
            padding: 4px;
            background: #fff;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .brand-name {
            color: #111827;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .brand-sub {
            color: #4b5563;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        .input-group .form-control {
            background: #fdfdfd !important;
            border: 1px solid #d1d5db !important;
            color: #111827 !important;
            height: 55px !important;
            border-radius: 12px !important;
        }

        .form-control:focus {
            border-color: #c5a059 !important;
            box-shadow: 0 0 0 4px rgba(197, 160, 89, 0.15) !important;
        }

        /* สไตล์สำหรับตอนข้อมูลผิด (Error) */
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }

        .input-group-text {
            color: #c5a059 !important;
        }

        .btn-primary {
            background: #111827 !important;
            border: none !important;
            height: 55px;
            border-radius: 12px !important;
            font-weight: 600;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background: #c5a059 !important;
            color: #111827 !important;
            transform: translateY(-2px);
        }
    </style>
@stop

@section('auth_header')
    <div class="brand-header">
        <img src="{{ asset('images/pipoo.jpg') }}"
            class="brand-logo" alt="Logo">
        <div class="brand-name">IT BARBER</div>
        <div class="brand-sub">MANAGEMENT SYSTEM</div>
    </div>
@stop

@section('auth_body')
    {{-- เช็ค Error กรณี Login ไม่สำเร็จ --}}
    @if ($errors->any())
        <div class="alert alert-danger" style="border-radius: 12px; font-size: 0.9rem;">
            <i class="fas fa-exclamation-circle mr-2"></i> อีเมลหรือรหัสผ่านไม่ถูกต้อง
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success" style="border-radius: 12px; font-size: 0.9rem;">
            <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="post">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="อีเมล" value="{{ old('email') }}" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="รหัสผ่าน" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">
            เข้าสู่ระบบ
        </button>
    </form>
@stop
@section('auth_footer')
    <p class="mb-1 text-center">
        <a href="{{ route('password.request') }}" class="small text-decoration-none text-muted">ลืมรหัสผ่าน?</a>
    </p>
@stop

