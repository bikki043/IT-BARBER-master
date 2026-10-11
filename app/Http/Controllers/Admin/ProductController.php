<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลสินค้าทั้งหมด
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function store(Request $request)
    {
        // 1. ตรวจสอบข้อมูล (Validation)
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'cat' => 'required',
            'description' => 'nullable',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // รูปหลักต้องมี
            'image_file2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_file3' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. จัดการอัปโหลดรูปภาพจากเครื่อง
        $img1 = null;
        $img2 = null;
        $img3 = null;

        // รูปที่ 1 (บังคับ)
        if ($request->hasFile('image_file')) {
            $img1 = $request->file('image_file')->store('products', 'public');
        }

        // รูปที่ 2 (ถ้ามี)
        if ($request->hasFile('image_file2')) {
            $img2 = $request->file('image_file2')->store('products', 'public');
        }

        // รูปที่ 3 (ถ้ามี)
        if ($request->hasFile('image_file3')) {
            $img3 = $request->file('image_file3')->store('products', 'public');
        }

        // 3. บันทึกลงฐานข้อมูล
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'cat' => $request->cat,
            'description' => $request->description,
            'img' => $img1,  // เก็บพาธไฟล์รูปหลัก
            'img2' => $img2, // เก็บพาธไฟล์รูปที่ 2
            'img3' => $img3, // เก็บพาธไฟล์รูปที่ 3
        ]);

        return redirect()->back()->with('success', 'เย้! เพิ่มสินค้าและอัปโหลดรูปภาพเรียบร้อยแล้วครับพี่');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // 1. ลบไฟล์รูปภาพทั้งหมดที่อยู่ใน Storage ออกจากเครื่องจริงๆ
        $images = [$product->img, $product->img2, $product->img3];
        foreach ($images as $image) {
            if ($image && !str_starts_with($image, 'http')) {
                Storage::disk('public')->delete($image);
            }
        }

        // 2. ลบข้อมูลในฐานข้อมูล
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'ลบสินค้าและไฟล์รูปภาพเรียบร้อยแล้ว!');
    }

    // ฟังก์ชันเปิดหน้าแก้ไข
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product')); // ชี้ไปที่โฟลเดอร์ admin/products/edit.blade.php
    }

    // ฟังก์ชันอัปเดตข้อมูล
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // อัปเดตข้อมูลทั่วไป
        $product->name = $request->name;
        $product->price = $request->price;
        $product->cat = $request->cat;
        $product->description = $request->description;

        // การจัดการรูปภาพ (เช็คว่ามีการอัปโหลดมาใหม่ไหม)
        if ($request->hasFile('image_file')) {
            $product->img = $request->file('image_file')->store('products', 'public');
        }
        if ($request->hasFile('image_file2')) {
            $product->img2 = $request->file('image_file2')->store('products', 'public');
        }
        if ($request->hasFile('image_file3')) {
            $product->img3 = $request->file('image_file3')->store('products', 'public');
        }

        $product->save(); // <--- ตัวนี้สำคัญที่สุด ถ้าไม่มี ข้อมูลจะไม่เปลี่ยนครับ

        return redirect()->route('admin.products.index')->with('success', 'อัปเดตข้อมูลสำเร็จ');
    }
}
