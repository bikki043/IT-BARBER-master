<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    // 1. ฟังก์ชันปิดงาน (Complete Booking)
    public function complete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'ปิดงานและบันทึกรายได้เรียบร้อยแล้ว');
    }

    // 2. ฟังก์ชันออกรายงานสรุปประจำวัน PDF
    public function reportPDF()
    {
        $today = Carbon::today();
        $bookings = Appointment::whereDate('appointment_date', $today)
            ->where('status', 'completed')
            ->with('service')
            ->get();

        $pdf = Pdf::loadView('admin.appointments.pdf_report', compact('bookings', 'today'));

        // ตั้งค่า font ภาษาไทย (ถ้าคุณลง font ไว้แล้ว)
        return $pdf->stream('Daily-Report-' . $today->format('Y-m-d') . '.pdf');
    }

    // 3. ฟังก์ชันออกใบเสร็จ PDF
    public function receiptPDF($id)
    {
        $booking = Appointment::with('service')->findOrFail($id);

        // ตั้งขนาดกระดาษเป็น 80mm (สลิปเครื่องพิมพ์ความร้อน)
        $customPaper = [0, 0, 226.77, 500];
        $pdf = Pdf::loadView('admin.appointments.pdf_receipt', compact('booking'))
            ->setPaper($customPaper);

        return $pdf->stream('Receipt-' . $id . '.pdf');
    }

    
    public function updatePayment(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:paid,rejected']);

        Appointment::findOrFail($id)->update(['payment_status' => $request->status]);

        return back()->with('success', 'อัปเดตสถานะการชำระเงินแล้ว');
    }
}
