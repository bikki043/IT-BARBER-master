<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขโปรไฟล์ | IT BARBER</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;700&family=Oswald:wght@500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* ดึงสไตล์เดิมของคุณมาใช้ทั้งหมด */
        :root {
            --gold: #ffcc00;
            --gold-hover: #e6b800;
            --dark: #0a0a0a;
            --gray-card: #161616;
            --border: #2a2a2a;
        }

        body {
            background-color: var(--dark);
            color: #fff;
            font-family: 'Chakra Petch', sans-serif;
            background-image: radial-gradient(circle at 50% -20%, #332b00, transparent);
        }

        .main-card {
            background: var(--gray-card);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.7);
            margin-top: 50px;
        }

        /* สไตล์พิเศษสำหรับ Form Input */
        .form-control-custom {
            background: #000 !important;
            border: 1px solid var(--border) !important;
            color: #fff !important;
            border-radius: 10px;
            padding: 12px 18px;
            transition: 0.3s;
        }

        .form-control-custom:focus {
            border-color: var(--gold) !important;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.2);
        }

        .section-title {
            color: var(--gold);
            font-size: 1.2rem;
            margin-bottom: 25px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 10px;
        }

        .label-custom {
            color: #555;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 8px;
            display: block;
        }

        .btn-gold {
            background: var(--gold);
            color: #000;
            font-weight: 700;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-gold:hover {
            background: var(--gold-hover);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="main-card">
                    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="p-4 p-md-5">
                            <h3 class="section-title"><i class="fas fa-user-edit mr-2"></i> แก้ไขข้อมูลส่วนตัว</h3>

                            {{-- ส่วนอัปโหลดรูป --}}
                            <div class="text-center mb-5">
                                <div style="position: relative; display: inline-block;">
                                    <img id="preview"
                                        src="{{ $user->image_path ? asset('storage/' . $user->image_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}&background=ffcc00&color=000"
                                        style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 3px solid var(--gold);">
                                    <label for="image_path"
                                        style="position: absolute; bottom: 0; right: 0; background: var(--gold); color: #000; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid var(--gray-card);">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" name="image_path" id="image_path"
                                        onchange="previewImage(this)">
                                </div>
                                <p class="text-muted small mt-2">คลิกไอคอนเพื่อเปลี่ยนรูปโปรไฟล์</p>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label class="label-custom">ชื่อ-นามสกุล</label>
                                    <input type="text" name="name" class="form-control form-control-custom"
                                        value="{{ $user->name }}" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="label-custom">อีเมล (Email)</label>
                                    <input type="email" name="email" class="form-control form-control-custom"
                                        value="{{ $user->email }}" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="label-custom">เบอร์โทรศัพท์</label>
                                    <input type="text" name="phone" class="form-control form-control-custom"
                                        value="{{ $user->phone }}" placeholder="08x-xxx-xxxx">
                                </div>
                            </div>

                            <hr style="border-top: 1px solid var(--border);" class="my-4">

                            <div class="d-flex justify-content-between align-items: center;">
                                <a href="{{ route('customer.profile') }}" class="text-muted mt-2"><i
                                        class="fas fa-chevron-left mr-1"></i> ยกเลิกและกลับ</a>
                                <button type="submit" class="btn-gold">
                                    <i class="fas fa-save mr-2"></i> บันทึกข้อมูล
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // สคริปต์แสดงตัวอย่างรูปก่อนอัปโหลด
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>

</html>

