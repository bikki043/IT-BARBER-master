@extends('adminlte::page')

@section('title', 'Executive Dashboard | IT BARBER')

@section('content_header')
    <div class="container-fluid animate__animated animate__fadeIn">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h1 class="m-0 text-bold text-dark" style="font-size: 2.4rem; letter-spacing: -1px;">
                    <i class="fas fa-database mr-2"></i>ระบบจัดการฐานข้อมูล <span class="text-primary">IT BARBER</span>
                </h1>
                <p class="text-muted mt-1">สวัสดีน้าาา วันนี้มีคิวลูกค้าา
                    {{ $bookings->where('status', 'pending')->count() }} รายการ</p>
            </div>
            <div class="col-md-6 text-md-right text-center">
                <div class="live-clock-wrapper d-inline-block mr-3 text-right">
                    <h4 class="mb-0 text-bold font-digit text-primary" id="live-clock" style="font-size: 1.8rem;">00:00:00
                    </h4>
                    <span class="badge badge-pill badge-success shadow-sm">
                        <i class="fas fa-circle animate__animated animate__flash animate__infinite mr-1"
                            style="font-size: 8px;"></i> เวลาปัจจุบัน
                    </span>
                </div>

                <div class="btn-group shadow-sm rounded-pill">
                    <a href="{{ route('admin.appointments.reportPDF') }}" target="_blank"
                        class="btn btn-danger px-4 rounded-left-pill">
                        <i class="fas fa-file-pdf mr-2"></i>รายวัน
                    </a>
                    <a href="{{ route('admin.appointments.reportMonthlyPDF', ['month' => date('m'), 'year' => date('Y')]) }}"
                        target="_blank" class="btn btn-dark px-4 rounded-right-pill">
                        <i class="fas fa-calendar-check mr-2"></i>รายเดือน
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    @php
        // รายชื่อช่างที่มีในคิว (ใช้ทำตัวกรอง)
        $barberNames = $bookings->map(fn($b) => $b->barber->name ?? null)->filter()->unique()->values();
    @endphp

    <div class="container-fluid pb-5 animate__animated animate__fadeInUp">

        {{-- ⚡ Quick Stats - High End Design --}}
        <div class="row mb-4">
            {{-- Card: Pending --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg rounded-20 bg-gradient-warning text-white h-100 overflow-hidden">
                    <div class="card-body p-4 position-relative">
                        <div class="z-index-1 position-relative">
                            <h6 class="text-uppercase small font-weight-bold opacity-8">คิวรอให้บริการ</h6>
                            <h1 class="display-4 text-bold mb-0">{{ $bookings->where('status', 'pending')->count() }}</h1>
                        </div>
                        <i class="fas fa-user-clock position-absolute opacity-2"
                            style="font-size: 5rem; right: -10px; bottom: -10px;"></i>
                    </div>
                </div>
            </div>

            {{-- Card: Daily Revenue --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg rounded-20 bg-white h-100 border-left-success-lg">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted small font-weight-bold">รายรับวันนี้</h6>
                                <h1 class="display-5 text-bold mb-0 text-success">
                                    ฿{{ number_format($bookings->where('status', 'completed')->sum(fn($b) => $b->service->price ?? 0)) }}
                                </h1>
                            </div>
                            <div class="icon-circle bg-success-light text-success">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Monthly Revenue --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg rounded-20 bg-white h-100 border-left-primary-lg">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted small font-weight-bold">รายรับเดือน
                                    {{ $today->format('M') }}</h6>
                                <h1 class="display-5 text-bold mb-0 text-primary">฿{{ number_format($monthlyRevenue ?? 0) }}
                                </h1>
                            </div>
                            <div class="icon-circle bg-primary-light text-primary">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Quick Actions --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-lg rounded-20 bg-light text-dark h-50">
                    <div class="card-body p-3 d-flex flex-column justify-content-around">
                        <button onclick="window.location.reload()"
                            class="btn btn-outline-dark btn-sm rounded-pill mb-2 border-dashed">
                            <i class="fas fa-sync-alt mr-2"></i>อัปเดตข้อมูลล่าสุด
                        </button>

                    </div>
                </div>
            </div>
        </div>

        {{-- 📋 Main Content Area --}}
        <div class="card border-0 shadow-lg rounded-25 overflow-hidden">
            <div class="card-header bg-white p-4 border-0">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <ul class="nav nav-pills bg-light rounded-pill p-1 d-inline-flex border" id="pills-tab"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active rounded-pill px-4 font-weight-bold" data-toggle="pill"
                                    href="#pending-tab">
                                    <i class="fas fa-bolt mr-2 text-warning"></i>คิวปัจจุบัน
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded-pill px-4 font-weight-bold text-dark" data-toggle="pill"
                                    href="#completed-tab">
                                    <i class="fas fa-history mr-2 text-success"></i>ประวัติที่เสร็จสิ้น
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-7">
                        <div class="d-flex mt-lg-0 mt-3">
                            {{-- ตัวกรองช่าง --}}
                            <div class="position-relative mr-2" style="min-width: 190px;">
                                <i class="fas fa-user-tie position-absolute text-muted"
                                    style="left: 18px; top: 15px; z-index: 2;"></i>
                                <select id="barberFilter"
                                    class="form-control rounded-pill border-0 bg-light pl-5 shadow-none"
                                    style="height: 46px;">
                                    <option value="">ช่างทั้งหมด</option>
                                    @foreach ($barberNames as $bn)
                                        <option value="{{ $bn }}">{{ $bn }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="search-wrapper position-relative flex-grow-1">
                                <i class="fas fa-search position-absolute text-muted" style="left: 20px; top: 15px;"></i>
                                <input type="text" id="dashboardSearch"
                                    class="form-control rounded-pill border-0 bg-light pl-5 shadow-none"
                                    style="height: 46px;" placeholder="ค้นหาลูกค้า เบอร์โทร หรือช่าง...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="tab-content">
                    <div class="tab-pane fade show active px-4 pb-4" id="pending-tab">
                        {!! renderBookingList($bookings->where('status', 'pending'), true) !!}
                    </div>
                    <div class="tab-pane fade px-4 pb-4" id="completed-tab">
                        {!! renderBookingList($bookings->where('status', 'completed'), false) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 🏆 Modal Detail --}}
    <div class="modal fade animate__animated animate__zoomIn" id="bookingDetailModal" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-2xl rounded-30">
                <div id="modal-booking-content">
                    {{-- Injected by JS --}}
                </div>
            </div>
        </div>
    </div>

    <form id="complete-booking-form" action="" method="POST" style="display: none;">
        @csrf @method('PATCH')
    </form>

@stop

@php
    function renderBookingList($bookings, $isPending)
    {
        if ($bookings->isEmpty()) {
            return '<div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 120px; opacity: 0.3;" class="mb-4">
                    <h5 class="text-muted font-weight-light">ไม่มีรายการคิวที่คุณกำลังมองหา</h5>
                </div>';
        }

        $html = '<div class="table-responsive"><table class="table table-hover border-0 align-middle">';
        $html .= '<thead class="text-muted small">
                <tr>
                    <th class="border-top-0 pl-0">เวลานัดหมาย</th>
                    <th class="border-top-0">ลูกค้า</th>
                    <th class="border-top-0">ช่างที่เลือก</th>
                    <th class="border-top-0">บริการ / รายละเอียด</th>
                    <th class="border-top-0 text-right">ค่าบริการ</th>
                    <th class="border-top-0 text-right pr-0">การจัดการ</th>
                </tr>
              </thead><tbody>';

        foreach ($bookings as $b) {
            $time = substr($b->appointment_time, 0, 5);
            $price = number_format($b->service->price ?? 0);
            $statusClass = $b->status === 'pending' ? 'bg-warning-soft text-warning' : 'bg-success-soft text-success';

            // ---------- ข้อมูลช่าง ----------
            $barberName = $b->barber->name ?? 'ไม่ระบุช่าง';
            $barberPos = $b->barber->position ?? '';
            $barberPath = $b->barber->image_path ?? null;
            if ($barberPath) {
                $barberImg = str_starts_with($barberPath, 'http') ? $barberPath : asset('storage/' . $barberPath);
            } else {
                $barberImg =
                    'https://ui-avatars.com/api/?name=' .
                    urlencode($barberName) .
                    '&background=ffcc00&color=000&bold=true';
            }

            $jsData = json_encode(
                [
                    'id' => $b->id,
                    'name' => $b->customer_name,
                    'phone' => $b->customer_phone,
                    'service' => $b->service->name ?? 'ตัดผมชาย',
                    'price' => $price,
                    'time' => $time,
                    'branch' => $b->branch,
                    'status' => $b->status,
                    'barber' => $barberName,
                    'barber_position' => $barberPos,
                    'barber_img' => $barberImg,
                    'payment_status' => $b->payment_status,
                    'payment_slip' => $b->payment_slip ? asset('storage/' . $b->payment_slip) : null,
                ],
                JSON_HEX_APOS | JSON_HEX_QUOT,
            );

            // ---------- รูปลูกค้า ----------
            $raw_path = null;
            if (isset($b->customer->image_path)) {
                $raw_path = $b->customer->image_path;
            } elseif (isset($b->image_path)) {
                $raw_path = $b->image_path;
            }

            if ($raw_path) {
                $user_img = asset('storage/' . $raw_path);
            } else {
                $user_img =
                    'https://ui-avatars.com/api/?name=' .
                    urlencode($b->customer_name) .
                    '&background=E8F0FE&color=2C3E50&bold=true';
            }

            $html .=
                '<tr data-barber="' .
                e($barberName) .
                '">
            <td class="pl-0">
                <div class="h5 font-digit mb-0 text-bold text-dark">' .
                $time .
                ' น.</div>
                <small class="text-muted"><i class="far fa-calendar-alt mr-1"></i> ' .
                $b->appointment_date .
                '</small>
            </td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="mr-3 position-relative">
                        <img src="' .
                $user_img .
                '" class="rounded-circle shadow-sm border customer-avatar" style="width: 50px; height: 50px; object-fit: cover;">
                        <span class="status-dot"></span>
                    </div>
                    <div>
                        <div class="text-bold text-dark mb-0">' .
                e($b->customer_name) .
                '</div>
                        <small class="text-muted"><i class="fas fa-phone-alt mr-1" style="font-size: 0.7rem;"></i> ' .
                e($b->customer_phone) .
                '</small>
                    </div>
                </div>
            </td>
            <td>
                <div class="barber-chip d-inline-flex align-items-center">
                    <img src="' .
                $barberImg .
                '" class="barber-avatar mr-2" alt="">
                    <div>
                        <div class="barber-name">' .
                e($barberName) .
                '</div>' .
                ($barberPos ? '<div class="barber-pos">' . e($barberPos) . '</div>' : '') .
                '
                    </div>
                </div>
            </td>
            <td>
                <span class="badge ' .
                $statusClass .
                ' border-0 px-3 py-2 rounded-pill font-weight-bold">
                    <i class="fas fa-cut mr-1"></i> ' .
                e($b->service->name ?? 'ทั่วไป') .
                '
                </span>
                <div class="small text-muted mt-1 ml-2"><i class="fas fa-map-pin mr-1"></i> ' .
                e($b->branch) .
                '</div>
            </td>
            <td class="text-right">
                <div class="text-bold text-dark h5 mb-0">฿' .
                $price .
                '</div>
            </td>
            <td class="text-right pr-0">
                    <button
                            type="button"
                            class="btn btn-dark btn-sm rounded-pill px-4 shadow-sm hover-scale"
                            onclick="viewBookingDetails(' .
                htmlspecialchars($jsData, ENT_QUOTES, 'UTF-8') .
                ')">
                            <i class="fas fa-eye mr-1"></i> จัดการ
                        </button>
            </td>
        </tr>';
        }
        $html .= '</tbody></table></div>';
        return $html;
    }
@endphp

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&family=JetBrains+Mono:wght@700&display=swap');

        :root {
            --primary: #1a2a6c;
            --warning: #f1c40f;
        }

        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f0f2f5;
        }

        .font-digit {
            font-family: 'JetBrains Mono', monospace;
        }

        /* 🎨 Custom Cards */
        .rounded-20 {
            border-radius: 20px !important;
        }

        .rounded-25 {
            border-radius: 25px !important;
        }

        .rounded-30 {
            border-radius: 30px !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f39c12, #f1c40f);
        }

        .border-left-success-lg {
            border-left: 6px solid #28a745;
        }

        .border-left-primary-lg {
            border-left: 6px solid #007bff;
        }

        /* 🔘 Buttons & Elements */
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-success-light {
            background: #d4edda;
            color: #28a745;
        }

        .bg-primary-light {
            background: #cfe2ff;
            color: #007bff;
        }

        .bg-warning-soft {
            background: #fff4e5;
        }

        .bg-success-soft {
            background: #eaffed;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            background: #343a40;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .hover-scale:hover {
            transform: scale(1.05);
            transition: 0.3s;
        }

        .rounded-left-pill {
            border-top-left-radius: 50px;
            border-bottom-left-radius: 50px;
        }

        .rounded-right-pill {
            border-top-right-radius: 50px;
            border-bottom-right-radius: 50px;
        }

        /* ✂️ Barber chip */
        .barber-chip {
            background: #fffbea;
            border: 1px solid #ffe58f;
            border-radius: 50px;
            padding: 5px 16px 5px 5px;
            transition: 0.3s;
        }

        .barber-chip:hover {
            background: #fff3bf;
            box-shadow: 0 4px 12px rgba(241, 196, 15, 0.25);
        }

        .barber-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #f1c40f;
        }

        .barber-name {
            font-weight: 600;
            font-size: 0.9rem;
            line-height: 1.1;
            color: #2c3e50;
        }

        .barber-pos {
            font-size: 0.68rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #b8860b;
        }

        .barber-card-modal {
            background: rgba(255, 204, 0, 0.1);
            border: 1px solid rgba(255, 204, 0, 0.35);
            border-radius: 18px;
            padding: 12px 16px;
        }

        .barber-card-modal img {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #f1c40f;
        }

        /* 📱 Responsive Adjustments */
        .table td {
            vertical-align: middle;
        }

        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Live Clock
        setInterval(() => {
            $('#live-clock').text(new Date().toLocaleTimeString('th-TH'));
        }, 1000);

        // Search + Barber Filter (ทำงานร่วมกัน)
        function applyFilters() {
            const keyword = $('#dashboardSearch').val().toLowerCase();
            const barber = $('#barberFilter').val();

            $('tbody tr').each(function() {
                const matchText = $(this).text().toLowerCase().indexOf(keyword) > -1;
                const matchBarber = !barber || $(this).attr('data-barber') === barber;
                $(this).toggle(matchText && matchBarber);
            });
        }
        $('#dashboardSearch').on('keyup', applyFilters);
        $('#barberFilter').on('change', applyFilters);

        function viewBookingDetails(data) {
            let slipHtml = '';

            if (data.payment_slip) {

                slipHtml = `
        <div class="mt-4">
            <div class="card border-0 shadow-sm rounded-20">

                <div class="card-header bg-dark text-white">
                    <strong>
                        <i class="fas fa-receipt mr-2"></i>
                        หลักฐานการชำระเงิน
                    </strong>
                </div>

                <div class="card-body text-center">

                    <img src="${data.payment_slip}"
                         class="img-fluid rounded shadow-sm"
                         style="
                            max-height:350px;
                            width:auto;
                            object-fit:contain;
                         ">

                    <div class="mt-3">

                        ${
                            data.payment_status === 'paid'
                            ? `
                                            <span class="badge badge-success px-3 py-2">
                                                <i class="fas fa-check mr-1"></i>
                                                ชำระเงินแล้ว
                                            </span>
                                        `
                            : data.payment_status === 'rejected'
                            ? `
                                            <span class="badge badge-danger px-3 py-2">
                                                <i class="fas fa-times mr-1"></i>
                                                สลิปไม่ผ่าน
                                            </span>
                                        `
                            : `
                                            <span class="badge badge-warning px-3 py-2">
                                                <i class="fas fa-clock mr-1"></i>
                                                รอตรวจสอบ
                                            </span>
                                        `
                        }

                    </div>

                </div>
            </div>
        </div>
    `;

            } else {

                slipHtml = `
        <div class="mt-4">
            <div class="alert alert-light border rounded-20 text-center">
                <i class="fas fa-image mr-2"></i>
                ยังไม่มีหลักฐานการชำระเงิน
            </div>
        </div>
    `;
            }
            let receiptUrl = "{{ route('admin.appointments.receiptPDF', ':id') }}".replace(':id', data.id);

            let content = `
        <div class="row no-gutters">
            <div class="col-lg-6 p-5 bg-white">
                <div class="mb-4">
                    <span class="badge badge-primary px-3 py-1 mb-2">ข้อมูลการจอง #${data.id}</span>
                    <h2 class="text-bold text-dark">${data.name}</h2>
                    <p class="text-muted"><i class="fas fa-phone mr-2"></i>${data.phone}</p>
                </div>
                <div class="list-group list-group-flush border-top">
                    <div class="list-group-item px-0 bg-transparent py-3">
                        <label class="small text-uppercase text-muted d-block">ช่างที่ลูกค้าเลือก</label>
                        <div class="barber-card-modal d-flex align-items-center">
                            <img src="${data.barber_img}" class="mr-3" alt="">
                            <div>
                                <div class="h5 text-dark mb-0 text-bold">${data.barber}</div>
                                <small class="text-uppercase text-muted" style="letter-spacing:1px;">${data.barber_position || 'Barber'}</small>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item px-0 bg-transparent py-3">
                        <label class="small text-uppercase text-muted d-block">บริการที่เลือก</label>
                        <span class="h5 text-dark"><i class="fas fa-cut mr-2 text-warning"></i>${data.service}</span>
                    </div>
                    <div class="list-group-item px-0 bg-transparent py-3">
                        <label class="small text-uppercase text-muted d-block">สาขา</label>
                        <span class="text-dark"><i class="fas fa-map-marker-alt mr-2 text-danger"></i>${data.branch}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 p-5 bg-dark text-white d-flex flex-column justify-content-center" style="border-radius: 0 30px 30px 0;">
                <div class="text-center mb-4">
                    <div class="display-3 font-digit text-bold text-warning">${data.time}</div>
                    <p class="opacity-75 h5 font-weight-light">เวลานัดหมาย</p>
                </div>
                <div class="bg-secondary p-4 rounded-20 mb-4 text-center" style="background: rgba(255,255,255,0.05) !important;">
                    <span class="text-muted d-block small text-uppercase">ยอดชำระสุทธิ</span>
                    <span class="display-5 text-bold text-white">฿${data.price}</span>
                </div>
                ${
                    data.status === 'pending' ? `
                <button onclick="confirmComplete(${data.id})"
                        class="btn btn-warning btn-lg btn-block text-bold py-3 shadow-lg rounded-pill hover-scale">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    บันทึกรับเงินและปิดงาน
                </button>
            ` : `
                <a href="${receiptUrl}"
                   target="_blank"
                   class="btn btn-outline-light btn-block rounded-pill py-3">
                    <i class="fas fa-print mr-2"></i>
                    พิมพ์ใบเสร็จรับเงิน
                </a>
            `
                }
            </div>
        </div>
        <div class="px-5 pb-5 bg-white" style="border-radius: 0 0 30px 30px;">
            ${slipHtml}
        </div>`;

            $('#modal-booking-content').html(content);
            $('#bookingDetailModal').modal('show');
        }

        function confirmComplete(id) {
            Swal.fire({
                title: 'ยืนยันการรับเงิน?',
                text: "ระบบจะบันทึกรายได้และเปลี่ยนสถานะคิวนี้",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'ยืนยัน, รับเงินแล้ว',
                cancelButtonText: 'ยกเลิก',
                borderRadius: '20px'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('admin.appointments.complete', ':id') }}".replace(':id', id);
                    $('#complete-booking-form').attr('action', url).submit();
                }
            });


        }
    </script>
@stop