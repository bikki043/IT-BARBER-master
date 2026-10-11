<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Booking;


class Customer extends Authenticatable
{
    use Notifiable; // เพิ่มตัวนี้เข้าไปเพื่อให้รองรับระบบแจ้งเตือน/ลืมรหัสผ่าน

    protected $table = 'customers'; // ยืนยันว่าใช้ตารางชื่อ customers

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'google_id',
        'image_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * สำหรับ Laravel 10+ หรือ 11+ 
     * ควรเพิ่มการ Cast password ให้เป็น hashed อัตโนมัติ (ถ้าต้องการ)
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
        public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\CustomerResetPassword($token));
    }
}
