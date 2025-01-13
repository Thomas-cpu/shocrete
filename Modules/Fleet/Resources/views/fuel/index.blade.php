@extends('layouts.main')
@section('page-title')
    {{ __('Manage Fuel') }}
@endsection
@section('page-breadcrumb')
    {{ __('Fuel') }}
@endsection
@section('page-action')
    <div>
        @permission('fuel create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create New Fuel') }}"
                data-url="{{ route('fuel.create') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endpermission
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 pc-dt-simple" id="assets">
                            <thead>
                                <tr>
                                    <th>{{ __('Driver Name') }}</th>
                                    <th>{{ __('Vehicle Name') }}</th>
                                    <th>{{ __('Fueling Date and Time') }}</th>
                                    <th>{{ __('Fuel Type') }}</th>
                                    <th>{{ __('Gallons/Liters of Fuel') }}</th>
                                    <th>{{ __('Cost per Gallon/Liter') }}</th>
                                    <th>{{ __('Total Cost') }}</th>
                                    <th>{{ __('Odometer Reading') }}</th>
                                    <th scope="col" class="text-end">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Fuels as $Fuel)
                                    <tr>
                                        <td>
                                            {{ !empty($Fuel->driver) ? $Fuel->driver->name : '' }}
                                        </td>
                                        <td>
                                            {{ !empty($Fuel->vehicle) ? $Fuel->vehicle->name : '' }}
                                        </td>

                                        <td> {{ $Fuel->fill_date }}</td>
                                        <td>
                                            {{ !empty($Fuel->FuelType) ? $Fuel->FuelType->name : '' }}

                                        </td>
                                        <td> {{ $Fuel->quantity }}</td>
                                        <td> {{ $Fuel->cost }}</td>
                                        <td> {{ $Fuel->total_cost }}</td>
                                        <td> {{ $Fuel->odometer_reading }}</td>
                                        <td class="Action text-end">
                                            <span>
                                                @permission('fuel edit')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a class="mx-3 btn btn-sm  align-items-center"
                                                            data-url="{{ route('fuel.edit', $Fuel->id) }}"
                                                            data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Fuel') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endpermission
                                                @permission('fuel delete')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {{ Form::open(['route' => ['fuel.destroy', $Fuel->id], 'class' => 'm-0']) }}
                                                        @method('DELETE')
                                                        <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="Delete" aria-label="Delete"
                                                            data-confirm="{{ __('Are You Sure?') }}"
                                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="delete-form-{{ $Fuel->id }}"><i
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
