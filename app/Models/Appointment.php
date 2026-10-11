<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_id',
        'barber_id',
        'service_id',
        'branch',
        'appointment_date',
        'appointment_time',
        'status',
        'payment_slip',
        'payment_status',
        'slip_uploaded_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'slip_uploaded_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'customer_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}