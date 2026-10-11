<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ | IT BARBER</title>
    
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
        .login-container {
            width: 100%;
            max-width: 400px;
            margin: auto;
            padding: 20px;
        }
        .login-card {
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
            margin-bottom: 5px;
        }
        .brand-logo i {
            color: #ffc107;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e1e1e1;
            background-color: #f9f9f9;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.2);
            border-color: #ffc107;
            background-color: #fff;
        }
        .btn-login {
            background-color: #1a1a1a;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color: #333;
            transform: translateY(-2px);
            color: #ffc107;
        }
        .register-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9rem;
        }
        .register-link a {
            color: #ffc107;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <div class="brand-logo">
            <i class="fas fa-cut"></i> IT BARBER
        </div>
        <p class="text-center text-muted mb-4">ยินดีต้อนรับ! กรุณาเข้าสู่ระบบ</p>

        @if(session('success'))
            <div class="alert alert-success border-0 small mb-4" style="border-radius: 10px;">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('customer.login.post') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label ps-1">อีเมล</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" placeholder="example@mail.com" required autofocus>
                @error('email')
                    <div class="invalid-feedback ps-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label ps-1">รหัสผ่าน</label>
                <input type="password" name="password" class="form-control" placeholder="กรอกรหัสผ่านของคุณ" required>
            </div>

            <div class="d-flex justify-content-between mb-4 px-1">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label small text-muted" for="remember">จดจำฉัน</label>
                </div>
                <a href="{{ route('customer.forgot') }}" class="small text-decoration-none text-muted">ลืมรหัสผ่าน?</a>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">
                เข้าสู่ระบบ <i class="fas fa-arrow-right ms-2"></i>
            </button>

            <div class="register-link">
                <span class="text-muted">ยังไม่มีบัญชี?</span> 
                <a href="{{ route('customer.register') }}">สมัครสมาชิกที่นี่</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
