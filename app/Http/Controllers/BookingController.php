<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;

class BookingController extends Controller
{
    public function index()
    {
        $barbers = Barber::all();
        $services = Service::all();
        return view('booking', compact('barbers', 'services'));
    }

    // คืนรายการเวลาที่ถูกจองแล้วของวันที่/ช่างที่เลือก (ให้หน้าเว็บทำปุ่มสีแดง)
    public function bookedTimes(Request $request)
    {
        $request->validate([
            'date'      => 'required|date',
            'barber_id' => 'nullable|integer',
        ]);

        $times = Appointment::whereDate('appointment_date', $request->date)
            ->where('status', 'pending')
            ->when($request->barber_id, fn($q, $id) => $q->where('barber_id', $id))
            ->pluck('appointment_time')
            ->map(fn($t) => substr($t, 0, 5)) // 10:00:00 -> 10:00
            ->unique()
            ->values();

        return response()->json($times);
    }

    public function store(Request $request)
    {
        try {
            // กันจองซ้ำ: ช่างคนเดิม วันเดิม เวลาเดิม
            $alreadyBooked = Appointment::whereDate('appointment_date', $request->appointment_date)
                ->where('appointment_time', 'like', substr($request->appointment_time, 0, 5) . '%')
                ->where('barber_id', $request->barber_id ?? 1)
                ->where('status', 'pending')
                ->exists();

            if ($alreadyBooked) {
                return back()->withInput()->with('error', 'เวลานี้ถูกจองแล้ว กรุณาเลือกเวลาอื่น');
            }

            $appointment = new Appointment();

            if (auth()->guard('customer')->check()) {
                $appointment->customer_id = auth()->guard('customer')->id();
            }

            $appointment->customer_name    = $request->customer_name;
            $appointment->customer_phone   = $request->customer_phone;
            $appointment->barber_id        = $request->barber_id ?? 1;
            $appointment->service_id       = $request->service_id;
            $appointment->branch           = $request->branch;
            $appointment->appointment_date = $request->appointment_date;
            $appointment->appointment_time = $request->appointment_time;
            $appointment->status           = 'pending';
            $appointment->save();
           

            session()->put('last_booking_id', $appointment->id);
            session()->save();

            return redirect()->route('booking.payment');
        } catch (\Exception $e) {
            Log::error('Booking Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    public function success()
    {
        $appointment = session('appointment');

        if (!$appointment) {
            $bookingId = session('last_booking_id');
            if ($bookingId) {
                $appointment = Appointment::with(['service', 'barber', 'customer'])->find($bookingId);
            }
        }

        if (!$appointment) {
            return redirect('/booking')->with('error', 'เซสชันหมดอายุ กรุณาตรวจสอบข้อมูลการจอง');
        }

        return view('booking_success', compact('appointment'));
    }

    // อัปโหลดสลิปโอนเงิน
    public function uploadSlip(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $ownsBySession  = (int) session('last_booking_id') === (int) $appointment->id;
        $ownsByCustomer = auth('customer')->check()
            && (int) $appointment->customer_id === (int) auth('customer')->id();
        abort_unless($ownsBySession || $ownsByCustomer, 403);

        $request->validate([
            'slip' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
        ], [
            'slip.required' => 'กรุณาเลือกไฟล์สลิป',
            'slip.image'    => 'ไฟล์ต้องเป็นรูปภาพ',
            'slip.mimes'    => 'รองรับเฉพาะ JPG และ PNG',
            'slip.max'      => 'ไฟล์ต้องมีขนาดไม่เกิน 4 MB',
        ]);

        if ($appointment->payment_slip) {
            Storage::disk('public')->delete($appointment->payment_slip);
        }

        $appointment->update([
            'payment_slip'     => $request->file('slip')->store('slips', 'public'),
            'payment_status'   => 'pending',
            'slip_uploaded_at' => now(),
        ]);

        return redirect()->route('booking.success')->with('success', 'อัปโหลดสลิปเรียบร้อย รอแอดมินตรวจสอบ');
    }

    public function history()
    {
        $user = auth()->guard('customer')->user();

        $appointments = \App\Models\Appointment::with(['service', 'customer'])
            ->where('customer_id', $user->id)
            ->orderBy('appointment_date', 'desc')
            ->get();

        $orders = Order::with(['items.product'])
            ->where('customer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('auth.customer.booking_history', compact('appointments', 'orders'));
    }

    public function payment()
{
    $bookingId = session('last_booking_id');
    $appointment = $bookingId
        ? Appointment::with(['service', 'barber', 'customer'])->find($bookingId)
        : null;

    if (!$appointment) {
        return redirect('/booking')->with('error', 'เซสชันหมดอายุ กรุณาตรวจสอบข้อมูลการจอง');
    }

    // จ่ายแล้ว หรืออัปโหลดสลิปรอตรวจอยู่ ไม่ต้องกลับมาหน้านี้
    if (in_array($appointment->payment_status, ['paid', 'pending'])) {
        return redirect()->route('booking.success');
    }

    return view('booking_payment', compact('appointment'));
}
}