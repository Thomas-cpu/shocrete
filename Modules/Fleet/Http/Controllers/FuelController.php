<?php

namespace Modules\Fleet\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Fleet\Entities\Driver;
use Modules\Fleet\Entities\Fuel;
use Modules\Fleet\Entities\FuelType;
use Modules\Fleet\Entities\Vehicle;
use Modules\Fleet\Events\CreateFuel;
use Modules\Fleet\Events\DestroyFuel;
use Modules\Fleet\Events\UpdateFuel;

class FuelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('fuel manage')) {
            if (Auth::user()->type == "company") {
                $Fuels = Fuel::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->with('driver')->get();
            } else {
                $Fuels = Fuel::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->where('driver_name', \Auth::user()->id)->get();
            }

            return view('fleet::fuel.index', compact('Fuels'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (Auth::user()->isAbleTo('fuel create')) {

            $driver = Driver::where('workspace', getActiveWorkSpace())->where('created_by', '=', creatorId())->get()->pluck('name', 'id')->prepend('Select Driver Name', '');
            $vehicle = Vehicle::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id')->prepend('Select Vehicle', '');
            $fuelType = FuelType::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id')->prepend('Select Fuel Type', '');
            // dd($driver,$vehicle,$fuelType);
            return view('fleet::fuel.create', compact('driver', 'vehicle','fuelType'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (\Auth::user()->isAbleTo('fuel create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'vehicle_name' => 'required',
                    'fill_date' => 'required',
                    'fuel_type' => 'required',
                    'quantity' => 'required',
                    'cost' => 'required',
                    'total_cost' => 'required',
                    'odometer_reading' => 'required',
                    'notes' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
            }

            $fuel = new Fuel();
            // $fuel->driver_name         =\Auth::user()->type == "company" ? $request->driver_name : \Auth::user()->id;
            $fuel->driver_name         = isset($request->driver_name) ? $request->driver_name : '';
            $fuel->vehicle_name        = $request->vehicle_name;
            $fuel->fill_date           = $request->fill_date;
            $fuel->fuel_type           = $request->fuel_type;
            $fuel->quantity            = $request->quantity;
            $fuel->cost                = $request->cost;
            $fuel->total_cost          = $request->total_cost;
            $fuel->odometer_reading    = $request->odometer_reading;
            $fuel->notes               = $request->notes;
            $fuel->workspace           = getActiveWorkSpace();
            $fuel->created_by          = creatorId();
            $fuel->save();
            event(new CreateFuel($request,$fuel));

            return redirect()->route('fuel.index')->with('success', __('Fuel  successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
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
    public function edit(Fuel $fuel)
    {
        if (\Auth::user()->isAbleTo('fuel edit')) {
            $driver = Driver::where('workspace', getActiveWorkSpace())->where('created_by', '=', creatorId())->get()->pluck('name', 'id')->prepend('Select Driver Name', '');
            $vehicle = Vehicle::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id')->prepend('Select Vehicle', '');
            $fuelType = FuelType::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id')->prepend('Select Fuel Type', '');
            return view('fleet::fuel.edit', compact('fuel', 'driver', 'vehicle','fuelType'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Fuel $fuel)
    {
        if (\Auth::user()->isAbleTo('fuel edit')) {
            $validator = \Validator::make(
                $request->all(), [
                                'vehicle_name' => 'required',
                                'fill_date' => 'required',
                                'quantity' => 'required',
                                'cost' => 'required',
                                'total_cost' => 'required',
                                'odometer_reading' => 'required',
                                'notes' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $fuel->driver_name       = \Auth::user()->type == "company" ? $request['driver_name'] : \Auth::user()->id;
            $fuel->vehicle_name      = $request->vehicle_name;
            $fuel->fill_date         = $request->fill_date;
            $fuel->quantity          = $request->quantity;
            $fuel->cost            = $request->cost;
            $fuel->total_cost            = $request->total_cost;
            $fuel->odometer_reading  = $request->odometer_reading;
            $fuel->notes       = $request->notes;
            $fuel->workspace      = getActiveWorkSpace();
            $fuel->created_by        = creatorId();
            $fuel->save();
            event(new UpdateFuel($request,$fuel));

            return redirect()->route('fuel.index')->with('success', __('Fuel History successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Fuel $fuel)
    {
        if(\Auth::user()->isAbleTo('fuel delete'))
        {
            $fuel->delete();
            event(new DestroyFuel($fuel));

            return redirect()->route('fuel.index')->with('success', 'Fuel history successfully deleted.' );
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
}
