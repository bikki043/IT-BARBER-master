<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Service;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarberController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลมาแสดงหน้าแรก
        $barbers = Barber::latest()->get();
        $services = Service::latest()->get();
        $works = Work::latest()->get();

        return view('admin.barbers.index', compact('barbers', 'services', 'works'));
    }

    public function create()
    {
        return view('admin.barbers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required',
            'branch' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('barbers', 'public');
        }

        Barber::create($data);
        return redirect()->route('admin.barbers.index')->with('success', 'เพิ่มช่างเรียบร้อย!');
    }

    public function edit(Barber $barber)
    {
        // จุดนี้สำคัญ: ตรวจสอบว่ามีข้อมูลจริงไหม
        if (!$barber) {
            return redirect()->route('admin.barbers.index')->with('error', 'ไม่พบข้อมูลช่าง');
        }

        return view('admin.barbers.edit', compact('barber'));
    }

    public function update(Request $request, Barber $barber)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required',
            'branch' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // ลบรูปเก่าถ้ามี
            if ($barber->image_path && Storage::disk('public')->exists($barber->image_path)) {
                Storage::disk('public')->delete($barber->image_path);
            }
            $data['image_path'] = $request->file('image')->store('barbers', 'public');
        }

        $barber->update($data); // อัปเดตข้อมูล
        return redirect()->route('admin.barbers.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย!');
    }

    public function destroy(Barber $barber)
    {
        if ($barber->image_path) {
            Storage::disk('public')->delete($barber->image_path);
        }
        $barber->delete();
        return redirect()->route('admin.barbers.index')->with('success', 'ลบข้อมูลเรียบร้อย');
    }

    // --- เพิ่มฟังก์ชันจัดการผลงาน (Work) ให้พี่ตามที่สัญญาไว้ ---

    public function storeWork(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5000',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('works', 'public');
            
            Work::create([
                'title' => $request->title,
                'image_path' => $path
            ]);

            return redirect()->back()->with('success', 'อัปโหลดผลงานเรียบร้อย!');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการอัปโหลด');
    }

    public function destroyWork(Work $work)
    {
        if ($work->image_path) {
            Storage::disk('public')->delete($work->image_path);
        }
        $work->delete();
        return redirect()->back()->with('success', 'ลบรูปผลงานเรียบร้อย');
    }
}