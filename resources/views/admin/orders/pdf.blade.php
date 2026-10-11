<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            /* ใช้ realpath เพื่อดึงพาธเต็มจากเซิร์ฟเวอร์ */
            src: url("{{ base_path('public/fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ base_path('public/fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew', sans-serif;
            font-size: 18px;
            /* ปรับขนาดให้ใหญ่เห็นชัด */
            line-height: 1.2;
        }

        /* บังคับให้ทุกอย่างใช้ฟอนต์นี้ */
        table,
        th,
        td,
        div,
        span,
        h2 {
            font-family: 'THSarabunNew', sans-serif !important;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <strong style="font-size: 18px;">รายงานสรุปรายการจัดส่งสินค้า IT BARBER</strong><br>
        ข้อมูล ณ วันที่ {{ $date }}
    </div>

    <table>
        <thead>
            <tr>
                <th>เลขออเดอร์</th>
                <th>วันที่ส่ง</th>
                <th>ลูกค้า</th>
                <th>ขนส่ง</th>
                <th class="text-right">ยอดเงิน</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->updated_at->format('d/m/Y') }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->courier_name ?? 'ทั่วไป' }}</td>
                    <td class="text-right">{{ number_format($order->total_amount, 2) }}</td>
                </tr>
                @php $total += $order->total_amount; @endphp
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        รวมทั้งสิ้น ฿{{ number_format($total, 2) }}
    </div>
</body>

</html>

