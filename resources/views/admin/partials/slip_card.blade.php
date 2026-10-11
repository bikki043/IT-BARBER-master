<div class="card border-0 shadow-lg rounded-20 overflow-hidden mb-4">

    {{-- Header --}}
    <div class="card-header bg-dark text-white border-0 p-4">
        <div class="d-flex align-items-center justify-content-between">

            <div class="d-flex align-items-center">

                <div class="slip-icon mr-3">
                    <i class="fas fa-receipt"></i>
                </div>

                <div>
                    <h5 class="mb-0 font-weight-bold">
                        หลักฐานการชำระเงิน
                    </h5>

                    <small class="text-white-50">
                        ตรวจสอบสลิปการโอนเงินของลูกค้า
                    </small>
                </div>

            </div>

            @if(($appointment->payment_status ?? null) === 'paid')

                <span class="badge badge-success px-3 py-2 rounded-pill">
                    <i class="fas fa-check-circle mr-1"></i>
                    ชำระแล้ว
                </span>

            @elseif(($appointment->payment_status ?? null) === 'rejected')

                <span class="badge badge-danger px-3 py-2 rounded-pill">
                    <i class="fas fa-times-circle mr-1"></i>
                    ไม่ผ่าน
                </span>

            @else

                <span class="badge badge-warning px-3 py-2 rounded-pill">
                    <i class="fas fa-clock mr-1"></i>
                    รอตรวจสอบ
                </span>

            @endif

        </div>
    </div>


    {{-- Body --}}
    <div class="card-body p-4">

        {{-- ข้อมูลยอดเงิน --}}
        <div class="payment-summary mb-4">

            <div>
                <small class="text-muted d-block">
                    ยอดที่ต้องชำระ
                </small>

                <h3 class="mb-0 font-weight-bold text-dark">
                    ฿{{ number_format($appointment->service->price ?? 0, 2) }}
                </h3>
            </div>

            <div class="payment-summary-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>

        </div>


        {{-- ไม่มีสลิป --}}
        @if(empty($appointment->payment_slip))

            <div class="empty-slip">

                <div class="empty-slip-icon">
                    <i class="fas fa-file-image"></i>
                </div>

                <h6 class="font-weight-bold mb-1">
                    ยังไม่มีหลักฐานการโอนเงิน
                </h6>

                <p class="text-muted small mb-0">
                    ลูกค้ายังไม่ได้อัปโหลดสลิป
                </p>

            </div>

        @else

            {{-- สลิป --}}
            <div class="slip-preview">

                <div class="slip-preview-header">

                    <span class="font-weight-bold">
                        <i class="fas fa-image mr-1 text-warning"></i>
                        สลิปที่ลูกค้าอัปโหลด
                    </span>

                    <a
                        href="{{ asset('storage/' . $appointment->payment_slip) }}"
                        target="_blank"
                        class="btn btn-sm btn-outline-dark rounded-pill"
                    >
                        <i class="fas fa-expand mr-1"></i>
                        ดูเต็ม
                    </a>

                </div>


                <div class="slip-image-wrapper">

                    <a
                        href="{{ asset('storage/' . $appointment->payment_slip) }}"
                        target="_blank"
                    >
                        <img
                            src="{{ asset('storage/' . $appointment->payment_slip) }}"
                            alt="หลักฐานการชำระเงิน"
                            class="slip-image"
                        >
                    </a>

                </div>

            </div>


            {{-- สถานะ --}}
            @if(($appointment->payment_status ?? null) === 'rejected')

                <div class="alert alert-danger border-0 rounded-15 mt-4 mb-0">

                    <i class="fas fa-exclamation-circle mr-2"></i>

                    <strong>
                        สลิปไม่ผ่านการตรวจสอบ
                    </strong>

                    <div class="small mt-1">
                        ลูกค้าสามารถอัปโหลดสลิปใหม่ได้
                    </div>

                </div>

            @elseif(($appointment->payment_status ?? null) !== 'paid')

                <div class="alert alert-warning border-0 rounded-15 mt-4 mb-0">

                    <i class="fas fa-clock mr-2"></i>

                    <strong>
                        รอแอดมินตรวจสอบ
                    </strong>

                    <div class="small mt-1">
                        กรุณาตรวจสอบยอดเงินและหลักฐานการโอน
                    </div>

                </div>

            @endif

        @endif

    </div>

</div>


<style>

    /* =====================================
       IT BARBER ADMIN SLIP CARD
    ===================================== */

    .rounded-20 {
        border-radius: 20px !important;
    }

    .rounded-15 {
        border-radius: 15px !important;
    }


    /* Header Icon */

    .slip-icon {
        width: 48px;
        height: 48px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background: #f1c40f;
        color: #000;

        font-size: 20px;
    }


    /* Payment Summary */

    .payment-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 20px;

        background: #f8f9fa;

        border-radius: 18px;

        border-left: 5px solid #f1c40f;
    }

    .payment-summary h3 {
        font-size: 28px;
    }

    .payment-summary-icon {
        width: 50px;
        height: 50px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: #fff3cd;
        color: #b8860b;

        font-size: 20px;
    }


    /* Empty */

    .empty-slip {
        text-align: center;

        padding: 40px 20px;

        background: #f8f9fa;

        border: 2px dashed #dee2e6;

        border-radius: 18px;
    }

    .empty-slip-icon {
        width: 60px;
        height: 60px;

        margin: 0 auto 15px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: #e9ecef;
        color: #adb5bd;

        font-size: 24px;
    }


    /* Slip */

    .slip-preview {
        border: 1px solid #e9ecef;

        border-radius: 18px;

        overflow: hidden;

        background: #fff;
    }

    .slip-preview-header {
        display: flex;

        justify-content: space-between;
        align-items: center;

        padding: 15px 18px;

        background: #f8f9fa;

        border-bottom: 1px solid #e9ecef;
    }

    .slip-image-wrapper {
        padding: 20px;

        text-align: center;

        background: #f1f3f5;
    }

    .slip-image {
        max-width: 100%;

        max-height: 500px;

        object-fit: contain;

        border-radius: 12px;

        box-shadow: 0 8px 25px rgba(0,0,0,0.15);

        transition: 0.25s;
    }

    .slip-image:hover {
        transform: scale(1.01);
    }


    /* Mobile */

    @media (max-width: 576px) {

        .slip-preview-header {
            align-items: flex-start;

            gap: 10px;

            flex-direction: column;
        }

        .payment-summary h3 {
            font-size: 23px;
        }

    }

</style>