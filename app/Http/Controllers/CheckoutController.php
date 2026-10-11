<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // 1. หน้าแสดงฟอร์ม Checkout
    public function index()
    {
        $cart = session()->get('cart', []);

        if (!$cart || count($cart) === 0) {
            return redirect()->route('shop.index')->with('error', 'ไม่มีสินค้าในตะกร้า');
        }

        return view('checkout', compact('cart'));
    }

    // 2. รับค่าที่อยู่ และแสดงหน้ายืนยันการชำระเงิน
    public function processPayment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'province' => 'required|string',
            'zipcode' => 'required|string|max:10',
        ]);

        // ดึงตะกร้าล่าสุดออกมาคำนวณอีกครั้งเพื่อความแม่นยำ
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'ตะกร้าสินค้าว่างเปล่า');
        }

        // เก็บข้อมูลที่อยู่ไว้ใน Session
        session()->put('pending_order', $request->only(['name', 'phone', 'address', 'province', 'zipcode']));
        session()->save();

        return view('payment_confirm', [
            'orderData' => $request->all(),
            'cart' => $cart // ส่งค่าล่าสุดไปแสดงผลที่หน้ายืนยัน
        ]);
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');

            // ตรวจสอบว่ามีสินค้านี้ในตะกร้าจริงไหม
            if (isset($cart[$request->id])) {
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);
                session()->save(); // บันทึกค่าลง Session จริงๆ
                return response()->json(['status' => 'success']);
            }
        }
        return response()->json(['status' => 'error'], 400);
    }

    // ฟังก์ชันลบสินค้า (ถ้าเรียกใช้จากหน้า Checkout/Cart ผ่าน AJAX)
    // ไฟล์: App\Http\Controllers\CartController.php

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
                session()->save(); // <--- สำคัญมาก: ต้องมีบรรทัดนี้
            }
            return response()->json(['status' => 'success']);
        }
    }

    // 3. บันทึกลงฐานข้อมูลจริง
    public function finalConfirm()
    {
        $orderData = session()->get('pending_order');
        $cart = session()->get('cart', []);

        // ✨ ดึงข้อมูลลูกค้าที่ Login อยู่
        $user = auth()->guard('customer')->user();

        if (!$orderData || empty($cart)) {
            return redirect()->route('checkout.index')->with('error', 'ข้อมูลการสั่งซื้อไม่ครบถ้วน');
        }

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // บันทึกตาราง Orders
            $order = new Order();

            // ✅ จุดสำคัญ: ถ้าลูกค้า Login อยู่ ให้บันทึก ID เขาลงไปด้วย
            if ($user) {
                $order->customer_id = $user->id;
            }

            $order->customer_name = $orderData['name'];
            $order->phone = $orderData['phone'];
            $order->address = $orderData['address'] . ' จังหวัด ' . $orderData['province'] . ' ' . $orderData['zipcode'];
            $order->total_amount = $totalAmount;
            $order->status = 'pending';
            $order->save();

            // บันทึกตาราง OrderItems
            // โค้ดที่ต้องตรวจสอบในไฟล์ที่ใช้ Checkout
            foreach (session('cart') as $id => $details) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $details['id'] ?? $id, // <-- ตรวจสอบให้แน่ใจว่าได้ส่งค่านี้ไป
                    'product_name' => $details['name'],
                    'price'      => $details['price'],
                    'quantity'   => $details['quantity'],
                ]);
            }

            DB::commit();

            session()->forget(['cart', 'pending_order']);
            session()->save();

            // เปลี่ยนให้ redirect ไปหน้า profile เพื่อโชว์ว่าข้อมูล "ไม่หาย"
            return redirect()->route('shop.index')->with('success', 'สั่งซื้อสำเร็จ! เลขที่ใบสั่งซื้อของคุณคือ #' . $order->id);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('checkout.index')->with('error', 'ระบบขัดข้อง: ' . $e->getMessage());
        }
    }
}
