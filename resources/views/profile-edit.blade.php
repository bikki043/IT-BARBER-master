<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขโปรไฟล์ | IT BARBER</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --gold: #ffcc00;
            --dark: #0a0a0a;
            --gray-card: #161616;
            --border: #2a2a2a;
        }

        body {
            background-color: var(--dark);
            color: #fff;
            font-family: 'Chakra Petch', sans-serif;
        }

        .main-card {
            background: var(--gray-card);
            border-radius: 20px;
            border: 1px solid var(--border);
            padding: 40px;
            margin-top: 50px;
        }

        .form-control {
            background: #000;
            border: 1px solid var(--border);
            color: #fff;
            border-radius: 10px;
            padding: 12px;
        }

        .form-control:focus {
            background: #000;
            border-color: var(--gold);
            color: #fff;
            box-shadow: none;
        }

        label {
            color: var(--gold);
            font-size: 0.9rem;
            text-transform: uppercase;
            margin-top: 15px;
        }

        .btn-gold {
            background: var(--gold);
            color: #000;
            font-weight: bold;
            border-radius: 10px;
            padding: 12px 30px;
            transition: 0.3s;
        }

        .btn-gold:hover {
            background: #fff;
            transform: translateY(-2px);
        }

        .current-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid var(--gold);
            object-fit: cover;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="main-card">
                    <h2 class="text-center mb-4" style="color: var(--gold);"><i class="fas fa-user-cog mr-2"></i>
                        แก้ไขข้อมูลส่วนตัว</h2>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="text-center mb-4">
                            <img src="{{ $user->image_path ? (str_contains($user->image_path, 'http') ? $user->image_path : asset('storage/' . $user->image_path)) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ffcc00&color=000' }}"
                                alt="Profile" class="profile-avatar">
                            <div class="custom-file text-left">
                                <input type="file" name="avatar" class="custom-file-input" id="avatar">
                                <label class="custom-file-label form-control"
                                    for="avatar">เลือกรูปโปรไฟล์ใหม่...</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>ชื่อผู้ใช้งาน</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label>เบอร์โทรศัพท์</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $user->phone) }}" placeholder="เช่น 081-234-5678">
                        </div>

                        <div class="form-group">
                            <label>อีเมล (แก้ไขไม่ได้)</label>
                            <input type="text" class="form-control" value="{{ $user->email }}" disabled
                                style="opacity: 0.5;">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('profile.show') }}" class="text-muted"><i class="fas fa-arrow-left"></i>
                                ยกเลิก</a>
                            <button type="submit" class="btn btn-gold">บันทึกข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // แสดงชื่อไฟล์ที่เลือกในช่องอัปโหลด
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("avatar").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        })
    </script>
</body>

</html>

