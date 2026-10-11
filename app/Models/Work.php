<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Work extends Model
{
    use HasFactory;
    // เปิดให้บันทึกได้ทั้ง 2 ชื่อคอลัมน์ที่พี่อาจจะเคยสร้างไว้
    protected $fillable = ['title', 'image_path', 'image_url'];
}
