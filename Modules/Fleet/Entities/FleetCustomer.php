<?php

namespace Modules\Fleet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FleetCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'workspace',
        'created_by',
    ];

    protected static function newFactory()
    {
        return \Modules\Fleet\Database\factories\FleetCustomerFactory::new();
    }

    public function CustomerUser()
    {
        return FleetCustomer::where('id',$this->user_id)->first();

    }
}
