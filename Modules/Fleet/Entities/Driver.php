<?php

namespace Modules\Fleet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'lincese_number',
        'lincese_type',
        'expiry_date',
        'join_date',
        'address',
        'dob',
        'Working_time',
        'driver_status',
        'workspace',
        'created_by',
    ];

    protected static function newFactory()
    {
        return \Modules\Fleet\Database\factories\DriverFactory::new();
    }
}
