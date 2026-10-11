<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * แสดงหน้าฟอร์มแก้ไขข้อมูลติดต่อ
     */
    public function edit()
    {
        // ดึงข้อมูลแถวแรก ถ้าไม่มีให้สร้าง Object เปล่าขึ้นมา (ป้องกัน Error ใน Blade)
        $contact = Contact::first() ?? new Contact();
        
        return view('admin.contact.edit', compact('contact'));
    }

    /**
     * อัปเดตข้อมูลลงฐานข้อมูล
     */
    public function update(Request $request)
    {
        // Validation เบื้องต้น
        $request->validate([
            'phone' => 'nullable|string|max:20',
            'line_id' => 'nullable|string|max:50',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'address' => 'nullable|string',
            'google_map_iframe' => 'nullable|string',
        ]);

        // ค้นหาข้อมูลแถวแรก
        $contact = Contact::first();

        if ($contact) {
            // ถ้ามีข้อมูลอยู่แล้ว ให้ Update
            $contact->update($request->all());
        } else {
            // ถ้ายังไม่มีข้อมูลเลย (เช่น เพิ่งติดตั้งระบบ) ให้ Create ใหม่
            Contact::create($request->all());
        }

        return redirect()->back()->with('success', 'อัปเดตข้อมูลการติดต่อเรียบร้อยแล้ว!');
    }
}