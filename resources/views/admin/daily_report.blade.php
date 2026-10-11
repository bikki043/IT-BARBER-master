<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face { font-family: 'THSarabunNew'; src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype'); }
        body { font-family: 'THSarabunNew'; font-size: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        .header { text-align: center; }
        .summary { text-align: right; margin-top: 30px; font-size: 24px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>รายงานสรุปการให้บริการ IT BARBER</h1>
        <p>ประจำวันที่: {{ $date }}</p>
    </div>
    <table>
        <thead>
            <tr style="background: #eee;">
                <th>เวลา</th>
                <th>ลูกค้า</th>
                <th>บริการ</th>
                <th>สถานะ</th>
                <th>ราคา</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
            <tr>
                <td>{{ substr($b->appointment_time, 0, 5) }}</td>
                <td>{{ $b->customer_name }}</td>
                <td>{{ $b->service->name ?? '-' }}</td>
                <td>{{ $b->status == 'completed' ? 'เสร็จสิ้น' : 'รอดำเนินการ' }}</td>
                <td>{{ number_format($b->service->price ?? 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="summary">รายรับรวมทั้งสิ้น: ฿{{ number_format($totalIncome) }}</div>
</body>
</html>
