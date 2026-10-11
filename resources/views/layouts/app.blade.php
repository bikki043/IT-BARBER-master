<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IT BARBER | ประวัติการใช้งาน</title>

    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;700&family=Oswald:wght@500;700&family=Montserrat:wght@900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ตั้งค่าพื้นฐานให้ทั้งเว็บเป็นธีมมืด */
        body {
            font-family: 'Chakra Petch', sans-serif;
            background-color: #050505; /* สีดำเดียวกับหน้าหลัก */
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* ปรับแต่ง Scrollbar ให้ดูพรีเมียม */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #000;
        }
        ::-webkit-scrollbar-thumb {
            background: #ffcc00;
            border-radius: 10px;
        }

        .min-h-screen {
            min-height: 100vh;
            background-color: #050505 !important; /* บังคับให้เป็นสีดำ */
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen">
        {{-- ส่วนของ Navbar --}}
        {{-- หมายเหตุ: อย่าลืมตรวจสอบว่า layouts.navigation ของคุณใช้สีมืดด้วยหรือเปล่า --}}
        @include('layouts.navigation')

        {{-- ส่วนเนื้อหา (Content) --}}
        <main>
            @yield('content')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
