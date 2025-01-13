<?php

namespace Modules\Fleet\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Fleet\Entities\Booking;
use Modules\Fleet\Entities\FleetCustomer;
use Modules\Fleet\Events\CreateFleetCustomer;
use Modules\Fleet\Events\DestroyFleetCustomer;
use Modules\Fleet\Events\UpdateFleetCustomer;
use App\Models\Role;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (Auth::user()->isAbleTo('fleet customer manage')) {
            $customers = User::where('workspace_id', getActiveWorkSpace())
                ->leftjoin('fleet_customers', 'users.id', '=', 'fleet_customers.user_id')
                ->where('users.type', 'Client')
                ->select('users.*', 'fleet_customers.*', 'users.name as name', 'users.email as email', 'users.id as id')
                ->get();
            return view('fleet::customer.index', compact('customers'));
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
        if (Auth::user()->isAbleTo('fleet customer create')) {
            if (module_is_active('CustomField')) {
                $customFields =  \Modules\CustomField\Entities\CustomField::where('workspace_id', getActiveWorkSpace())->where('module', '=', 'Fleet')->where('sub_module', 'Customer')->get();
            } else {
                $customFields = null;
            }

            return view('fleet::customer.create', compact('customFields'));
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
        $roles = Role::where('name', 'client')->where('guard_name', 'web')->where('created_by', creatorId())->first();

        if (Auth::user()->isAbleTo('fleet customer create')) {

            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
                ]
            );
            if (empty($request->user_id)) {
                $rules = [

                    'email' => 'required|email|unique:users',
                ];
                $validator = \Validator::make($request->all(), $rules);
            }
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('fleet_customer.index')->with('error', $messages->first());
            }
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
                $user['active_workspace']   = 0;
                $user = User::create($user);
                $user->addRole($roles);
            }

            $customers                 = new FleetCustomer();
            $customers->user_id        = $user->id;
            $customers->name           = $request->name;
            $customers->email          = !empty($user->email) ? $user->email : null;
            $customers->phone          = $request->phone;
            $customers->address        = $request->address;
            $customers->workspace      = getActiveWorkSpace();
            $customers->created_by     = creatorId();

            $customers->save();
            if (module_is_active('CustomField')) {
                \Modules\CustomField\Entities\CustomField::saveData($customers, $request->customField);
            }
            event(new CreateFleetCustomer($request, $customers));

            return redirect()->back()->with('success', __('Customer successfully created!'));
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
        return redirect()->back()->with('error', __('Permission denied.'));
        return view('fleet::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if (Auth::user()->isAbleTo('fleet customer edit')) {
            $customer     = FleetCustomer::where('user_id', $id)->where('workspace', getActiveWorkSpace())->first();
            $user         = User::where('id', $id)->where('workspace_id', getActiveWorkSpace())->first();
            if(!empty($customer)){
                if (module_is_active('CustomField')) {
                    $customer->customField = \Modules\CustomField\Entities\CustomField::getData($customer, 'Fleet', 'Customer');
                    $customFields             = \Modules\CustomField\Entities\CustomField::where('workspace_id', '=', getActiveWorkSpace())->where('module', '=', 'Fleet')->where('sub_module', 'Customer')->get();
                } else {
                    $customFields = null;
                }
                return view('fleet::customer.edit', compact('customer', 'user', 'customFields'));
            }
            return view('fleet::customer.edit', compact('customer', 'user'));
            
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
    public function update(Request $request, FleetCustomer $customer)
    {
        if (Auth::user()->isAbleTo('fleet customer edit')) {

            $validator = \Validator::make(
                $request->all(),
                [
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
                    'address' => 'required',
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
            $customer->name         = $request->name;
            $customer->phone        = $request->phone;
            $customer->address      = $request->address;
            $customer->workspace    = getActiveWorkSpace();
            $customer->created_by   = creatorId();

            $customer->save();
            if (module_is_active('CustomField')) {
                \Modules\CustomField\Entities\CustomField::saveData($customer, $request->customField);
            }
            event(new UpdateFleetCustomer($request, $customer));

            return redirect()->back()->with('success', __('Customer successfully updated.'));
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
        if (Auth::user()->isAbleTo('fleet customer delete')) {
            $customer     = FleetCustomer::where('user_id', $id)->where('workspace', getActiveWorkSpace())->first();
            $CustomerData = Booking::where('customer_name', $customer->user_id)->first();
            if (module_is_active('CustomField')) {
                $customFields = \Modules\CustomField\Entities\CustomField::where('module', 'Fleet')->where('sub_module', 'Customer')->get();
                foreach ($customFields as $customField) {
                    $value = \Modules\CustomField\Entities\CustomFieldValue::where('record_id', '=', $customer->id)->where('field_id', $customField->id)->first();
                    if (!empty($value)) {
                        $value->delete();
                    }
                }
            }
            if (!empty($CustomerData)) {
                return redirect()->back()->with('error', __('this customer is already use so please transfer or delete this customer related data.'));
            }
            $customer->delete();
            event(new DestroyFleetCustomer($customer));

            return redirect()->route('fleet_customer.index')->with('success', 'Customer successfully deleted.');
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
}
