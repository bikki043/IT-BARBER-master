<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // อย่าลืม Import Model สินค้า

class CartController extends Controller
{
    // หน้าแสดงรายการในตะกร้า
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // ฟังก์ชันจัดการเพิ่มสินค้าลง Session
    public function store(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += (int) $request->input('quantity', 1);
        } else {
            $cart[$id] = [
                "id" => $product->id, // <-- เพิ่มบรรทัดนี้เข้าไปครับ ***สำคัญมาก***
                "name" => $product->name,
                "quantity" => (int) $request->quantity,
                "price" => $product->price,
                "img" => $product->img
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('added_to_cart', 'เพิ่ม ' . $product->name . ' ลงในตะกร้าแล้ว!');
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }

            // ส่งค่ากลับไปบอก JavaScript ว่า "ลบสำเร็จแล้วนะ"
            return response()->json([
                'status' => 'success',
                'message' => 'ลบสินค้าเรียบร้อย'
            ]);
        }
    }
}
