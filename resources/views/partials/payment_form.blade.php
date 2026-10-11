<div class="payment-card">

    <!-- หัวข้อ -->
    <div class="payment-header">
        <div class="payment-icon">
            <i class="fas fa-wallet"></i>
        </div>

        <div>
            <h3>ชำระเงินด้วยการโอน</h3>
            <p>กรุณาโอนเงินตามยอดที่ระบุด้านล่าง</p>
        </div>
    </div>


    <!-- ข้อมูลบัญชี -->
    <div class="payment-info">

        <div class="payment-row">
            <span>ธนาคาร</span>
            <strong>XXXX</strong>
        </div>

        <div class="payment-row">
            <span>เลขบัญชี</span>
            <strong>000-0-00000-0</strong>
        </div>

        <div class="payment-row">
            <span>ชื่อบัญชี</span>
            <strong>ชื่อบัญชีของร้าน</strong>
        </div>

        @if (!empty($appointment->service?->price))

            <div class="payment-total">

                <span>
                    ยอดที่ต้องโอน
                </span>

                <strong>
                    ฿{{ number_format($appointment->service->price, 2) }}
                </strong>

            </div>

        @endif

    </div>


    <!-- Success -->
    @if (session('success'))

        <div class="payment-alert success">

            <i class="fas fa-check-circle"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    <!-- Error -->
    @if ($errors->any())

        <div class="payment-alert error">

            <i class="fas fa-exclamation-circle"></i>

            <span>
                {{ $errors->first() }}
            </span>

        </div>

    @endif


    <!-- จ่ายแล้ว -->
    @if ($appointment->payment_status === 'paid')

        <div class="payment-confirmed">

            <div class="confirmed-icon">
                <i class="fas fa-check"></i>
            </div>

            <div>
                <strong>ยืนยันการชำระเงินแล้ว</strong>
                <span>ขอบคุณที่ใช้บริการ IT BARBER ครับ</span>
            </div>

        </div>


    @else

        <!-- มีสลิปแล้ว -->
        @if ($appointment->payment_slip)

            <div class="slip-section">

                <div class="slip-status">

                    <span class="status-label">
                        สถานะการชำระเงิน
                    </span>

                    @if ($appointment->payment_status === 'rejected')

                        <span class="status rejected">
                            <i class="fas fa-times-circle"></i>
                            สลิปไม่ผ่าน
                        </span>

                    @else

                        <span class="status pending">
                            <i class="fas fa-clock"></i>
                            รอแอดมินตรวจสอบ
                        </span>

                    @endif

                </div>


                <!-- รูปสลิป -->
                <div class="slip-preview">

                    <img
                        src="{{ asset('storage/'.$appointment->payment_slip) }}"
                        alt="หลักฐานการชำระเงิน"
                    >

                    <div class="slip-caption">
                        <i class="fas fa-image"></i>
                        หลักฐานการโอนเงิน
                    </div>

                </div>

            </div>

        @endif


        <!-- Upload -->
        <form
            method="POST"
            action="{{ route('booking.slip.upload', $appointment->id) }}"
            enctype="multipart/form-data"
            class="upload-form"
        >

            @csrf

            <label class="upload-label">

                <i class="fas fa-cloud-upload-alt"></i>

                <span>
                    {{ $appointment->payment_slip
                        ? 'อัปโหลดสลิปใหม่'
                        : 'อัปโหลดหลักฐานการโอน' }}
                </span>

            </label>


            <input
                type="file"
                name="slip"
                accept="image/png,image/jpeg"
                required
                class="file-input"
            >


            <button
                type="submit"
                class="upload-button"
            >

                <i class="fas fa-upload"></i>

                {{ $appointment->payment_slip
                    ? 'อัปโหลดสลิปใหม่'
                    : 'ยืนยันการโอนเงิน' }}

            </button>

        </form>

    @endif

</div>


