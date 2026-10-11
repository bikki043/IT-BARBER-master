<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutImage extends Model
{
    protected $table = 'about_images';

    protected $fillable = [
        'about_setting_id',
        'image_path',
        'sort_order',
    ];

    public function about()
    {
        return $this->belongsTo(AboutSetting::class, 'about_setting_id');
    }
}
