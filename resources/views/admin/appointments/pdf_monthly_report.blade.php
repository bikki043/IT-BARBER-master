<!DOCTYPE html>
<html lang="th">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    @php
        $fontRegular = str_replace('\\', '/', public_path('fonts/THSarabunNew.ttf'));
    @endphp
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ $fontRegular }}") format('truetype');
        }

        /* ตั้งค่าหน้ากระดาษ A4 */
        @page {
            size: A4;
            margin: 1.5cm 1.5cm 1.5cm 1.5cm;
        }

        /* ไม่ใช้ตัวหนาเลย เพราะไม่มีไฟล์ Bold */
        * {
            font-family: 'THSarabunNew', sans-serif;
            font-weight: normal !important;
        }

        body {
            font-size: 18pt;
            color: #000;
            line-height: 1.1;
            margin: 0;
            padding: 0;
        }

        /* Header */
        .header-table { width: 100%; border-bottom: 2px solid #000; margin-bottom: 20pt; }
        .brand-name { font-size: 32pt; color: #1a2a6c; line-height: 0.8; }
        .report-title { font-size: 24pt; text-decoration: underline; }
        .shop-info { font-size: 14pt; color: #333; }

        /* Summary Section */
        .summary-table {
            width: 100%;
            margin-bottom: 20pt;
            border-collapse: collapse;
        }
        .card-box {
            border: 1pt solid #ccc;
            background: #fdfdfd;
            padding: 10pt;
            text-align: center;
        }
        .card-label { font-size: 14pt; color: #444; display: block; }
        .card-value { font-size: 20pt; color: #000; }

        /* Table Content */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20pt;
        }
        .main-table th {
            border-top: 2pt solid #000;
            border-bottom: 1pt solid #000;
            background-color: #f2f2f2;
            padding: 8pt 5pt;
            font-size: 17pt;
        }
        .main-table td {
            padding: 7pt 5pt;
            border-bottom: 0.5pt solid #ccc;
            font-size: 15pt;
        }
        .total-row td {
            border-top: 1pt solid #000;
            border-bottom: 2pt double #000;
            background: #fafafa;
            font-size: 17pt;
        }

        /* Utility */
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* Signature */
        .footer-table { width: 100%; margin-top: 40pt; }
        .signature-area { width: 250pt; text-align: center; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="60%" style="padding-bottom: 10pt;">
                <div class="brand-name">IT BARBER</div>
                <div class="shop-info">
                    123 ถนนสุขุมวิท แขวงคลองเตย เขตคลองเตย กรุงเทพฯ 10110<br>
                    โทร: 02-123-4567 | อีเมล: contact@itbarber.com
                </div>
            </td>
            <td width="40%" class="text-right" style="vertical-align: top;">
                <div class="report-title">รายงานสรุปรายได้</div>
                <div style="font-size: 14pt; margin-top: 5pt;">
                    ประจำวันที่: {{ $date }}<br>
                    พิมพ์เมื่อ: {{ now()->format('d/m/Y H:i') }}
                </div>
            </td>
        </tr>
    </table>

    <table class="summary-table">
        <tr>
            <td width="32%" style="padding-right: 10pt;">
                <div class="card-box">
                    <span class="card-label">จำนวนรายการทั้งหมด</span>
                    <span class="card-value">{{ number_format($bookings->count()) }} งาน</span>
                </div>
            </td>
            <td width="32%" style="padding-right: 10pt;">
                <div class="card-box">
                    <span class="card-label">รายได้รวม (สุทธิ)</span>
                    <span class="card-value">{{ number_format($totalIncome, 2) }} บาท</span>
                </div>
            </td>
            <td width="32%">
                <div class="card-box">
                    <span class="card-label">ค่าเฉลี่ย/รายการ</span>
                    <span class="card-value">{{ $bookings->count() > 0 ? number_format($totalIncome / $bookings->count(), 2) : '0.00' }} บาท</span>
                </div>
            </td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th width="5%">ลำดับ</th>
                <th width="15%">เวลา</th>
                <th>ชื่อลูกค้า / เบอร์โทรศัพท์</th>
                <th>รายการบริการ</th>
                <th width="18%" class="text-right">จำนวนเงิน (บาท)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $index => $booking)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ substr($booking->appointment_time, 0, 5) }} น.</td>
                <td>
                    {{ $booking->customer_name }}<br>
                    <small style="font-size: 12pt; color: #555;">{{ $booking->customer_phone ?? '-' }}</small>
                </td>
                <td>{{ $booking->service->name ?? 'บริการทั่วไป' }}</td>
                <td class="text-right">{{ number_format($booking->service->price ?? 0, 2) }}</td>
            </tr>
            @endforeach

            <tr class="total-row">
                <td colspan="4" class="text-right">รวมรายได้ทั้งสิ้น</td>
                <td class="text-right">{{ number_format($totalIncome, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td width="50%" style="vertical-align: bottom; font-size: 12pt; color: #666;">
                * รายงานฉบับนี้พิมพ์โดยระบบจัดการร้าน IT BARBER<br>
                * ข้อมูลตรวจสอบ ณ วันที่ {{ now()->format('d/m/Y') }}
            </td>
            <td width="50%" class="text-right">
                <div class="signature-area" style="float: right;">
                    <p style="margin-bottom: 40pt;">ลงชื่อ...........................................................</p>
                    <p>( ..................................................... )</p>
                    <p style="font-size: 14pt;">ผู้ออกรายงาน / ผู้จัดการร้าน</p>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>