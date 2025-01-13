<?php

namespace Modules\Fleet\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Fleet\Entities\Booking;
use Modules\Fleet\Entities\Driver;
use Modules\Fleet\Entities\Fuel;
use Modules\Fleet\Entities\FuelType;
use Modules\Fleet\Entities\Insurances;
use Modules\Fleet\Entities\Maintenance;
use Modules\Fleet\Entities\Vehicle;
use Modules\Fleet\Entities\VehicleType;
use Modules\Fleet\Events\CreateVehicle;
use Modules\Fleet\Events\DestroyVehicle;
use Modules\Fleet\Events\UpdateVehicle;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if (Auth::user()->isAbleTo('vehicle manage')) {
            if (Auth::user()->type == "company" || Auth::user()->type == "staff") {
                $query = Vehicle::where('created_by', creatorId())->where('workspace', getActiveWorkSpace());
                if (!empty($request->name)) {
                    $query->where('name', 'like', '%' . $request->name . '%');
                }
                if (!empty($request->vehicle_type)) {
                    $query->where('vehicle_type', '=', $request->vehicle_type);
                }
                if (!empty($request->fuel_type)) {
                    $query->where('fuel_type', '=', $request->fuel_type);
                }

                $vehicles = $query->get();
            } else {

                $query = Vehicle::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->where('driver_name', Auth::user()->id);
                if (!empty($request->name)) {
                    $query->where('name', 'like', '%' . $request->name . '%');
                }
                if (!empty($request->vehicle_type)) {
                    $query->where('vehicle_type', '=', $request->vehicle_type);
                }
                if (!empty($request->fuel_type)) {
                    $query->where('fuel_type', '=', $request->fuel_type);
                }
                $vehicles = $query->get();
            }

            $vehicleTypes = VehicleType::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id');
            $fuelType = FuelType::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id');

            return view('fleet::vehicle.index', compact('vehicles', 'vehicleTypes', 'fuelType'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (Auth::user()->isAbleTo('vehicle create')) {
            $vehicleTypes = VehicleType::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id')->prepend('Select Vehicle Types', '');
            $fuelType = FuelType::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id')->prepend('Select Fuel Type', '');
            $DriverName = Driver::where('workspace', getActiveWorkSpace())->where('created_by', '=', creatorId())->get()->pluck('name', 'id')->prepend('Select Driver Name', '');

            if(module_is_active('CustomField')){
                $customFields =  \Modules\CustomField\Entities\CustomField::where('workspace_id',getActiveWorkSpace())->where('module', '=', 'Fleet')->where('sub_module','Vehicle')->get();
            }else{
                $customFields = null;
            }
            return view('fleet::vehicle.create', compact('vehicleTypes', 'fuelType', 'DriverName','customFields'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (Auth::user()->isAbleTo('vehicle create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name'          => 'required',
                    'vehicle_type'  => 'required',
                    'fuel_type'     => 'required',
                    'driver_name'   => 'required',
                    'lincense_plate'   => 'required',
                    'vehical_id_num'   => 'required',
                    'model_year'   => 'required',
                    'seat_capacity' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
            }

            $Vehicle = new Vehicle();
            $Vehicle->name                  = $request->name;
            $Vehicle->vehicle_type          = $request->vehicle_type;
            $Vehicle->fuel_type             = $request->fuel_type;
            $Vehicle->registration_date     = $request->registration_date;
            $Vehicle->register_ex_date      = $request->register_ex_date;
            $Vehicle->lincense_plate        = $request->lincense_plate;
            $Vehicle->vehical_id_num        = $request->vehical_id_num;
            $Vehicle->model_year            = $request->model_year;
            $Vehicle->driver_name           = $request->driver_name;
            $Vehicle->seat_capacity         = $request->seat_capacity;
            $Vehicle->status                = $request->status;
            $Vehicle->workspace             = getActiveWorkSpace();
            $Vehicle->created_by            = creatorId();
            $Vehicle->save();

            if(module_is_active('CustomField'))
            {
                \Modules\CustomField\Entities\CustomField::saveData($Vehicle, $request->customField);
            }
            event(new CreateVehicle($request, $Vehicle));
            $vehicleTypes = VehicleType::find($request->vehicle_type);

            if(!empty(company_setting('New Vehicle')) && company_setting('New Vehicle')  == true)
            {
                $User        = Driver::where('id', $request->driver_name)->where('workspace', '=',  getActiveWorkSpace())->first();
                $uArr = [
                    'vehicle_name'=>$request->name,
                    'driver_name'=>$User->name,
                    'vehicle_type'=>$vehicleTypes->name,
                ];

                try
                {
                    $resp = EmailTemplate::sendEmailTemplate('New Vehicle', [$User->email], $uArr);
                }
                catch(\Exception $e)
                {

                    $resp['error'] = $e->getMessage();
                }
                return redirect()->route('vehicle.index')->with('success', __('Vehicle successfully created.'). ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
            }

            return redirect()->route('vehicle.index')->with('success', __('Vehicle  successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return redirect()->back();
        return view('fleet::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Vehicle $vehicle)
    {
        if (Auth::user()->isAbleTo('vehicle edit')) {
            $vehicleTypes = VehicleType::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id')->prepend('Select Vehicle Types', '');
            $FuelType = FuelType::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id')->prepend('Select Fuel Type', '');
            $DriverName = Driver::where('workspace', getActiveWorkSpace())->where('created_by', '=', creatorId())->get()->pluck('name', 'id')->prepend('Select Driver Name', '');

            for ($i = 0; $i <= 17; $i++) {
                $data = date('Y', strtotime('-15 years' . " +$i years"));
                $years[$data] = $data;
            }
            if(module_is_active('CustomField')){
                $vehicle->customField = \Modules\CustomField\Entities\CustomField::getData($vehicle, 'Fleet','Vehicle');
                $customFields             = \Modules\CustomField\Entities\CustomField::where('workspace_id', '=', getActiveWorkSpace())->where('module', '=', 'Fleet')->where('sub_module','Vehicle')->get();
            }else{
                $customFields = null;
            }
            return view('fleet::vehicle.edit', compact('vehicleTypes', 'FuelType', 'DriverName', 'vehicle', 'years','customFields'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        if (Auth::user()->isAbleTo('vehicle edit')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name'          => 'required',
                    'vehicle_type'  => 'required',
                    'fuel_type'     => 'required',
                    'registration_date' => 'required',
                    'lincense_plate' => 'required',
                    'vehical_id_num' => 'required',
                    'model_year' => 'required',
                    'driver_name'   => 'required',
                    'seat_capacity' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $vehicle->name              = $request->name;
            $vehicle->vehicle_type      = $request->vehicle_type;
            $vehicle->fuel_type         = $request->fuel_type;
            $vehicle->registration_date     = $request->registration_date;
            $vehicle->register_ex_date  = $request->register_ex_date;
            $vehicle->lincense_plate    = $request->lincense_plate;
            $vehicle->vehical_id_num    = $request->vehical_id_num;
            $vehicle->model_year        = $request->model_year;
            $vehicle->driver_name       = $request->driver_name;
            $vehicle->status            = $request->status;
            $vehicle->seat_capacity     = $request->seat_capacity;
            $vehicle->workspace         = getActiveWorkSpace();
            $vehicle->created_by        = creatorId();
            $vehicle->save();
            if(module_is_active('CustomField'))
            {
                \Modules\CustomField\Entities\CustomField::saveData($vehicle, $request->customField);
            }
            event(new UpdateVehicle($request, $vehicle));

            return redirect()->route('vehicle.index')->with('success', __('Vehicle successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Vehicle $vehicle)
    {
        if (Auth::user()->isAbleTo('vehicle delete')) {
            $Vehicles = Booking::where('vehicle_name', $vehicle->id)->first();
            $Insurances = Insurances::where('vehicle_name', $vehicle->id)->first();
            $Maintenance = Maintenance::where('vehicle_name', $vehicle->id)->first();
            $Fuel = Fuel::where('vehicle_name', $vehicle->id)->first();

            if(module_is_active('CustomField'))
            {
                $customFields = \Modules\CustomField\Entities\CustomField::where('module','Fleet')->where('sub_module','Vehicle')->get();
                foreach($customFields as $customField)
                {
                    $value = \Modules\CustomField\Entities\CustomFieldValue::where('record_id', '=', $vehicle->id)->where('field_id',$customField->id)->first();
                    if(!empty($value)){
                        $value->delete();
                    }
                }
            }

            if (!empty($Vehicles || $Insurances  || $Maintenance || $Fuel)) {
                return redirect()->back()->with('error', __('this vehicle is already use so please transfer or delete this vehicle related data.'));
            }
            $vehicle->delete();
            event(new DestroyVehicle($vehicle));
            return redirect()->route('vehicle.index')->with('success', 'Vehicle successfully deleted.');
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
}
