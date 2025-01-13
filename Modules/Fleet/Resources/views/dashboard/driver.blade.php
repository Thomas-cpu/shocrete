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
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-truck"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2">{{ __('Total')}}</p>
                            <h6 class="mb-3">{{ __('Vehicle')}}</h6>
                            <h3 class="mb-0">{{ $vehicles['vehicle'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="theme-avtar bg-info">
                                <i class="ti ti-battery-2"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2">{{ __('Total')}}</p>
                            <h6 class="mb-3">{{ __('Fuel Amount')}}</h6>
                            <h3 class="mb-0">{{ $fuel['amount'] }} </h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="theme-avtar bg-warning">
                                <i class="ti ti-battery-1"></i>
                            </div>
                            <p class="text-muted text-sm mt-4 mb-2">{{ __('Total')}}</p>
                            <h6 class="mb-3">{{ __('Fuel Quantity')}}</h6>
                            <h3 class="mb-0">{{ $fuel['quantity'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>{{ __('Latest Fuel') }} </h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{__('Driver Name')}}</th>
                                    <th>{{__('Vehicle Name')}}</th>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Quantity')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Odometer Reading')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fuels as $fuel)
                                <tr>
                                    <td>
                                        {{ !empty($fuel->driver) ? $fuel->driver->name : '' }}

                                    </td>
                                    <td>
                                        {{ !empty($fuel->vehicle) ? $fuel->vehicle->name : '' }}
                                    </td>
                                    <td> {{ $fuel->fill_date }}</td>
                                    <td> {{ $fuel->quantity }}</td>
                                    <td> {{ $fuel->total_cost }}</td>
                                    <td> {{ $fuel->odometer_reading }}</td>
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
