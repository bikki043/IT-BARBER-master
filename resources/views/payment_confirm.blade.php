<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ชำระเงิน | IT BARBER STORE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { background: #0a0a0a; color: #fff; font-family: 'Chakra Petch'; }
        .payment-card { background: #121212; border: 1px solid #ffcc00; padding: 40px; border-radius: 15px; margin-top: 50px; }
        .bank-info { background: #000; border: 1px dashed #ffcc00; padding: 20px; border-radius: 10px; margin: 20px 0; }
        .btn-gold { background: #ffcc00; color: #000; font-weight: bold; width: 100%; padding: 15px; }
        .btn-gold:hover { background: #fff; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="payment-card">
                <h2 style="color: #ffcc00;">ชำระเงินผ่านการโอนเงิน</h2>
                <hr style="background: #333;">
                
                <p>ยอดที่ต้องโอนทั้งหมด</p>
                <h1 style="color: #ffcc00;">฿{{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity'])) }}</h1>

                <div class="bank-info">
                    <p class="mb-1">ธนาคารกสิกรไทย</p>
                    <h3>123-4-56789-0</h3>
                    <p class="mb-0">ชื่อบัญชี: ไอที บาร์เบอร์ สโตร์</p>
                </div>

                <p class="small text-muted text-left">** เมื่อโอนเงินเสร็จแล้ว กรุณากดปุ่มยืนยันด้านล่างเพื่อให้แอดมินตรวจสอบ</p>

                <form action="{{ route('checkout.finalConfirm') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-gold">ฉันโอนเงินเรียบร้อยแล้ว</button>
                </form>

                <a href="{{ route('checkout.index') }}" class="btn btn-link text-muted mt-3">ย้อนกลับไปแก้ไขที่อยู่</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
