<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // 1. ตรวจสอบข้อมูลเบื้องต้น
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. พยายามเข้าสู่ระบบ
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // 3. เข้าได้แล้ว ส่งไปหน้า Dashboard ของ Admin ทันที! (ไม่เช็ค Role แล้ว)
            return redirect()->route('admin.dashboard');
        }

        // 4. ถ้าอีเมลหรือรหัสผ่านผิด ให้แจ้งเตือนที่หน้า Login
        return back()->withErrors([
            'email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        // 1. สั่ง Logout ออกจากระบบ
        Auth::guard('web')->logout();

        // 2. ล้าง Session และ Token เพื่อความปลอดภัย
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. ✨ เปลี่ยนจาก redirect('/') เป็นหน้า Login
        return redirect()->route('login')->with('status', 'คุณออกจากระบบเรียบร้อยแล้ว');
    }
}
