<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ของฉัน | IT BARBER</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;700&family=Oswald:wght@500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
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

        .profile-wrapper {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        /* Main Card Setup */
        .main-card {
            background: var(--gray-card);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.7);
        }

        /* Cover Image Area */
        .profile-cover {
            height: 200px;
            background: linear-gradient(45deg, #1a1a1a, #333);
            background-image: url('https://images.unsplash.com/photo-1503951914875-452162b0f3f1?q=80&w=2070');
            /* รูปพื้นหลังร้านตัดผมเท่ๆ */
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .cover-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        /* Avatar Setup */
        .avatar-section {
            position: relative;
            margin-top: -75px;
            /* ดึงรูปขึ้นไปทับรูปปก */
            padding: 0 40px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .profile-avatar-wrapper {
            position: relative;
            display: inline-block;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid var(--gray-card);
            object-fit: cover;
            background: var(--gray-card);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .btn-edit-avatar {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: var(--gold);
            color: #000;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--gray-card);
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-edit-avatar:hover {
            transform: scale(1.1);
            background: #fff;
        }

        /* User Header Info */
        .user-header-info {
            padding: 20px 40px;
            text-align: left;
        }

        .user-name {
            font-family: 'Oswald';
            font-size: 2.2rem;
            color: var(--gold);
            margin: 0;
        }

        .user-status {
            color: #888;
            font-size: 1rem;
        }

        /* Stats Row */
        .stats-container {
            display: flex;
            gap: 30px;
            padding: 0 40px 25px;
            border-bottom: 1px solid var(--border);
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            display: block;
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #666;
            text-transform: uppercase;
        }

        /* Detail Grid */
        .detail-section {
            padding: 40px;
        }

        .section-title {
            font-size: 1.2rem;
            color: var(--gold);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .section-title::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--border);
            margin-left: 15px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .info-box label {
            color: #555;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 8px;
            display: block;
        }

        .info-box .data-content {
            background: #000;
            padding: 12px 18px;
            border-radius: 10px;
            border: 1px solid var(--border);
            color: #ccc;
        }

        /* Buttons */
        .action-area {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .btn-custom {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-gold {
            background: var(--gold);
            color: #000;
            border: none;
        }

        .btn-gold:hover {
            background: var(--gold-hover);
            transform: translateY(-2px);
            text-decoration: none;
            color: #000;
        }

        .btn-outline {
            background: transparent;
            color: #fff;
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            background: var(--border);
            color: #fff;
            text-decoration: none;
        }

        .btn-logout-minimal {
            background: #ff444422;
            color: #ff4444;
            border: 1px solid #ff444444;
        }

        .btn-logout-minimal:hover {
            background: #ff4444;
            color: #fff;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .avatar-section {
                justify-content: center;
                text-align: center;
            }

            .user-header-info {
                text-align: center;
                padding: 20px;
            }

            .action-area {
                justify-content: center;
            }

            .stats-container {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <div class="container profile-wrapper">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="main-card">
                    <div class="profile-cover">
                        <div class="cover-overlay"></div>
                    </div>

                    <div class="avatar-section">
                        <div class="profile-avatar-wrapper">
                            <img src="{{ $user->image_path ? (str_contains($user->image_path, 'http') ? $user->image_path : asset('storage/' . $user->image_path)) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ffcc00&color=000' }}"
                                alt="Profile" class="profile-avatar">
                            {{-- ปุ่มเปลี่ยนรูป (ทำเป็นปุ่มลอยไว้ก่อน) --}}
                            <div class="btn-edit-avatar" title="เปลี่ยนรูปโปรไฟล์">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>

                        <div class="action-area mt-4 mt-md-0">
                            <a href="{{ route('home') }}" class="btn-custom btn-outline">
                                <i class="fas fa-home"></i> หน้าแรก
                            </a>
                            {{-- ปุ่มแก้ไขข้อมูล (ทำ Link ไว้รอ) --}}
                            <a href="{{ route('customer.profile.edit') }}" class="btn-custom btn-gold">
                                <i class="fas fa-user-edit"></i> แก้ไขโปรไฟล์
                            </a>
                            <form method="POST" action="{{ route('customer.logout') }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-custom btn-logout-minimal">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="user-header-info">
                        <h1 class="user-name">
                            {{ Auth::user()->name }}
                            @if (Auth::user()->google_id)
                                <i class="fab fa-google text-primary" style="font-size: 1.2rem; margin-left: 10px;"
                                    title="ยืนยันผ่าน Google แล้ว"></i>
                            @endif
                        </h1>
                        <p class="user-status">สมาชิก IT BARBER ระดับพรีเมียม</p>
                    </div>

                    <div class="stats-container">
                        <div class="stat-item">
                            <span class="stat-value">0</span>
                            <span class="stat-label">การจอง</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">ปกติ</span>
                            <span class="stat-label">สถานะ</span>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3 class="section-title"><i class="fas fa-info-circle mr-2"></i> ข้อมูลส่วนตัว</h3>

                        <div class="info-grid">
                            <div class="info-box">
                                <label>Email Address</label>
                                <div class="data-content">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="info-box">
                                <label>Phone Number</label>
                                <div class="data-content">{{ Auth::user()->phone ?? 'ไม่พบข้อมูลเบอร์โทร' }}</div>
                            </div>
                            <div class="info-box">
                                <label>Member Since</label>
                                <div class="data-content">{{ Auth::user()->created_at->translatedFormat('d F Y') }}
                                </div>
                            </div>
                            <div class="info-box">
                                <label>Account Type</label>
                                <div class="data-content">Standard User</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

