<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;
use App\Models\AboutImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutManagementController extends Controller
{
    /**
     * หน้าฟอร์มแก้ไขข้อมูล
     */
    public function edit()
    {
        // ดึงข้อมูลแถวแรกมา ถ้าไม่มีให้สร้าง instance ใหม่พร้อมค่า Default
        // ลาก relationship images มาเพื่อให้สามารถวนดูที่หน้าฟอร์มได้
        $about = AboutSetting::with('images')->first() ?? new AboutSetting([
            'hero_title' => 'THE LEGACY',
            'story_description' => 'Enter your shop history here...',
            'stat_years' => 0,
            'stat_cuts' => 0,
            'stat_satisfaction' => 100,
        ]);

        return view('admin.about.edit', compact('about'));
    }

    /**
     * ฟังก์ชันอัปเดตข้อมูล
     */
    public function update(Request $request)
    {
        // ค้นหา ID ที่ 1 ถ้าไม่มีให้สร้าง instance ใหม่ (เพื่อบันทึกเป็น ID 1 เสมอ)
        $about = AboutSetting::find(1) ?: new AboutSetting();
       


        // ตรวจสอบข้อมูลที่ส่งมา
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'story_description' => 'required|string',
            'stat_years' => 'required',
            'stat_cuts' => 'required',
            'stat_satisfaction' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // กำหนดกฎสำหรับอาร์เรย์รูปภาพใหม่ (หลายไฟล์)
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // จัดการเรื่องรูปภาพหลัก (เดิม)
        if ($request->hasFile('image')) {
            if ($about->image_path && Storage::disk('public')->exists($about->image_path)) {
                Storage::disk('public')->delete($about->image_path);
            }
            $path = $request->file('image')->store('about', 'public');
            $about->image_path = $path;
        }

        // นำข้อมูลจาก Request ใส่เข้าไปใน Model (ยกเว้นรูปภาพที่เราจัดการแยกไปแล้ว)
        $about->fill($request->only([
            'hero_title',
            'story_description',
            'stat_years',
            'stat_cuts',
            'stat_satisfaction'
        ]));

        // บังคับให้เป็น ID 1 และบันทึกก่อนเพื่อให้ไอดีมีอยู่ (จำเป็นสำหรับ gallery)
        $about->id = 1;
        $about->save();

        // ถ้ามีไฟล์ gallery ใหม่ ให้เก็บไว้เป็นเรคคอร์ดในตาราง about_images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $uploaded) {
                $path = $uploaded->store('about', 'public');
                $about->images()->create([ 'image_path' => $path ]);
            }
        }

        return redirect()->back()->with('success', 'บันทึกข้อมูล "IT BARBER - The Legacy" เรียบร้อยแล้ว!');
    }

    /**
     * ลบรูปภาพ gallery อันใดอันหนึ่ง
     */
    public function destroyImage($id)
    {
        $image = AboutImage::findOrFail($id);

        // ลบไฟล์จาก disk
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return redirect()->back()->with('success', 'ลบรูปภาพออกจากเกี่ยวกับเราเรียบร้อยแล้ว');
    }
}