<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. เช็คว่าล็อกอินหรือยัง (ใช้ guard 'web' สำหรับ admin)
        // 2. เช็คว่าเป็น Admin จริงไหม (สมมติว่าดูจาก email หรือมีคอลัมน์ role)
        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        // ถ้าไม่ใช่ Admin ให้ดีดไปหน้า Login หรือหน้าแรก
        return redirect('/login')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
    }
}