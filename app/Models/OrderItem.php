<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // เพิ่ม 'product_id' เข้าไปใน $fillable
    protected $fillable = ['order_id', 'product_id', 'product_name', 'quantity', 'price'];

    /**
     * เชื่อมโยงไปที่ Model Product เพื่อดึงรูปภาพ
     */
    public function product()
    {
        // ตรวจสอบว่า Model สินค้าของคุณชื่อ Product (P ตัวใหญ่) หรือไม่
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
