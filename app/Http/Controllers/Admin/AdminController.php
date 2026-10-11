<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Work;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class AdminController extends Controller
{
    /**
     * หน้า Dashboard
     * แสดงสถิติรายวัน รายเดือน และหาวันที่ยอดขายดีที่สุด
     */
    /**
     * หน้า Dashboard
     * แสดงสถิติรายวัน รายเดือน และหาวันที่ยอดขายดีที่สุด
     */
    public function index()
    {
        // 1. ตั้งค่าเวลาปัจจุบัน
        $today = Carbon::today('Asia/Bangkok');
        $startOfMonth = Carbon::now('Asia/Bangkok')->startOfMonth();
        $endOfMonth = Carbon::now('Asia/Bangkok')->endOfMonth();

        // 2. ดึงรายการจอง (Pending ทั้งหมด + Completed ของวันนี้)
        $bookings = Appointment::with(['service', 'barber', 'customer'])
            ->where(function ($query) use ($today) {
                $query->where('status', 'pending')
                    ->orWhere(function ($q) use ($today) {
                        $q->where('status', 'completed')
                            ->whereDate('updated_at', $today);
                    });
            })
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // 3. คำนวณรายได้วันนี้
        $todayEarnings = Appointment::where('status', 'completed')
            ->whereDate('appointment_date', $today)
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->sum('services.price');

        // 4. คำนวณรายได้รวมเดือนนี้
        $monthlyEarnings = Appointment::where('status', 'completed')
            ->whereBetween('appointment_date', [$startOfMonth, $endOfMonth])
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->sum('services.price');

        // 5. หาวันที่ "ยอดปังที่สุด"
        $bestDay = Appointment::where('status', 'completed')
            ->whereBetween('appointment_date', [$startOfMonth, $endOfMonth])
            ->select('appointment_date', DB::raw('count(*) as total_bookings'))
            ->groupBy('appointment_date')
            ->orderBy('total_bookings', 'desc')
            ->first();

        // กำหนดชื่อตัวแปรให้ตรงกับที่ Blade เรียกใช้
        $monthlyRevenue = $monthlyEarnings;

        return view('admin.dashboard', compact(
            'bookings',
            'todayEarnings',
            'monthlyEarnings',
            'monthlyRevenue',
            'bestDay',
            'today'
        ));
    }
    /**
     * กดเสร็จสิ้นงาน
     */
    public function completeAppointment(Request $request, $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->status = 'completed';
            $appointment->save();

            return redirect()->route('admin.dashboard')->with('success', 'ปิดงานเรียบร้อย!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
        }
    }

    /**
     * 🔴 ยกเลิกรายการจองคิว
     */
    public function cancelAppointment(Request $request, $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->status = 'cancelled';
            $appointment->save();

            return redirect()->route('admin.dashboard')->with('success', 'ยกเลิกการจองคิวเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
        }
    }


    // 1. พิมพ์ใบเสร็จรายบุคคล (Thermal 80mm)
    public function receiptPDF($id)
    {
        $appointment = Appointment::with('service', 'barber')->findOrFail($id);

        $pdf = Pdf::loadView('admin.appointments.receipt', compact('appointment'))
            ->setPaper([0, 0, 226, 500], 'portrait'); // ขนาด 80mm สำหรับเครื่องพิมพ์ความร้อน

        return $pdf->stream('receipt-' . $id . '.pdf');
    }

    // 2. พิมพ์สรุปรายงานคิววันนี้ (A4)
    public function reportPDF()
    {
        $bookings = Appointment::whereDate('appointment_date', today())->get();
        $totalIncome = $bookings->where('status', 'completed')->sum(function ($b) {
            return $b->service->price ?? 0;
        });

        $pdf = Pdf::loadView('admin.appointments.pdf_report', [
            'today' => today(),
            'bookings' => $bookings,
            'totalIncome' => $totalIncome,
            'date' => today()->format('d/m/Y')
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('daily-report-' . today()->format('Y-m-d') . '.pdf');
    }





    /**
     * ระบบจัดการโปรไฟล์
     */
    public function profile()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'กรุณาล็อกอินก่อนเข้าใช้งาน');
        }
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            if ($request->hasFile('image_file')) {
                if ($user->image_path && Storage::disk('public')->exists($user->image_path)) {
                    Storage::disk('public')->delete($user->image_path);
                }
                $user->image_path = $request->file('image_file')->store('profile_pics', 'public');
            }
            $user->save();
            return redirect()->route('admin.profile')->with('success', 'อัปเดตข้อมูลสำเร็จ!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'เกิดปัญหา: ' . $e->getMessage()])->withInput();
        }
    }





    // --- ส่วนจัดการ Services ---
    public function manageServices()
    {
        $services = Service::latest()->get();
        return view('admin.services', compact('services'));
    }

    public function storeService(Request $request)
    {
        // 1. รับค่าจาก URL (ถ้ามี) มาสำรองไว้ก่อน
        $path = $request->image_url_input;

        // 2. เช็คว่าถ้ามีการอัปโหลดไฟล์จริง ให้ใช้ไฟล์ที่อัปโหลดแทน
        if ($request->hasFile('image_file')) {
            // บันทึกลง storage/app/public/services
            $path = $request->file('image_file')->store('services', 'public');
        }

        // 3. บันทึกลงฐานข้อมูล
        $service = new Service();
        $service->name = $request->name;
        $service->price = $request->price;
        $service->duration = $request->duration;
        $service->description = $request->description;
        $service->image_url = $path; // ตรงนี้จะไม่เป็น NULL แล้ว
        $service->save();

        return redirect()->route('admin.services.index')->with('success', 'เพิ่มบริการสำเร็จและอัปโหลดรูปเรียบร้อย!');
    }

    public function editService($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services_edit', compact('service'));
    }

    public function updateService(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name', 'price', 'duration', 'description']);

        if ($request->hasFile('image_file')) {
            // ลบรูปเก่าทิ้งก่อน (ถ้ามี) เพื่อประหยัดพื้นที่
            if ($service->image_url && Storage::disk('public')->exists($service->image_url)) {
                Storage::disk('public')->delete($service->image_url);
            }
            // อัพโหลดรูปใหม่
            $data['image_url'] = $request->file('image_file')->store('services', 'public');
        }

        $service->update($data);
        return redirect()->route('admin.services.index')->with('success', 'แก้ไขสำเร็จ!');
    }

    public function destroyService($id)
    {
        $service = Service::findOrFail($id);
        $service->delete(); // คราวนี้จะไม่เกิด Error 1451 แล้ว แต่มันจะไปเติมวันที่ใน deleted_at แทน

        return redirect()->back()->with('success', 'ปิดการใช้งานบริการเรียบร้อยแล้ว');
    }






    // --- ส่วนจัดการผลงาน ---
    public function manageWorks()
    {
        // ใช้ paginate แทน get() เพื่อรองรับหน้า Blade ที่มีระบบแบ่งหน้า
        $works = Work::latest()->paginate(12);
        return view('admin.works', compact('works'));
    }

    public function storeWork(Request $request)
    {
        // 1. ปรับ Validation ให้รองรับทั้งไฟล์ หรือ URL อย่างใดอย่างหนึ่ง
        $request->validate([
            'title'      => 'required|max:255',
            'image_file' => 'required_without:image_url|image|mimes:jpeg,png,jpg|max:2048',
            'image_url'  => 'required_without:image_file|nullable|url',
        ]);

        $imageUrl = null;

        // 2. ถ้ามีการอัปโหลดไฟล์
        if ($request->hasFile('image_file')) {
            $imageUrl = $request->file('image_file')->store('works', 'public');
        }
        // 3. ถ้ามาเป็นลิงก์ URL
        else {
            $imageUrl = $request->image_url;
        }

        Work::create([
            'title'     => $request->title ?? 'ผลงานใหม่',
            'image_url' => $imageUrl
        ]);

        return redirect()->route('admin.works.index')->with('success', 'เพิ่มผลงานสำเร็จ!');
    }

    // เพิ่มไว้ใน AdminController.php
    public function destroy($id)
    {
        // 1. ค้นหาข้อมูล Work ตาม ID
        // (หมายเหตุ: ถ้าคุณใช้ตาราง Works ให้เปลี่ยน Service เป็น Work ตามชื่อ Model ของคุณ)
        $work = \App\Models\Work::findOrFail($id);

        // 2. ลบไฟล์รูปภาพออกจากเครื่อง (ถ้ามี) เพื่อไม่ให้หนักเครื่อง
        if ($work->image_url && !filter_var($work->image_url, FILTER_VALIDATE_URL)) {
            // ตรวจสอบว่าเป็นไฟล์ที่อยู่ใน storage/app/public หรือไม่
            if (Storage::disk('public')->exists($work->image_url)) {
                Storage::disk('public')->delete($work->image_url);
            }
        }

        // 3. ลบข้อมูลในฐานข้อมูล
        $work->delete();

        // 4. กลับหน้าเดิมพร้อมแจ้งเตือน
        return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว!');
    }

    /**
     * พิมพ์รายงานสรุปรายได้ประจำเดือน (PDF)
     */
    public function reportMonthlyPDF(Request $request)
    {
        // 1. ดึงเดือนและปีจาก Request (ถ้าไม่มีให้ใช้เดือนปัจจุบัน)
        $today = \Carbon\Carbon::now('Asia/Bangkok');
        $month = $request->query('month', $today->month);
        $year = $request->query('year', $today->year);

        // 2. ดึงข้อมูลการจองที่สถานะเป็น 'completed' ในเดือนนั้นๆ
        $bookings = \App\Models\Appointment::with('service')
            ->where('status', 'completed')
            ->whereMonth('appointment_date', $month)
            ->whereYear('appointment_date', $year)
            ->orderBy('appointment_date', 'asc')
            ->get();

        // 3. คำนวณรายได้รวม
        $totalIncome = $bookings->sum(function ($booking) {
            return $booking->service->price ?? 0;
        });

        // 4. สร้าง PDF โดยใช้ View ตัวเดียวกับรายงานรายวัน (หรือสร้างใหม่ตามต้องการ)
        // หมายเหตุ: ต้องติดตั้ง Barryvdh\DomPDF\Facade\Pdf ก่อน
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.appointments.pdf_monthly_report', [ // แก้ชื่อตรงนี้
            'bookings' => $bookings,
            'totalIncome' => $totalIncome,
            'date' => "สรุปรายได้ประจำเดือน " . $today->translatedFormat('F Y')
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('monthly-report.pdf');
    }

    /**
     * ส่งออกรายงานวิเคราะห์ (PDF)
     */
    public function analyticsPDF(Request $request)
    {
        $now  = Carbon::now('Asia/Bangkok');
        $year = (int) $request->query('year', $now->year);

        // รายได้ขายสินค้ารายเดือน (ใช้เงื่อนไขเดียวกับหน้า analytics)
        $products = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', $year)
            ->whereIn('status', ['shipped', 'completed'])
            ->groupBy('month')
            ->pluck('total', 'month');

        // รายได้ค่าบริการตัดผมรายเดือน
        $services = DB::table('appointments')
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->selectRaw('MONTH(appointments.created_at) as month, SUM(services.price) as total')
            ->whereYear('appointments.created_at', $year)
            ->where('appointments.status', 'completed')
            ->groupBy('month')
            ->pluck('total', 'month');

        $serviceData = [];
        $productData = [];
        for ($m = 1; $m <= 12; $m++) {
            $serviceData[] = (float) ($services[$m] ?? 0);
            $productData[] = (float) ($products[$m] ?? 0);
        }

        $pdf = Pdf::loadView('admin.pdf_analytics', [
            'year'        => $year,
            'months'      => ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            'serviceData' => $serviceData,
            'productData' => $productData,
            'printedAt'   => $now->format('d/m/Y H:i'),
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('analytics-' . $year . '.pdf');
    }
} // <--- ตรวจสอบว่ามีปีกกาปิด Class ตรงนี้ด้วย
