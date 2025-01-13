@php
    if(Auth::user()->type=='super admin')
    {
        $plural_name = __('Customers');
        $singular_name = __('Customer');
    }
    else{

        $plural_name =__('Users');
        $singular_name =__('User');
    }
@endphp
@if ($user->is_disable == 1 || Auth::user()->type == 'super admin')
    @if (Auth::user()->type == 'super admin')
        <div class="action-btn bg-primary ms-2">
            <a data-url="{{ route('company.info', $user->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                data-bs-original-title="{{ __('Admin Hub') }}" data-title="{{ __('Company Info') }}"> <span
                    class="text-white"><i class="ti ti-atom"></i></a>
        </div>
        <div class="action-btn bg-secondary ms-2">
            <a href="{{ route('login.with.company', $user->id) }}"
                class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip"
                data-bs-original-title="{{ __('Login As Company') }}"> <span class="text-white"><i
                        class="ti ti-replace"></i></a>
        </div>
        <div class="action-btn bg-primary ms-2">
            <a href="#!" data-url="{{ route('upgrade.plan', $user->id) }}" data-ajax-popup="true" data-size="xl"
                class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip"
                data-title="{{ __('Upgrade Plan') }}" data-bs-original-title="{{ __('Upgrade Plan') }}">
                <span class="text-white"><i class="ti ti-trophy"></i></span>
            </a>
        </div>
    @endif
    @permission('user reset password')
        <div class="action-btn bg-warning  ms-2">
            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                data-url="{{ route('users.reset', \Crypt::encrypt($user->id)) }}" data-ajax-popup="true"
                data-bs-toggle="tooltip" data-bs-original-title="{{ __('Reset Password') }}" data-title="{{ __('Reset Password') }}"> <span class="text-white"><i
                        class="ti ti-adjustments"></i></a>
        </div>
    @endpermission
    @permission('user login manage')
        @if ($user->is_enable_login == 1)
            <div class="action-btn bg-danger ms-2">
                <a href="{{ route('users.login', \Crypt::encrypt($user->id)) }}"
                    class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('Login Disable') }}"> <span class="text-white"><i
                            class="ti ti-road-sign"></i></a>
            </div>
        @elseif ($user->is_enable_login == 0 && $user->password == null)
            <div class="action-btn bg-secondary ms-2">
                <a href="#" data-url="{{ route('users.reset', \Crypt::encrypt($user->id)) }}" data-ajax-popup="true"
                    data-size="md" class="mx-3 btn btn-sm d-inline-flex align-items-center login_enable"
                    data-title="{{ __('New Password') }}" data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('New Password') }}"> <span class="text-white"><i
                            class="ti ti-road-sign"></i></a>
            </div>
        @else
            <div class="action-btn bg-success ms-2">
                <a href="{{ route('users.login', \Crypt::encrypt($user->id)) }}"
                    class="mx-3 btn btn-sm d-inline-flex align-items-center login_enable" data-bs-toggle="tooltip"
                    data-bs-original-title="{{ __('Login Enable') }}"> <span class="text-white"> <i
                            class="ti ti-road-sign"></i>
                </a>
            </div>
        @endif
    @endpermission
    @permission('user edit')
        <div class="action-btn bg-info ms-2">
            <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                data-url="{{ route('users.edit', $user->id) }}" class="dropdown-item" data-ajax-popup="true"
                data-title="{{ __('Update ' . $singular_name) }}" data-bs-toggle="tooltip"
                data-bs-original-title="{{ __('Edit') }}"> <span class="text-white"> <i
                        class="ti ti-pencil"></i></span></a>
        </div>
    @endpermission
    @permission('user delete')
        <div class="action-btn bg-danger ms-2">
            {{ Form::open(['route' => ['users.destroy', $user->id], 'class' => 'm-0']) }}
            @method('DELETE')
            <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip"
                title="" data-bs-original-title="{{__('Delete')}}" aria-label="{{__('Delete')}}"
                data-confirm-yes="delete-form-{{ $user->id }}"><i class="ti ti-trash text-white text-white"></i></a>
            {{ Form::close() }}
        </div>
    @endpermission
@else
    <div class="text-center">
        <i class="ti ti-lock"></i>
    </div>
@endif
