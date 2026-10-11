<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer; // ✨ เปลี่ยนจาก User เป็น Customer
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;

class CustomerAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.customer.login');
    }

    public function showRegister()
    {
        return view('auth.customer.register');
    }

    public function showForgot()
    {
        return view('auth.customer.forgot');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // ✨ ระบุ guard('customer') เพื่อให้เช็คที่ตาราง customers
        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers', // ✨ เช็คซ้ำในตาราง customers
            'password' => 'required|string|min:8|confirmed',
        ]);

        // ✨ ใช้ Model Customer เพื่อบันทึกลงตาราง customers
        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // แยกตารางแล้ว ไม่ต้องใส่ role ให้กวนใจครับ
        ]);

        return redirect()->route('customer.login')->with('success', 'สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ');
    }

    public function logout(Request $request)
    {
        // สั่ง Logout เฉพาะ Guard ของลูกค้า
        Auth::guard('customer')->logout();

        // ล้าง Session เพื่อความปลอดภัย
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ส่งกลับไปหน้าแรก หรือหน้า Login
        return redirect('/')->with('success', 'ออกจากระบบเรียบร้อยแล้ว');
    }

    public function profile()
    {
        /** @var \App\Models\Customer $user */
        $user = auth()->guard('customer')->user();

        // 1. ดึงประวัติการสั่งซื้อ (Orders) พร้อมรายการสินค้า
        $orders = \App\Models\Order::where('customer_id', $user->id)
            ->with('items')
            ->latest()
            ->get();

        // 2. ดึงประวัติการจอง (Appointments) **เพิ่มบรรทัดนี้เพื่อแก้ Error**
        $appointments = \App\Models\Appointment::where('customer_id', $user->id)
            ->latest()
            ->get();

        // 3. ส่งตัวแปรทั้งหมดไปที่ View
        return view('auth.customer.profile', compact('user', 'orders', 'appointments'));
    }

    // เพิ่มเข้าไปในไฟล์ CustomerAuthController.php
    public function editProfile()
    {
        // ดึงข้อมูลลูกค้าที่กำลัง Login อยู่
        $user = Auth::guard('customer')->user();

        // ส่งไปที่หน้า View (ตรวจสอบชื่อไฟล์ Blade ให้ตรงกับที่คุณสร้างไว้นะครับ)
        return view('auth.customer.profile-edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\Customer $user */ // ✨ บรรทัดนี้จะทำให้ $user->update หายตัวแดง
        $user = Auth::guard('customer')->user();

        // 1. ตรวจสอบข้อมูลที่ส่งมา
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // 2. จัดการรูปโปรไฟล์
        if ($request->hasFile('image_path')) {
            // ลบรูปเก่า
            if ($user->image_path && Storage::disk('public')->exists($user->image_path)) {
                Storage::disk('public')->delete($user->image_path);
            }

            // บันทึกรูปใหม่ (เก็บพาธไว้ในตัวแปร $path)
            $path = $request->file('image_path')->store('customers', 'public');
            $data['image_path'] = $path;
        }

        // 3. อัปเดตข้อมูล (หายแดงแน่นอน)
        $user->update($data);

        return redirect()->route('customer.profile')->with('success', 'อัปเดตข้อมูลโปรไฟล์เรียบร้อยแล้ว!');
    }


    // ค้นหาฟังก์ชันนี้ในไฟล์ของคุณ
    public function redirectToGoogle()
    {
        /** @var \Laravel\Socialite\Two\GoogleProvider $driver */
        $driver = \Laravel\Socialite\Facades\Socialite::driver('google');

        return $driver->with(['prompt' => 'select_account'])->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->user();

            // 1. ค้นหาลูกค้า
            $customer = \App\Models\Customer::where('email', $googleUser->getEmail())->first();

            if ($customer) {
                // ถ้ามีแล้ว อัปเดต google_id (อันนี้คุณบอกว่าผ่าน ปกติดี)
                $customer->update(['google_id' => $googleUser->getId()]);
            } else {
                // 2. ถ้าสมัครใหม่ (จุดที่มีปัญหา)
                // เราต้องส่งค่าให้ครบทุกคอลัมน์ที่ DB บังคับ (Not Null)
                $customer = \App\Models\Customer::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'image_path' => $googleUser->getAvatar(),
                    'phone'     => null, // หรือ '' ถ้าใน DB ตั้งเป็น Not Null
                    // สำคัญมาก: ต้องใส่รหัสผ่านสุ่มลงไป เพราะตาราง Customer ส่วนใหญ่บังคับมีรหัสผ่าน
                    'password'  => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(16)),
                ]);
            }

            Auth::guard('customer')->login($customer);
            return redirect()->intended('/')->with('success', 'ยินดีต้อนรับคุณ ' . $customer->name);
        } catch (\Exception $e) {
            // ถ้ามันเด้งกลับหน้า Login ให้เอาเครื่องหมาย // ข้างล่างนี้ออกเพื่อดูว่า Error อะไร
            // return dd($e->getMessage()); 

            return redirect()->route('customer.login')->with('error', 'สมัครสมาชิกไม่สำเร็จ: ' . $e->getMessage());
        }
    }
}
