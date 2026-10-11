<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // อย่าลืมเรียกใช้ Model นะครับ

class ShopController extends Controller
{
    public function index()
    {
        // 1. ดึงข้อมูลจากฐานข้อมูลจริง
        $productsFromDB = Product::all();

        // 2. ถ้าใน DB มีข้อมูล ให้ใช้ข้อมูลจาก DB (ซึ่งเป็น Object อยู่แล้ว)
        // แต่ถ้าใน DB ว่างเปล่า ให้ใช้ Dummy Data ของพี่แทน
        if ($productsFromDB->count() > 0) {
            $products = $productsFromDB;
        } else {
            // แปลง Dummy Array ให้เป็น Collection ของ Object เพื่อให้โค้ดในหน้า Blade ไม่พัง
            $products = collect($this->getDummyProducts())->map(function ($item) {
                return (object) $item;
            });
        }

        return view('shop', compact('products'));
    }

    public function show($id)
    {
        // 1. ลองหาในฐานข้อมูลก่อน
        $product = Product::find($id);

        // 2. ถ้าไม่เจอใน DB ให้ไปเช็คใน Dummy Data
        if (!$product) {
            $allDummy = $this->getDummyProducts();
            if (isset($allDummy[$id])) {
                $product = (object) $allDummy[$id];
            } else {
                abort(404);
            }
        }

        return view('shop.shop_show', compact('product'));
    }

    private function getDummyProducts()
    {
        return [
            1 => [
                'id' => 1,
                'name' => 'Pro-X Gold Edition',
                'price' => 2500,
                'cat' => 'Clippers',
                'img' => 'https://images.unsplash.com/photo-1593702275677-f916c6c70ef4?q=80&w=600',
                'description' => 'ปัตตาเลี่ยนสีทองระดับพรีเมียม ออกแบบมาเพื่อช่างมืออาชีพ'
            ],
            2 => [
                'id' => 2,
                'name' => 'Precision Scissor 7"',
                'price' => 1200,
                'cat' => 'Scissors',
                'img' => 'https://images.unsplash.com/photo-1620331311520-246422fd82f9?q=80&w=600',
                'description' => 'กรรไกรตัดผมความแม่นยำสูง ขนาด 7 นิ้ว จับถนัดมือ'
            ],
            // ... (ใส่ข้อมูล Dummy อื่นๆ ของพี่ได้ปกติ)
        ];
    }

    public function addToCart(Request $request)
    {
        // รับ ID สินค้าที่ส่งมา
        $productId = $request->input('id');

        // โค้ดสำหรับเพิ่มลง Session หรือ Database ของคุณ...
        // ตัวอย่างเช่น: Cart::add($productId);

        return back()->with('success', 'เพิ่มสินค้าลงรถเข็นเรียบร้อยแล้ว!');
    }
}
