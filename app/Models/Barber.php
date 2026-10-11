<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <--- 1. เพิ่มตัวนี้
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barber extends Model
{
    use SoftDeletes; // <--- 2. เรียกใช้งานตัวนี้

    protected $fillable = [
        'name',
        'position',
        'specialty',
        'branch',
        'image_path',
        'is_active'
    ];

    /**
     * ความสัมพันธ์: ช่างหนึ่งคน มีการนัดหมายได้หลายรายการ
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}