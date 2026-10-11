<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB; // เพิ่มตัวนี้มาเพื่อใช้จัดการ Transaction

class OrderController extends Controller
{
    /**
     * แสดงรายการสั่งซื้อ (เรียงลำดับออเดอร์ล่าสุดขึ้นก่อน)
     */
    public function index()
    {
        // เรียงตาม ID หรือ created_at จากมากไปน้อย (ล่าสุดจะอยู่บนสุด)
        $orders = Order::with(['items'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * อัปเดตสถานะการจัดส่ง
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // ตรวจสอบข้อมูลเบื้องต้น
        $request->validate([
            'courier' => 'required|string|max:100',
        ]);

        $order->update([
            'status' => 'shipped',
            'courier_name' => $request->courier,
            'updated_at' => now(), // บันทึกเวลาที่ส่งจริง
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'บันทึกการจัดส่งเรียบร้อย!');
    }

    /**
     * ลบออเดอร์ (ปลอดภัยขึ้นด้วย DB Transaction)
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        try {
            DB::beginTransaction(); // เริ่มต้นการลบแบบปลอดภัย

            // ลบรายการสินค้าข้างในออเดอร์ก่อน
            $order->items()->delete();

            // ลบตัวออเดอร์
            $order->delete();

            DB::commit(); // ยืนยันการลบ
            return back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            DB::rollBack(); // หากเกิดข้อผิดพลาด ให้ยกเลิกการลบทั้งหมด
            return back()->with('error', 'ไม่สามารถลบข้อมูลได้: ' . $e->getMessage());
        }
    }

    /**
     * ส่งออก PDF (เรียงตามวันที่ส่งล่าสุดขึ้นก่อน)
     */
    public function exportPDF()
    {
        // เรียงตาม updated_at desc เพื่อให้รายการที่เพิ่งส่งอยู่หน้าแรกๆ ของรายงาน
        $orders = Order::whereIn('status', ['shipped', 'completed'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $data = [
            // ใช้ now() หลังจากตั้งค่าในข้อ 1 แล้ว จะได้เวลาไทยทันที
            'date' => now()->format('d/m/Y H:i'),
            'orders' => $orders
        ];

        // สร้าง PDF
        $pdf = Pdf::loadView('admin.orders.pdf', $data);

        // ตั้งค่าการแสดงผล
        $pdf->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'chroot' => base_path('public'),
                'defaultFont' => 'THSarabunNew' // ตั้งค่าฟอนต์เริ่มต้นถ้าไม่ได้ระบุใน CSS
            ]);

        return $pdf->stream('รายงานการจัดส่ง_IT_BARBER_' . date('dmY') . '.pdf');
    }
}
