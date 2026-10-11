<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = Customer::where('google_id', $user->id)
                ->orWhere('email', $user->email)
                ->first();

            if (!$finduser) {
                $finduser = Customer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => Hash::make('itbarber1234'),
                    'image_path' => $user->avatar, // เก็บรูปจาก Google ไว้ใช้แสดงใน Navbar
                ]);
            } else {
                // อัปเดตรูปภาพและ google_id เผื่อมีการเปลี่ยนแปลง
                $finduser->update([
                    'google_id' => $user->id,
                    'image_path' => $user->avatar 
                ]);
            }

            // สั่งล็อกอินผ่าน guard 'customer'
            Auth::guard('customer')->login($finduser, true);
            
            request()->session()->regenerate();

            return redirect('/')->with('success', 'เข้าสู่ระบบสำเร็จ');

        } catch (Exception $e) {
            return redirect('/customer/login')->with('error', 'Login ล้มเหลว: ' . $e->getMessage());
        }
    }
}