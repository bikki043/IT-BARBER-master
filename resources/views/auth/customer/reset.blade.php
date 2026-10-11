@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])



@section('title', 'ตั้งค่ารหัสผ่านใหม่')



@section('css')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;600&display=swap');



        /* พื้นหลังรูปต้นฉบับ ชัดเจน 100% สไตล์ IT BARBER */

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



        /* กล่องสีขาวพรีเมียม ขอบบนทอง */

        .card-outline.card-primary {

            border-top: 5px solid #c5a059 !important;

            background: rgba(255, 255, 255, 0.98) !important;

            border-radius: 20px !important;

            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2) !important;

            border: none !important;

        }



        .brand-display {
            text-align: center;
            padding: 30px 20px 10px;
        }



        .brand-display img {

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

            font-size: 1.6rem;

        }



        .text-muted-custom {

            color: #6b7280 !important;

            font-size: 0.9rem;

            margin-bottom: 20px;

        }



        /* Input สไตล์เรียบหรู คมชัด */

        .input-group {
            margin-bottom: 15px !important;
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



        /* ปุ่มอัปเดตรหัสผ่านสีเข้ม */

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



        /* Error feedback */

        .invalid-feedback {

            font-weight: 300;

            margin-top: 5px;

        }
    </style>

@stop



@section('auth_header')

    <div class="brand-display">

        <img src="{{ asset('images/pipoo.jpg') }}" alt="Logo">

        <h4 class="system-title">ตั้งค่ารหัสผ่านใหม่</h4>

        <p class="text-muted-custom">กำหนดรหัสผ่านใหม่เพื่อความปลอดภัยของบัญชีคุณ</p>

    </div>

@stop



@section('auth_body')

    <form action="{{ route('customer.password.store') }}" method="post">

        @csrf

        <input type="hidden" name="token" value="{{ $token }}">



        {{-- Email (ReadOnly) --}}

        <div class="input-group">

            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $request->email) }}" placeholder="อีเมลของคุณ" required readonly>

            <div class="input-group-append">

                <div class="input-group-text"><span class="fas fa-envelope"></span></div>

            </div>

            @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror

        </div>



        {{-- New Password --}}

        <div class="input-group">

            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="รหัสผ่านใหม่" required autofocus>

            <div class="input-group-append">

                <div class="input-group-text"><span class="fas fa-lock"></span></div>

            </div>

            @error('password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror

        </div>



        {{-- Confirm Password --}}

        <div class="input-group">

            <input type="password" name="password_confirmation" class="form-control"
                placeholder="ยืนยันรหัสผ่านใหม่อีกครั้ง" required>

            <div class="input-group-append">

                <div class="input-group-text"><span class="fas fa-check-circle"></span></div>

            </div>

        </div>



        <button type="submit" class="btn btn-block btn-primary shadow-sm">

            อัปเดตรหัสผ่านใหม่ <i class="fas fa-key ml-2"></i>

        </button>

    </form>

@stop

