<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // กำหนดชื่อตาราง (ถ้าชื่อตารางในฐานข้อมูลคือ products ตัวเล็กทั้งหมด ไม่ต้องใส่ก็ได้ครับ แต่ใส่ไว้ชัวร์กว่า)
    protected $table = 'products';

    // รวมตัวแปรที่อนุญาตให้บันทึกข้อมูลได้ไว้ในชุดเดียว
    protected $fillable = [
        'name', 
        'price', 
        'cat', 
        'description', 
        'img', 
        'img2', 
        'img3'
    ];
}