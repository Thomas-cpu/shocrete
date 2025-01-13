<?php

namespace Modules\Fleet\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fuel extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_name',
        'vehicle_name',
        'fill_date',
        'fuel_type',
        'quantity',
        'cost',
        'total_cost',
        'odometer_reading',
        'notes',
        'workspace',
        'created_by',
    ];

    protected static function newFactory()
    {
        return \Modules\Fleet\Database\factories\FuelFactory::new();
    }

    public function driver()
    {
        return $this->hasOne(Driver::class, 'id', 'driver_name');
    }

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_name');
    }

    public function FuelType()
    {
        return $this->hasOne(FuelType::class, 'id', 'fuel_type');
    }
}
