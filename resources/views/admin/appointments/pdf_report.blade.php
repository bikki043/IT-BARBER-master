<!DOCTYPE html>
<html lang="th">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
            margin: 1.5cm;
        }

        /* ไม่ใช้ตัวหนาเลย เพราะไม่มีไฟล์ Bold */
        * {
            font-family: 'THSarabunNew', sans-serif;
            font-weight: normal !important;
        }

        body {
            font-size: 16pt;
            line-height: 1.3;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 28pt;
            margin: 0;
            color: #000;
        }

        .header p {
            font-size: 16pt;
            margin: 5px 0 0 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #f2f2f2;
            border: 1px solid #333;
            padding: 8px;
            font-size: 17pt;
        }

        td {
            border: 1px solid #666;
            padding: 6px 8px;
            vertical-align: middle;
        }

        .text-center { text-align: center; }
        .text-right  { text-align: right; }
        .text-left   { text-align: left; }

        .summary-box {
            margin-top: 25px;
            padding: 10px;
            border-top: 2px solid #333;
            text-align: right;
        }

        .total-label {
            font-size: 18pt;
        }

        .total-amount {
            font-size: 26pt;
            color: #000;
            text-decoration: underline;
            margin-left: 10px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 12pt;
            text-align: right;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>รายงานสรุปการให้บริการ IT BARBER</h1>
        <p>ประจำวันที่: {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="12%">เวลา</th>
                <th width="25%">ชื่อลูกค้า</th>
                <th>ประเภทบริการ</th>
                <th width="15%">สถานะ</th>
                <th width="18%">ราคา (บาท)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $b)
                <tr>
                    <td class="text-center">{{ substr($b->appointment_time, 0, 5) }} น.</td>
                    <td class="text-left">{{ $b->customer_name }}</td>
                    <td class="text-left">{{ $b->service->name ?? 'บริการทั่วไป' }}</td>
                    <td class="text-center">
                        {{ $b->status == 'completed' ? 'เสร็จสิ้น' : 'รอดำเนินการ' }}
                    </td>
                    <td class="text-right">{{ number_format($b->service->price ?? 0, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px;">
                        ไม่มีข้อมูลการให้บริการในวันที่เลือก
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary-box">
        <span class="total-label">รวมรายรับทั้งสิ้น:</span>
        <span class="total-amount">{{ number_format($totalIncome, 2) }} บาท</span>
    </div>

    <div class="footer">
        พิมพ์เมื่อวันที่: {{ now()->format('d/m/Y H:i') }} น.
    </div>

</body>

</html>