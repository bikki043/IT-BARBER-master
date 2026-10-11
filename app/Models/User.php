<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | AdminLTE Integration (เพิ่มส่วนนี้เข้าไปครับ)
    |--------------------------------------------------------------------------
    */

    /**
     * ฟังก์ชันสำหรับ AdminLTE ดึงรูปโปรไฟล์มาโชว์บน Navbar (มุมขวาบน)
     */
    public function adminlte_image()
    {
        // ถ้ามีรูปในฐานข้อมูลให้ดึงมาโชว์ ถ้าไม่มีให้ใช้รูป Default จาก UI Avatars (สีทอง-ดำ)
        return $this->image_path 
            ? asset('storage/' . $this->image_path) 
            : 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=c5a059&color=1a1a1a';
    }

    /**
     * ข้อความที่จะแสดงใต้ชื่อในเมนู Dropdown
     */
    public function adminlte_desc()
    {
        return 'ผู้ดูแลระบบสูงสุด';
    }

    /**
     * ลิงก์ที่จะไปเมื่อกดที่รูปโปรไฟล์
     */
    public function adminlte_profile_url()
    {
        return 'admin/profile';
    }

    
}