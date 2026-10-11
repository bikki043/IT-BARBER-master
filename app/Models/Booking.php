<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Booking extends Model
{
    // ในนี้ควรมี $fillable เพื่อให้บันทึกข้อมูลได้
    protected $fillable = ['customer_id', 'service_name', 'booking_date', 'status'];
}