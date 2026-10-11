<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AboutImage;

class AboutSetting extends Model
{
    // ระบุชื่อตารางให้ตรงกับใน HeidiSQL เป๊ะๆ
    protected $table = 'about_settings';

    protected $fillable = [
        'hero_title',
        'story_description',
        'stat_years',
        'stat_cuts',
        'stat_satisfaction',
        'image_path' // บันทึกรูปภาพตัวเดียวเดิม ถ้าต้องการยังคงเก็บไว้ (จะใช้เป็นภาพหลัก)
    ];

    /**
     * นิยามความสัมพันธ์กับตารางรูปภาพเพิ่มเติม
     */
    public function images()
    {
        return $this->hasMany(AboutImage::class, 'about_setting_id');
    }
}
