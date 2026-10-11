<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew', sans-serif;
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew', sans-serif;
        }

        body {
            font-family: 'THSarabunNew';
            font-size: 20px;
            /* ฟอนต์ไทยใน PDF มักจะตัวเล็กกว่าปกติ แนะนำให้ปรับเป็น 18-20px */
            text-align: center;
            padding: 5px;
            line-height: 1;
            /* ลดช่องว่างระหว่างบรรทัดภาษาไทย */
        }

        .line {
            border-bottom: 1px dashed #000;
            margin: 8px 0;
        }

        .total {
            font-size: 22px;
            font-weight: bold;
        }

        table {
            width: 100%;
            font-family: 'THSarabunNew';
        }
    </style>
</head>

<body>
    <strong>IT BARBER</strong><br>
    ใบเสร็จรับเงิน (Service Receipt)<br>
    <div class="line"></div>
    <div style="text-align: left;">
        วันที่: {{ date('d/m/Y H:i') }}<br>
        ลูกค้า: {{ $booking->customer_name }}<br>
        เวลา: {{ substr($booking->appointment_time, 0, 5) }} น.
    </div>
    <div class="line"></div>
    <table>
        <tr>
            <td align="left">{{ $booking->service->name ?? '-' }}</td>
            <td align="right">{{ number_format($booking->service->price ?? 0, 2) }}</td>
        </tr>
    </table>
    <div class="line"></div>
    <div class="total">รวมทั้งสิ้น: ฿{{ number_format($booking->service->price ?? 0, 2) }}</div>
    <br>
    <p>ขอบคุณที่ใช้บริการครับ</p>
</body>

</html>

