<?php

namespace App\Http\Controllers;

use App\Models\AboutSetting; // อย่าลืม Use Model ด้วย
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลแถวแรกสุดจากฐานข้อมูล พร้อมกับ gallery images
        $about = AboutSetting::with('images')->first();

        // ส่งตัวแปร $about ไปที่ไฟล์ resources/views/aboutus.blade.php
        return view('aboutus', compact('about'));
    }
}
