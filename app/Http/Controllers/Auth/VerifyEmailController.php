<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // 1. ถ้ากดยืนยันแล้ว ให้ไปที่หน้า admin.dashboard (ตามชื่อที่ตั้งใน web.php)
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1');
        }

        // 2. ถ้าเพิ่งยืนยันผ่าน ให้บันทึกและส่ง Event
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // 3. ยืนยันสำเร็จแล้ว ส่งไปหน้า Admin Dashboard
        return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1');
    }
}