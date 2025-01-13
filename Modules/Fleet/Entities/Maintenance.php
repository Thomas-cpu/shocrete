<?php

namespace Modules\Fleet\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_type',
        'service_for',
        'vehicle_name',
        'maintenance_type',
        'service_name',
        'charge',
        'charge_bear_by',
        'maintenance_date',
        'priority',
        'total_cost',
        'notes',
        'workspace',
        'created_by',

    ];

    protected static function newFactory()
    {
        return \Modules\Fleet\Database\factories\MaintenanceFactory::new();
    }

    public function Employee()
    {
        return $this->hasOne(User::class, 'id', 'service_for');
    }

    public function VehicleName()
    {
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_name');
    }

    public function MaintenanceType()
    {
        return $this->hasOne(MaintenanceType::class, 'id', 'maintenance_type');
    }

    public static function getOrderChart($arrParam)
    {
        $arrDuration = [];
        if($arrParam['duration'])
        {
            if($arrParam['duration'] == 'week')
            {
                $previous_week = strtotime("-1 week +1 day");
                for($i = 0; $i < 7 -1; $i++)
                {
                    $arrDuration[date('Y-m-d', $previous_week)] = date('d-M', $previous_week);
                    $previous_week                              = strtotime(date('Y-m-d', $previous_week) . " +1 day");
                }
            }
        }


        $arrTask          = [];
        $arrTask['label'] = [];
        $arrTask['data']  = [];

        $arrDuration = array_reverse($arrDuration);

        foreach($arrDuration as $date => $label)
        {
            $data               = Maintenance::select(\DB::raw('count(*) as total'))->whereDate('created_at', '=', $date)->first();
            $arrTask['label'][] = __($label);
            $arrTask['data'][]  = $data->total;
        }
       
        return $arrTask;
    }
}
