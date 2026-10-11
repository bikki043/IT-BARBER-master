<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. เพิ่มบรรทัดนี้

class Service extends Model
{
    

    protected $fillable = [
        'name',
        'price',
        'duration',
        'description',
        'image_url'
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'service_id');
    }
}