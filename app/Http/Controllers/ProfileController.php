<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * หน้าแสดงโปรไฟล์
     */
    public function index(): View
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * หน้าฟอร์มแก้ไขโปรไฟล์
     */
    public function edit(): View
    {
        $user = Auth::user();
        return view('profile-edit', compact('user'));
    }

    /**
     * ฟังก์ชันบันทึกข้อมูล
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone; // มาจากไฟล์ 0001_01_01_000000_create_users_table (ถ้าคุณเพิ่มไว้)

        if ($request->hasFile('avatar')) {
            // ลบรูปเก่าถ้ามี (ใช้ชื่อ image_path ตามไฟล์ 2026_02_23_134627)
            if ($user->image_path && !str_contains($user->image_path, 'googleusercontent')) {
                Storage::disk('public')->delete($user->image_path);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->image_path = $path;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'อัปเดตข้อมูลสำเร็จ!');
    }

    /**
     * ลบบัญชีผู้ใช้
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        /** @var User $user */
        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
