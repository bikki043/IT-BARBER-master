<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    // ✅ เพิ่ม 'customer_id' เข้าไป เพื่อให้ระบบจำเจ้าของออเดอร์ได้
    protected $fillable = [
        'customer_id',
        'customer_name',
        'phone',
        'address',
        'total_amount',
        'status'
    ];

    /**
     * ดึงรายการสินค้าที่อยู่ในออเดอร์นี้
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * ✅ เพิ่มความสัมพันธ์ย้อนกลับไปหา Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