<style>

    /* ================================
       IT BARBER PAYMENT CARD
    ================================= */

    .payment-card {
        width: 100%;
        max-width: 500px;
        margin: 30px auto 0;
        padding: 30px;
        background: #ffffff;
        color: #000;
        border-radius: 10px;
        border-top: 6px solid #ffcc00;
        box-shadow: 0 20px 60px rgba(0,0,0,0.35);
        font-family: 'Chakra Petch', sans-serif;
    }


    /* HEADER */

    .payment-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-bottom: 22px;
        margin-bottom: 22px;
        border-bottom: 2px solid #f0f0f0;
    }

    .payment-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #000;
        color: #ffcc00;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
        flex-shrink: 0;
    }

    .payment-header h3 {
        margin: 0;
        font-family: 'Prompt', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: #000;
    }

    .payment-header p {
        margin: 3px 0 0;
        color: #777;
        font-size: 12px;
    }


    /* BANK INFORMATION */

    .payment-info {
        background: #fafafa;
        border: 1px solid #eeeeee;
        border-radius: 16px;
        padding: 20px;
    }

    .payment-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 9px 0;
        font-size: 14px;
    }

    .payment-row span {
        color: #888;
    }

    .payment-row strong {
        color: #000;
        text-align: right;
        font-weight: 700;
    }


    /* TOTAL */

    .payment-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 12px;
        padding-top: 16px;
        border-top: 2px dashed #ddd;
    }

    .payment-total span {
        font-size: 14px;
        font-weight: 600;
        color: #555;
    }

    .payment-total strong {
        color: #000;
        font-family: 'Prompt', sans-serif;
        font-size: 23px;
        font-weight: 700;
    }


    /* ALERT */

    .payment-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        margin-top: 18px;
        border-radius: 10px;
        font-size: 13px;
    }

    .payment-alert.success {
        background: #edf9f0;
        color: #187a35;
        border: 1px solid #ccebd3;
    }

    .payment-alert.error {
        background: #fff0f0;
        color: #c62828;
        border: 1px solid #f1cccc;
    }


    /* CONFIRMED */

    .payment-confirmed {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #000;
        color: #fff;
        border-radius: 15px;
        padding: 18px;
        margin-top: 20px;
    }

    .confirmed-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #ffcc00;
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .payment-confirmed strong {
        display: block;
        color: #ffcc00;
        font-family: 'Prompt', sans-serif;
        font-size: 15px;
    }

    .payment-confirmed span {
        display: block;
        color: #ccc;
        font-size: 12px;
        margin-top: 3px;
    }


    /* SLIP */

    .slip-section {
        margin-top: 22px;
    }

    .slip-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        gap: 10px;
    }

    .status-label {
        font-size: 13px;
        color: #777;
    }

    .status {
        font-size: 12px;
        font-weight: 700;
        padding: 6px 10px;
        border-radius: 20px;
    }

    .status.pending {
        background: #fff6d8;
        color: #9a7200;
    }

    .status.rejected {
        background: #ffe7e7;
        color: #c62828;
    }


    /* SLIP IMAGE */

    .slip-preview {
        background: #f7f7f7;
        border: 1px solid #eee;
        border-radius: 15px;
        padding: 12px;
        text-align: center;
    }

    .slip-preview img {
        display: block;
        width: 100%;
        max-width: 300px;
        max-height: 420px;
        object-fit: contain;
        margin: 0 auto;
        border-radius: 10px;
        background: #fff;
    }

    .slip-caption {
        color: #888;
        font-size: 11px;
        margin-top: 10px;
    }


    /* UPLOAD */

    .upload-form {
        margin-top: 22px;
    }

    .upload-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Prompt', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: #000;
        margin-bottom: 10px;
    }

    .upload-label i {
        color: #000;
    }

    .file-input {
        display: block;
        width: 100%;
        padding: 11px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #fafafa;
        font-family: 'Chakra Petch', sans-serif;
        font-size: 12px;
        cursor: pointer;
    }

    .file-input:hover {
        border-color: #ffcc00;
    }


    /* BUTTON */

    .upload-button {
        width: 100%;
        margin-top: 14px;
        padding: 15px;
        border: none;
        border-radius: 12px;
        background: #ffcc00;
        color: #000;
        font-family: 'Prompt', sans-serif;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.25s;
        box-shadow: 0 8px 20px rgba(255, 204, 0, 0.25);
    }

    .upload-button:hover {
        background: #000;
        color: #ffcc00;
        transform: translateY(-2px);
    }


    /* MOBILE */

    @media (max-width: 576px) {

        .payment-card {
            padding: 25px 20px;
            margin-top: 25px;
        }

        .payment-header h3 {
            font-size: 18px;
        }

        .payment-row {
            font-size: 13px;
        }

        .payment-total strong {
            font-size: 20px;
        }

        .slip-status {
            align-items: flex-start;
            flex-direction: column;
        }

    }

</style>