@extends('layouts.main')
@section('page-title')
    {{ __('Manage Driver') }}
@endsection
@section('title')
    {{ __('Manage Driver') }}
@endsection
@section('page-breadcrumb')
    {{ __('Driver') }}
@endsection
@section('page-action')
    <div>

        @permission('driver create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create New Driver') }}"
                data-url="{{ route('driver.create') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endpermission
        <a href="{{ route('driver.index') }}" class="btn btn-sm btn-primary btn-icon" data-bs-toggle="tooltip"
            title="{{ __('List View') }}">
            <i class="ti ti-list text-white"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        @foreach ($drivers as $driver)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    @if (Laratrust::hasPermission('driver edit') || Laratrust::hasPermission('driver delete'))
                                        @permission('driver edit')
                                                <a  data-url="{{ route('driver.edit', $driver->id) }}"
                                                data-ajax-popup="true" data-size="lg" class="dropdown-item"
                                                data-bs-whatever="{{ __('Edit driver') }}" data-bs-toggle="tooltip"
                                                data-title="{{ __('Edit driver') }}"><i class="ti ti-pencil"></i>
                                                {{ __('Edit') }}</a>
                                        @endpermission
                                        @php
                                        $user = \App\Models\User::where('id', $driver->user_id)->first();
                                    @endphp
                                       @if (!empty($user->id))
                                            @permission('driver delete')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['driver.destroy', $driver->id]]) !!}
                                                <a href="#!" class="dropdown-item  show_confirm" data-bs-toggle="tooltip">
                                                    <i class="ti ti-trash"></i>{{ __('Delete') }}
                                                </a>
                                                {!! Form::close() !!}
                                            @endpermission
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 justify-content-between">
                            <div class="col-12">
                                <div class="text-center client-box">
                                    <div class="avatar-parent-child">
                                        <a href="{{ check_file($driver->avatar) ? get_file($driver->avatar) : 'uploads/users-avatar/avatar.png' }}"
                                            target="_blank">
                                            <img src="{{ check_file($driver->avatar) ? get_file($driver->avatar) : 'uploads/users-avatar/avatar.png' }}"
                                                alt="user-image" class=" rounded-circle" width="120px" height="120px">
                                        </a>
                                    </div>
                                    <div class="mb-1"><a class="text-sm small text-muted">{{ $driver->name }}</a></div>
                                    <div class="mb-1"><a class="text-sm small text-muted">{{ $driver->email }}</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-3">
            <a  data-url="{{ route('driver.create') }}" class="btn-addnew-project" data-ajax-popup="true"
                data-size="lg" data-title="{{ __('Create New Driver') }}" style="padding: 90px 10px">
                <div class="badge bg-primary proj-add-icon">
                    <i class="ti ti-plus"></i>
                </div>
                <h6 class="mt-4 mb-2">New Driver</h6>
                <p class="text-muted text-center">Click here to add New Driver</p>
            </a>
        </div>
    </div>
@endsection
