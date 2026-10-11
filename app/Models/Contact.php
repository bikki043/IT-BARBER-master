<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'address', 'phone', 'email', 'facebook', 
        'instagram', 'line_id', 'google_map_iframe'
    ];
}