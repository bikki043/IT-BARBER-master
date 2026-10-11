<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก | IT BARBER</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f4f7f6;
            display: flex;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .register-container {
            width: 100%;
            max-width: 450px;
            margin: auto;
            padding: 20px;
        }
        .register-card {
            background: #ffffff;
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: none;
        }
        .brand-logo {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 10px;
        }
        .brand-logo i {
            color: #ffc107;
        }
        .form-label {
            font-weight: 500;
            color: #4a4a4a;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e1e1e1;
            background-color: #f9f9f9;
            transition: all 0.3s;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.2);
            border-color: #ffc107;
            background-color: #fff;
        }
        .btn-register {
            background-color: #1a1a1a;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 15px;
        }
        .btn-register:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: #ffc107;
        }
        /* เพิ่มสไตล์ปุ่ม Google */
        .btn-google {
            background-color: #ffffff;
            color: #444;
            border: 1px solid #e1e1e1;
            border-radius: 12px;
            padding: 12px;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            margin-top: 10px;
        }
        .btn-google:hover {
            background-color: #f8f9fa;
            border-color: #ccc;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            color: #000;
        }
        .btn-google img {
            width: 20px;
            margin-right: 10px;
        }
        /* เส้นแบ่ง OR */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: #888;
            font-size: 0.85rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e1e1e1;
        }
        .divider:not(:empty)::before { margin-right: .5em; }
        .divider:not(:empty)::after { margin-left: .5em; }

        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.95rem;
        }
        .login-link a {
            color: #ffc107;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-card">
        <div class="brand-logo">
            <i class="fas fa-cut"></i> IT BARBER
        </div>
        <p class="text-center text-muted mb-4">เข้าร่วมกับเราเพื่อรับประสบการณ์การตัดผมที่ดีที่สุด</p>

        <form action="{{ route('customer.register.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" placeholder="กรอกชื่อและนามสกุลของคุณ" required autofocus>
                @error('name')
                    <span class="error-message"><i class="fas fa-info-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">อีเมล</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" placeholder="example@mail.com" required>
                @error('email')
                    <span class="error-message"><i class="fas fa-info-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">รหัสผ่าน</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                       placeholder="กำหนดรหัสผ่าน (อย่างน้อย 8 ตัวอักษร)" required>
                @error('password')
                    <span class="error-message"><i class="fas fa-info-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">ยืนยันรหัสผ่านอีกครั้ง</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                       placeholder="ระบุรหัสผ่านอีกครั้ง" required>
            </div>

            <button type="submit" class="btn btn-register w-100">
                <i class="fas fa-user-plus me-2"></i> สมัครสมาชิกตอนนี้
            </button>

            <div class="divider">หรือ</div>

            <a href="{{ route('google.login') }}" class="btn-google w-100">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google">
                สมัครสมาชิกด้วย Google
            </a>
            <div class="login-link">
                <span class="text-muted">มีบัญชีผู้ใช้แล้ว?</span> 
                <a href="{{ route('customer.login') }}">เข้าสู่ระบบที่นี่</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
