<?php

namespace Modules\Fleet\Http\Controllers;

use App\Models\User;
use Google\Service\DriveActivity\Drive;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Modules\Fleet\Entities\Driver;
use Modules\Fleet\Entities\Fuel;
use Modules\Fleet\Entities\License;
use Modules\Fleet\Entities\Vehicle;
use Modules\Fleet\Events\CreateDriver;
use Modules\Fleet\Events\DestroyDriver;
use Modules\Fleet\Events\UpdateDriver;
use App\Models\Role;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('driver manage')) {
            $drivers = User::where('workspace_id', getActiveWorkSpace())
                ->leftjoin('drivers', 'users.id', '=', 'drivers.user_id')
                ->leftjoin('licenses', 'licenses.id', '=', 'drivers.lincese_type')
                ->where('users.type', 'driver')
                ->select('users.*', 'drivers.*', 'users.name as name', 'users.email as email', 'users.id as id', 'licenses.name as licensesname')
                ->get();

            return view('fleet::driver.index', compact('drivers'));
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
        if (Auth::user()->isAbleTo('driver create')) {
            $lincese_type        = License::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id');
            if (module_is_active('CustomField')) {
                $customFields =  \Modules\CustomField\Entities\CustomField::where('workspace_id', getActiveWorkSpace())->where('module', '=', 'Fleet')->where('sub_module', 'Driver')->get();
            } else {
                $customFields = null;
            }
            return view('fleet::driver.create', compact('lincese_type', 'customFields'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $roles = Role::where('name', 'driver')->where('guard_name', 'web')->where('created_by', creatorId())->first();

        if (Auth::user()->isAbleTo('driver create')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'phone' => 'required',
                    'lincese_number' => 'required',
                    'lincese_type' => 'required',
                    'expiry_date' => 'required',
                    'join_date' => 'required',
                    'address' => 'required',
                    'dob' => 'required',
                    'Working_time' => 'required',
                    'driver_status' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->withInput()->with('error', $messages->first());
            }
            if (isset($request->user_id)) {
                $user = User::find($request->user_id);

                if (empty($user)) {
                    return redirect()->back()->with('error', __('Something went wrong please try again.'));
                }
                if ($user->name != $request->name) {
                    $user->name = $request->name;
                    $user->save();
                }
            } else {

                $userpassword               = $request->input('password');
                $user['name']               = $request->input('name');
                $user['email']              = $request->input('email');
                $user['password']           = \Hash::make($userpassword);
                $user['email_verified_at']  = date('Y-m-d h:i:s');
                $user['lang']               = 'en';
                $user['type']               = $roles->name;
                $user['created_by']         = \Auth::user()->id;
                $user['workspace_id']       = getActiveWorkSpace();
                $user['active_workspace']   = getActiveWorkSpace();
                $user = User::create($user);
                $user->addRole($roles);
            }
            $driver                 = new Driver();

            $driver->user_id        = $user->id;
            $driver->name           = $request->name;
            $driver->email          = !empty($user->email) ? $user->email : null;
            $driver->phone          = $request->phone;
            $driver->lincese_number = $request->lincese_number;
            $driver->lincese_type   = $request->lincese_type;
            $driver->expiry_date    = $request->expiry_date;
            $driver->join_date      = $request->join_date;
            $driver->address        = $request->address;
            $driver->dob            = $request->dob;
            $driver->Working_time   = $request->Working_time;
            $driver->driver_status  = $request->driver_status;
            $driver->workspace      = getActiveWorkSpace();
            $driver->created_by     = creatorId();

            $driver->save();
            if (module_is_active('CustomField')) {
                \Modules\CustomField\Entities\CustomField::saveData($driver, $request->customField);
            }
            event(new CreateDriver($request, $driver));

            return redirect()->back()->with('success', __('Driver successfully created.'));
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
    public function edit($id)
    {
        if (Auth::user()->isAbleTo('driver edit')) {
            $user         = User::where('id', $id)->where('workspace_id', getActiveWorkSpace())->first();
            $driver     = Driver::where('user_id', $id)->where('workspace', getActiveWorkSpace())->first();

            $lincese_type = License::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('name', 'id')->prepend('Select License Type', '');
            if (!empty($driver)) {
                if (module_is_active('CustomField')) {
                    $driver->customField = \Modules\CustomField\Entities\CustomField::getData($driver, 'Fleet', 'Driver');
                    $customFields             = \Modules\CustomField\Entities\CustomField::where('workspace_id', '=', getActiveWorkSpace())->where('module', '=', 'Fleet')->where('sub_module', 'Driver')->get();
                } else {
                    $customFields = null;
                }
                return view('fleet::driver.edit', compact('user', 'driver', 'lincese_type', 'customFields'));
            }
            return view('fleet::driver.edit', compact('user', 'driver', 'lincese_type'));
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
    public function update(Request $request, Driver $driver)
    {
        if (Auth::user()->isAbleTo('driver edit')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'phone' => 'required',
                    'lincese_number' => 'required',
                    'lincese_type' => 'required',
                    'expiry_date' => 'required',
                    'join_date' => 'required',
                    'address' => 'required',
                    'dob' => 'required',
                    'Working_time' => 'required',
                    'driver_status' => 'required',

                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $user = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return redirect()->back()->with('error', __('Something went wrong please try again.'));
            }
            if ($user->name != $request->name) {
                $user->name = $request->name;
                $user->save();
            }
            $driver->name           = $request->name;
            $driver->phone          = $request->phone;
            $driver->lincese_number = $request->lincese_number;
            $driver->lincese_type   = $request->lincese_type;
            $driver->expiry_date    = $request->expiry_date;
            $driver->join_date      = $request->join_date;
            $driver->address        = $request->address;
            $driver->dob            = $request->dob;
            $driver->Working_time   = $request->Working_time;
            $driver->driver_status   = $request->driver_status;
            $driver->workspace     = getActiveWorkSpace();
            $driver->created_by     = creatorId();
            $driver->save();

            if (module_is_active('CustomField')) {
                \Modules\CustomField\Entities\CustomField::saveData($driver, $request->customField);
            }
            event(new UpdateDriver($request, $driver));

            return redirect()->back()->with('success', __('Driver successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if (Auth::user()->isAbleTo('driver delete')) {
            $driver      = Driver::where('user_id', $id)->where('workspace', getActiveWorkSpace())->first();

            $drivers = Vehicle::where('driver_name', $driver->user_id)->first();
            $Fuel = Fuel::where('driver_name', $driver->user_id)->first();
            if (module_is_active('CustomField')) {
                $customFields = \Modules\CustomField\Entities\CustomField::where('module', 'Fleet')->where('sub_module', 'Driver')->get();
                foreach ($customFields as $customField) {
                    $value = \Modules\CustomField\Entities\CustomFieldValue::where('record_id', '=', $driver->id)->where('field_id', $customField->id)->first();
                    if (!empty($value)) {
                        $value->delete();
                    }
                }
            }
            if (!empty($drivers || $Fuel)) {
                return redirect()->back()->with('error', __('this driver is already use so please transfer or delete this driver related data.'));
            }
            $driver->delete();

            event(new DestroyDriver($driver));

            return redirect()->back()->with('success', 'Driver successfully deleted.');
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    public function grid()
    {
        if (\Auth::user()->isAbleTo('driver manage')) {
            $drivers = User::where('workspace_id', getActiveWorkSpace())
                ->leftjoin('drivers', 'users.id', '=', 'drivers.user_id')
                ->where('users.type', 'driver')
                ->select('users.*', 'drivers.*', 'users.name as name', 'users.email as email', 'users.id as id')
                ->get();

            return view('fleet::driver.grid', compact('drivers'));
        } else {
            return redirect()->back()->with('error', 'permission Denied');
        }
    }
}
