@extends('layouts.main')
@section('page-title')
    {{ __('Manage Maintenance') }}
@endsection
@section('page-breadcrumb')
    {{ __('Maintenance') }}
@endsection
@section('page-action')
    <div>
        @permission('maintenance create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create New Maintenance') }}"
                data-url="{{ route('maintenance.create') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endpermission
    </div>
@endsection

@section('content')
    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
        <div class=" mt-2" id="" style="">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['maintenance.index'], 'method' => 'get', 'id' => 'frm_submit']) }}
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box form-group">

                                {{ Form::text('service_type', isset($_GET['service_type']) ? $_GET['service_type'] : '', ['class' => 'form-control', 'placeholder' => 'Search Service Type']) }}
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box form-group">
                                {{ Form::text('service_name', isset($_GET['service_name']) ? $_GET['service_name'] : '', ['class' => 'form-control select', 'placeholder' => 'Search Service Name']) }}
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box form-group">
                                {{ Form::select('maintenance_type', $MaintenanceType, isset($_GET['maintenance_type']) ? $_GET['maintenance_type'] : '', ['class' => 'form-control select']) }}
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box form-group">
                                {{ Form::select('priority', ['High', 'Medium', 'Low'], isset($_GET['priority']) ? $_GET['priority'] : '', ['class' => 'form-control select', 'placeholder' => 'Select Priority']) }}
                            </div>
                        </div>
                        <div class="col-auto float-end ms-2 mb-4">
                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                title="{{ __('Apply') }}"
                                onclick="document.getElementById('frm_submit').submit(); return false;">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="{{ route('maintenance.index') }}" class="btn btn-sm btn-danger"
                                data-bs-toggle="tooltip" title="{{ __('Reset') }}">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off"></i></span>
                            </a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="assets">
                            <thead>
                                <tr>
                                    <th>{{ __('Service Type') }}</th>
                                    <th>{{ __('Vehicle Name') }}</th>
                                    <th>{{ __('Maintenance Type') }}</th>
                                    <th>{{ __('Maintenance Service Name') }}</th>
                                    <th>{{ __('Maintenance Date') }}</th>
                                    <th>{{ __('Priority') }}</th>
                                    <th width="200px">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Maintenances as $Maintenance)
                                    <tr>
                                        <td> {{ $Maintenance->service_type }}</td>
                                        <td>

                                            {{ !empty($Maintenance->VehicleName) ? $Maintenance->VehicleName->name : '' }}

                                        </td>

                                        <td>
                                            {{ !empty($Maintenance->MaintenanceType) ? $Maintenance->MaintenanceType->name : '' }}

                                        </td>
                                        <td> {{ $Maintenance->service_name }}</td>
                                        <td> {{ $Maintenance->maintenance_date }}</td>
                                        <td> {{ $Maintenance->priority }} </td>
                                        <td class="Action">
                                            <span>
                                                @permission('maintenance edit')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a class="mx-3 btn btn-sm  align-items-center"
                                                            data-url="{{ route('maintenance.edit', $Maintenance->id) }}"
                                                            data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Maintenance') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endpermission
                                                @permission('maintenance delete')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {{ Form::open(['route' => ['maintenance.destroy', $Maintenance->id], 'class' => 'm-0']) }}
                                                        @method('DELETE')
                                                        <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="Delete" aria-label="Delete"
                                                            data-confirm="{{ __('Are You Sure?') }}"
                                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="delete-form-{{ $Maintenance->id }}"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                        {{ Form::close() }}
                                                    </div>
                                                @endpermission
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
