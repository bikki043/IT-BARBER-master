<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Work;
use App\Models\Barber;


class WelcomeController extends Controller
{
    public function index()
    {
        // 1. ดึงสถิติจริงจาก Database
        $totalOrders = Order::count();
        $totalCustomers = Customer::count();
        $totalStyles = Work::count();

        // 2. ดึงข้อมูลช่างตัดผม
        $barbers = Barber::all();

        // 3. ดึงผลงานล่าสุด (เอาแค่ 10 อัน)
        $latestWorks = Work::latest()->take(10)->get();

        // 4. ส่งข้อมูลทั้งหมดไปที่หน้า welcome
        return view('welcome', compact(
            'totalOrders', 
            'totalCustomers', 
            'totalStyles', 
            'barbers', 
            'latestWorks'
        ));
    }
}