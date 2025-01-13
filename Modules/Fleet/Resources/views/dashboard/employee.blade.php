@extends('layouts.main')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('page-breadcrumb')
    {{ __('Fleet') }}
@endsection

@section('content')

<div class="col-sm-12">
    <div class="row">
        <div class="col-xxl-6">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-users"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2">{{ __('Total')}}</p>
                            <h6 class="mb-3" style="margin-top: 30px;">{{ __('Maintenance')}}</h6>
                            <h3 class="mb-0">{{ $status }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="theme-avtar bg-info">
                                <i class="ti ti-user"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2">{{ __('Total')}}</p>
                            <h6 class="mb-3">{{ __('Pending Maintenance')}}</h6>
                            <h3 class="mb-0">{{ $pending['pending'] }} </h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="theme-avtar bg-warning">
                                <i class="ti ti-users"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2">{{ __('Total')}}</p>
                            <h6 class="mb-3">{{ __('Accept Maintenance')}}</h6>
                            <h3 class="mb-0">{{ $accept['accept'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="theme-avtar bg-danger">
                                <i class="ti ti-truck-delivery"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2">{{ __('Total')}}</p>
                            <h6 class="mb-3">{{ __('Decline Maintenance')}}</h6>
                            <h3 class="mb-0">{{ $decline['decline'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>{{ __('Latest maintenances') }} </h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Requisition Type') }}</th>
                                <th>{{ __('Vehicle Name') }}</th>
                                <th>{{ __('Maintenance Type') }}</th>
                                <th>{{ __('Service Date') }}</th>
                                <th>{{ __('Priority') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($maintenances as $maintenance)
                                <tr>
                                    <td> {{ $maintenance->service_type }}</td>
                                    <td>

                                        {{ !empty($maintenance->VehicleName) ? $maintenance->VehicleName->name : '' }}

                                    </td>

                                    <td>
                                        {{ !empty($maintenance->MaintenanceType) ? $maintenance->MaintenanceType->name : '' }}

                                    </td>
                                    <td> {{ $maintenance->maintenance_date }}</td>
                                    <td> {{ $maintenance->priority }} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
