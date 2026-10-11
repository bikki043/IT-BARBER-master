<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ลืมรหัสผ่าน | IT BARBER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Kanit', sans-serif; background: #f4f7f6; display: flex; align-items: center; min-height: 100vh; }
        .forgot-card { width: 100%; max-width: 400px; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); background: white; margin: auto; }
        .btn-dark { border-radius: 10px; padding: 12px; }
    </style>
</head>
<body>
    <div class="forgot-card">
        <div class="text-center mb-4">
            <h3 class="fw-bold">ลืมรหัสผ่าน?</h3>
            <p class="text-muted small">ระบุอีเมลของคุณเพื่อรับลิงก์ตั้งค่ารหัสผ่านใหม่</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success small" role="alert">{{ session('status') }}</div>
        @endif

        <form action="{{ route('customer.password.email') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label">อีเมลของคุณ</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="example@mail.com" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-dark w-100 mb-3">ส่งลิงก์กู้คืนรหัสผ่าน</button>

            <div class="text-center">
                <a href="{{ route('customer.login') }}" class="text-decoration-none small text-secondary">กลับไปหน้าเข้าสู่ระบบ</a>
            </div>
        </form>
    </div>
</body>
</html>
