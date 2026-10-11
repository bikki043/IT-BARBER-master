<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จ #{{ $appointment->id }}</title>
    @php
        $fontRegular = str_replace('\\', '/', public_path('fonts/THSarabunNew.ttf'));
        $fontBold    = str_replace('\\', '/', public_path('fonts/THSarabunNew-Bold.ttf'));
        $price       = $appointment->service->price ?? 0;
    @endphp
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-weight: normal;
            src: url('{{ $fontRegular }}') format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-weight: bold;
            src: url('{{ $fontBold }}') format('truetype');
        }
        @page { margin: 8px 10px; }
        * { font-family: 'THSarabunNew', sans-serif; }
        body { font-size: 15px; color: #000; margin: 0; }
        .center { text-align: center; }
        .right  { text-align: right; }
        .bold   { font-weight: bold; }
        .shop   { font-size: 26px; font-weight: bold; letter-spacing: 2px; margin: 0; }
        .muted  { font-size: 13px; color: #444; }
        .line   { border-top: 1px dashed #000; margin: 6px 0; }
        table   { width: 100%; border-collapse: collapse; }
        td      { padding: 1px 0; vertical-align: top; }
        .total td { font-size: 20px; font-weight: bold; padding-top: 3px; }
    </style>
</head>
<body>
    <div class="center">
        <p class="shop">IT BARBER</p>
        <div class="muted">ใบเสร็จรับเงิน / RECEIPT</div>
        <div class="muted">สาขา{{ $appointment->branch }}</div>
    </div>

    <div class="line"></div>

    <table>
        <tr>
            <td>เลขที่</td>
            <td class="right bold">#{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td>วันที่นัด</td>
            <td class="right">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                {{ substr($appointment->appointment_time, 0, 5) }} น.</td>
        </tr>
        <tr>
            <td>ลูกค้า</td>
            <td class="right">{{ $appointment->customer_name }}</td>
        </tr>
        <tr>
            <td>โทร</td>
            <td class="right">{{ $appointment->customer_phone }}</td>
        </tr>
        <tr>
            <td>ช่าง</td>
            <td class="right">{{ $appointment->barber->name ?? '-' }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <table>
        <tr class="bold">
            <td>รายการ</td>
            <td class="right">ราคา</td>
        </tr>
        <tr>
            <td>{{ $appointment->service->name ?? 'ตัดผมชาย' }}</td>
            <td class="right">{{ number_format($price, 2) }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <table class="total">
        <tr>
            <td>ยอดสุทธิ</td>
            <td class="right">฿{{ number_format($price, 2) }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="center muted">
        ชำระเงินเรียบร้อยแล้ว<br>
        พิมพ์เมื่อ {{ now('Asia/Bangkok')->format('d/m/Y H:i') }}<br>
        <span class="bold">ขอบคุณที่ใช้บริการ IT BARBER</span>
    </div>
</body>
</html>
