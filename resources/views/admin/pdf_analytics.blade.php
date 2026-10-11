<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    @php
        $fontRegular  = str_replace('\\', '/', public_path('fonts/THSarabunNew.ttf'));
        $totalService = array_sum($serviceData);
        $totalProduct = array_sum($productData);
    @endphp
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ $fontRegular }}") format('truetype');
        }
        @page { size: A4; margin: 1.5cm; }
        * { font-family: 'THSarabunNew', sans-serif; font-weight: normal !important; }
        body { font-size: 16pt; color: #000; }
        h1 { font-size: 28pt; text-align: center; margin: 0; }
        h2 { font-size: 20pt; margin: 18px 0 6px 0; }
        .sub { text-align: center; border-bottom: 2px solid #333; padding-bottom: 8px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th { background: #f2f2f2; border: 1px solid #333; padding: 6px; font-size: 17pt; }
        td { border: 1px solid #666; padding: 5px 8px; }
        .right { text-align: right; }
        .center { text-align: center; }
        .sum td { background: #fafafa; font-size: 17pt; }
    </style>
</head>
<body>
    <h1>รายงานวิเคราะห์รายได้ IT BARBER</h1>
    <div class="sub">
        ประจำปี {{ $year }}<br>
        พิมพ์เมื่อ {{ $printedAt }} น.
    </div>

    <h2>สรุปภาพรวม</h2>
    <table>
        <tr><td>รายได้ค่าบริการ (ตัดผม)</td><td class="right">{{ number_format($totalService, 2) }} บาท</td></tr>
        <tr><td>รายได้ขายสินค้า</td><td class="right">{{ number_format($totalProduct, 2) }} บาท</td></tr>
        <tr class="sum"><td>รายได้รวมทั้งหมด</td><td class="right">{{ number_format($totalService + $totalProduct, 2) }} บาท</td></tr>
    </table>

    <h2>รายได้เปรียบเทียบรายเดือน</h2>
    <table>
        <tr>
            <th width="16%">เดือน</th>
            <th>บริการตัดผม (บาท)</th>
            <th>ขายสินค้า (บาท)</th>
            <th>รวม (บาท)</th>
        </tr>
        @foreach($months as $i => $m)
            <tr>
                <td class="center">{{ $m }}</td>
                <td class="right">{{ number_format($serviceData[$i], 2) }}</td>
                <td class="right">{{ number_format($productData[$i], 2) }}</td>
                <td class="right">{{ number_format($serviceData[$i] + $productData[$i], 2) }}</td>
            </tr>
        @endforeach
        <tr class="sum">
            <td class="center">รวม</td>
            <td class="right">{{ number_format($totalService, 2) }}</td>
            <td class="right">{{ number_format($totalProduct, 2) }}</td>
            <td class="right">{{ number_format($totalService + $totalProduct, 2) }}</td>
        </tr>
    </table>
</body>
</html>