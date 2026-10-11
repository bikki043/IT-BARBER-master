<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ใบเสร็จการจอง | IT BARBER</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;600;700&family=Prompt:wght@400;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <style>
        :root {
            --gold: #ffcc00;
            --dark: #121212;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--dark);
            font-family: 'Chakra Petch', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .receipt-wrapper {
            width: 100%;
            max-width: 500px;
        }

        #official-receipt {
            background: #fff;
            color: #000;
            width: 100%;
            padding: 50px 40px;
            box-shadow: 0 30px 100px rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            position: relative;
            border-top: 12px solid var(--gold);
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .receipt-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #eee;
            margin-bottom: 15px;
            object-fit: cover;
        }

        .receipt-header h2 {
            font-weight: 800;
            font-size: 28px;
            margin: 0;
            color: #000;
            letter-spacing: 2px;
        }

        .receipt-header p {
            font-size: 13px;
            color: #666;
            margin: 2px 0;
        }

        .meta-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 600;
            color: #444;
            gap: 10px;
        }

        .receipt-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .receipt-table th {
            border-bottom: 2px solid #000;
            padding: 12px 0;
            font-size: 12px;
            text-transform: uppercase;
            color: #888;
        }

        .receipt-table td {
            padding: 20px 0;
            vertical-align: middle;
        }

        .item-name {
            font-family: 'Prompt', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #000;
            display: block;
        }

        .item-sub {
            font-size: 13px;
            color: #777;
            display: block;
            margin-top: 4px;
        }

        .item-price {
            text-align: right;
            font-size: 20px;
            font-weight: 700;
            color: #000;
            white-space: nowrap;
        }

        .booking-details {
            background: #fcfcfc;
            border: 1px solid #eee;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            font-size: 15px;
            gap: 15px;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            color: #888;
            font-weight: 500;
            flex-shrink: 0;
        }

        .detail-value {
            font-weight: 700;
            color: #000;
            text-align: right;
            word-break: break-word;
        }

        .time-focus {
            background: #000;
            color: var(--gold);
            text-align: center;
            padding: 20px;
            border-radius: 15px;
            margin-top: 10px;
        }

        .time-focus span {
            font-size: 35px;
            font-weight: 800;
            display: block;
            line-height: 1;
        }

        .time-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
            opacity: 0.8;
        }

        .dashed-divider {
            border-top: 2px dashed #eee;
            margin: 30px 0;
        }

        .qr-code {
            width: 90px;
            height: 90px;
            object-fit: contain;
            margin-top: 5px;
        }

        .action-area {
            width: 100%;
            margin-top: 30px;
        }

        .btn-main {
            background: var(--gold);
            color: #000;
            border: none;
            width: 100%;
            padding: 18px;
            border-radius: 15px;
            font-weight: 800;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 10px 30px rgba(255, 204, 0, 0.3);
            display: block;
            text-align: center;
            text-decoration: none;
        }

        .btn-main:hover {
            background: #fff;
            transform: translateY(-3px);
            text-decoration: none;
            color: #000;
        }

        .home-link {
            color: rgba(255, 255, 255, 0.55);
            text-decoration: none;
        }

        .home-link:hover {
            color: #fff;
            text-decoration: none;
        }

        /* มือถือ */
        @media (max-width: 576px) {

            body {
                padding: 12px;
            }

            #official-receipt {
                padding: 35px 25px;
                border-top-width: 8px;
            }

            .receipt-logo {
                width: 80px;
                height: 80px;
            }

            .receipt-header h2 {
                font-size: 24px;
            }

            .meta-section {
                font-size: 12px;
            }

            .item-name {
                font-size: 16px;
            }

            .item-price {
                font-size: 17px;
            }

            .booking-details {
                padding: 20px;
            }

            .detail-row {
                font-size: 14px;
            }

            .time-focus span {
                font-size: 30px;
            }
        }

        /* ตอนพิมพ์ */
        @media print {

            body {
                background: #fff;
                padding: 0;
            }

            #official-receipt {
                box-shadow: none;
                max-width: 500px;
                margin: 0 auto;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <div class="receipt-wrapper">

        @if ($appointment)

            <!-- =========================
             RECEIPT
        ========================== -->
            <div id="official-receipt">

                <!-- HEADER -->
                <div class="receipt-header">

                    <img src="https://i.postimg.cc/wBXNS8BC/634279408-927069233189594-6692013687990253917-n.jpg"
                        class="receipt-logo" alt="IT BARBER Logo">

                    <h2>IT BARBER</h2>

                    @if (!empty($appointment->branch))
                        <p>สาขา: {{ $appointment->branch }}</p>
                    @endif

                    <p>
                        ออกเมื่อ:
                        {{ \Carbon\Carbon::now('Asia/Bangkok')->locale('th')->translatedFormat('j F Y | H:i') }}
                        น.
                    </p>

                </div>


                <!-- META -->
                <div class="meta-section">

                    <span>
                        ID:
                        #{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}
                    </span>

                    <span class="text-success">
                        <i class="fas fa-check-circle"></i>
                        CONFIRMED
                    </span>

                </div>


                <!-- SERVICE -->
                <table class="receipt-table">

                    <thead>
                        <tr>
                            <th>
                                บริการ / ช่าง
                            </th>

                            <th class="text-right">
                                ราคา
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>

                            <td>
                                <span class="item-name">
                                    {{ optional($appointment->service)->name ?? 'ไม่ระบุบริการ' }}
                                </span>

                                <span class="item-sub">
                                    Barber:
                                    {{ optional($appointment->barber)->name ?? 'ไม่ระบุช่าง' }}
                                </span>
                            </td>

                            <td class="item-price">
                                ฿{{ number_format(optional($appointment->service)->price ?? 0, 2) }}
                            </td>

                        </tr>
                    </tbody>

                </table>


                <!-- BOOKING DETAILS -->
                <div class="booking-details">

                    <!-- CUSTOMER -->
                    <div class="detail-row">

                        <span class="detail-label">
                            ชื่อลูกค้า:
                        </span>

                        <span class="detail-value">
                            {{ $appointment->customer_name ?? '-' }}
                        </span>

                    </div>


                    <!-- DATE -->
                    <div class="detail-row">

                        <span class="detail-label">
                            วันที่นัด:
                        </span>

                        <span class="detail-value">

                            @if ($appointment->appointment_date)
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->locale('th')->translatedFormat('lที่ j F Y') }}
                            @else
                                -
                            @endif

                        </span>

                    </div>


                    <!-- TIME -->
                    <div class="time-focus">

                        <div class="time-label">
                            เวลาที่จองไว้
                        </div>

                        <span>

                            @if ($appointment->appointment_time)
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                            @else
                                --:--
                            @endif

                            น.

                        </span>

                    </div>

                </div>


                <!-- DIVIDER -->
                <div class="dashed-divider"></div>


                <!-- FOOTER -->
                <div class="text-center">

                    <p class="small text-muted mb-3">

                        กรุณามาก่อนเวลานัด 5-10 นาที
                        <br>

                        ขอบคุณที่ใช้บริการ IT BARBER ครับ

                    </p>


                    <!-- QR -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode('ITB-' . $appointment->id) }}"
                        class="qr-code" alt="Booking QR Code">

                </div>

            </div>


            <!-- =========================
             PAYMENT SLIP / PAYMENT INFO
        ========================== -->

            <div class="mt-3">

                @include('partials.slip_status', ['appointment' => $appointment])

            </div>


            <!-- =========================
             ACTION BUTTON
        ========================== -->

            <div class="action-area no-print">

                <button type="button" onclick="saveImage()" class="btn-main mb-3">

                    <i class="fas fa-camera mr-2"></i>

                    บันทึกเป็นรูปภาพ

                </button>


                <div class="text-center">

                    <a href="{{ url('/') }}" class="home-link small">

                        <i class="fas fa-home mr-1"></i>

                        กลับหน้าแรก

                    </a>

                </div>

            </div>
        @else
            <!-- =========================
             NO APPOINTMENT
        ========================== -->

            <div class="text-center text-white" style="padding: 50px 20px;">

                <i class="fas fa-exclamation-triangle" style="font-size: 50px; color: #ffcc00;"></i>

                <h3 class="mt-4">
                    ไม่พบข้อมูลการจอง
                </h3>

                <p class="text-white-50">
                    ไม่สามารถแสดงใบเสร็จการจองได้
                </p>

                <a href="{{ url('/') }}" class="btn btn-warning mt-3">
                    <i class="fas fa-home mr-1"></i>
                    กลับหน้าแรก
                </a>

            </div>

        @endif

    </div>


    <script>
        function saveImage() {

            const receipt = document.getElementById('official-receipt');

            if (!receipt) {
                alert('ไม่พบข้อมูลใบเสร็จ');
                return;
            }

            const button = event.currentTarget;

            // ป้องกันกดซ้ำ
            button.disabled = true;

            const originalText = button.innerHTML;

            button.innerHTML =
                '<i class="fas fa-spinner fa-spin mr-2"></i> กำลังบันทึก...';


            html2canvas(receipt, {
                    scale: 2,
                    useCORS: true,
                    allowTaint: false,
                    backgroundColor: "#ffffff",
                    logging: false
                })
                .then(function(canvas) {

                    const link = document.createElement('a');

                    link.download =
                        'IT-BARBER-Receipt-{{ $appointment->id ?? 'unknown' }}.png';

                    link.href = canvas.toDataURL('image/png');

                    document.body.appendChild(link);

                    link.click();

                    document.body.removeChild(link);

                })
                .catch(function(error) {

                    console.error('Receipt image error:', error);

                    alert('ไม่สามารถบันทึกใบเสร็จเป็นรูปภาพได้');

                })
                .finally(function() {

                    button.disabled = false;

                    button.innerHTML = originalText;

                });

        }
    </script>

</body>

</html>
