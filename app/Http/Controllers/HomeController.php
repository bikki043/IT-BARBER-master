<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\Service;
use App\Models\Barber; // 1. อย่าลืมนำเข้า Model นี้

class HomeController extends Controller
{
    public function index()
    {
        // 2. ดึงข้อมูลช่างทั้งหมด เพื่อส่งไปให้หน้า Welcome
        $barbers = Barber::all(); 
        
        $latestWorks = Work::latest()->take(8)->get();
        $services = Service::all();

        $quotes = [
            ["text" => "ทรงผมที่ดี คือการลงทุนที่คุ้มค่าที่สุด", "author" => "IT BARBER"],
            ["text" => "ความมั่นใจเริ่มต้นที่กรรไกรของช่าง", "author" => "Barber Wisdom"]
        ];
        $randomQuote = $quotes[array_rand($quotes)];

        // 3. เพิ่ม 'barbers' ลงไปใน compact
        return view('welcome', compact('latestWorks', 'services', 'randomQuote', 'barbers'));
    }
}