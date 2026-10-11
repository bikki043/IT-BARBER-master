<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Appointment; // เรียกใช้ Model Appointment ที่มีอยู่ในระบบ
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $currentYear = date('Y');

        // 1. รายได้จากสินค้า (ตาราง orders) - เหมือนเดิม
        $productMonthly = \App\Models\Order::whereYear('created_at', $currentYear)
            ->whereIn('status', ['shipped', 'completed'])
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // 2. รายได้จากบริการ (Join ตาราง appointments กับ services)
        $serviceMonthly = \DB::table('appointments')
            ->join('services', 'appointments.service_id', '=', 'services.id') // เชื่อมตารางเพื่อเอาค่า price
            ->whereYear('appointments.created_at', $currentYear)
            ->where('appointments.status', 'completed')
            ->selectRaw('MONTH(appointments.created_at) as month, SUM(services.price) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // 3. เตรียมข้อมูลสำหรับ Chart
        $productData = [];
        $serviceData = [];
        for ($i = 1; $i <= 12; $i++) {
            $productData[] = (float)($productMonthly[$i] ?? 0);
            $serviceData[] = (float)($serviceMonthly[$i] ?? 0);
        }

        return view('admin.analytics', compact('productData', 'serviceData'));
    }
}
