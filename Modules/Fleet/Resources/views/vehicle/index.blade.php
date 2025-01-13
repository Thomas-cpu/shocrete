@extends('layouts.main')
@section('page-title')
    {{ __('Manage Vehicle') }}
@endsection
@section('page-breadcrumb')
    {{ __('Vehicle') }}
@endsection
@section('page-action')
    <div>
        @permission('vehicle create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create New Vehicle') }}"
                data-url="{{ route('vehicle.create') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">
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
                    {{ Form::open(['route' => ['vehicle.index'], 'method' => 'GET', 'id' => 'frm_submit']) }}
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::text('name', isset($_GET['name']) ? $_GET['name'] : '', ['class' => 'form-control select', 'placeholder' => __('Search Name')]) }}
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::select('vehicle_type', $vehicleTypes, isset($_GET['vehicle_type']) ? $_GET['vehicle_type'] : '', ['class' => 'form-control select', 'placeholder' => __('Select Vehicle Type')]) }}
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">

                                {{ Form::select('fuel_type', $fuelType, isset($_GET['fuel_type']) ? $_GET['fuel_type'] : '', ['class' => 'form-control select', 'placeholder' => __('Select Fuel Type')]) }}
                            </div>
                        </div>
                        <div class="col-auto float-end ms-2 mb-1">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('frm_submit').submit(); return false;"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="apply">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="{{ route('vehicle.index') }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="Reset">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
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
                                    <th>{{ __('Vehicle Name') }}</th>
                                    <th>{{ __('Vehicle Type') }}</th>
                                    <th>{{ __('Fuel Type') }}</th>
                                    <th>{{ __('Registration Date') }}</th>
                                    <th>{{ __('Driver Name') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    @if (\Auth::user()->type == 'company')
                                        <th width="200px">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vehicles as $vehicle)
                                    <tr>
                                        <td>{{ $vehicle->name }}</td>

                                        <td>{{ !empty($vehicle->VehicleType) ? $vehicle->VehicleType->name : '' }}</td>

                                        <td>{{ !empty($vehicle->FuelType) ? $vehicle->FuelType->name : '' }}</td>

                                        <td>{{ !empty($vehicle->registration_date) ? $vehicle->registration_date : '-' }}</td>

                                        <td>{{ !empty($vehicle->driver) ? $vehicle->driver->name : '' }}</td>

                                        <td>{{ !empty($vehicle->status) ? $vehicle->status : '-' }}</td>

                                        @if (\Auth::user()->type == 'company')
                                            <td class="Action">
                                                <span>
                                                    @permission('vehicle edit')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a class="mx-3 btn btn-sm  align-items-center"
                                                                data-url="{{ route('vehicle.edit', $vehicle->id) }}"
                                                                data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                                title="" data-title="{{ __('Edit vehicle') }}"
                                                                data-bs-original-title="{{ __('Edit') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endpermission
                                                    @permission('vehicle delete')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {{ Form::open(['route' => ['vehicle.destroy', $vehicle->id], 'class' => 'm-0']) }}
                                                            @method('DELETE')
                                                            <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-original-title="Delete" aria-label="Delete"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $vehicle->id }}"><i
                                                                    class="ti ti-trash text-white text-white"></i></a>
                                                            {{ Form::close() }}
                                                        </div>
                                                    @endpermission
                                                </span>
                                            </td>
                                        @endif
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
