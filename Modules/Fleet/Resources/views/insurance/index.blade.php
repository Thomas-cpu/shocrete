@extends('layouts.main')
@section('page-title')
    {{ __('Manage Insurance') }}
@endsection
@section('page-breadcrumb')
    {{ __('Insurance') }}
@endsection
@section('page-action')
    <div>
        @permission('insurance create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create New Insurance') }}"
                data-url="{{ route('insurance.create') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">
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
                    {{ Form::open(['route' => ['insurance.index'], 'method' => 'GET', 'id' => 'frm_submit']) }}
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::text('insurance_provider', isset($_GET['insurance_provider']) ? $_GET['insurance_provider'] : '', ['class' => 'form-control select', 'placeholder' => __('Search Insurance Provider Name')]) }}
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::text('policy_number', isset($_GET['policy_number']) ? $_GET['policy_number'] : '', ['class' => 'form-control select', 'placeholder' => __('Search Policy Number')]) }}
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                {{ Form::select('vehicle_name', $vehicle, isset($_GET['vehicle_name']) ? $_GET['vehicle_name'] : '', ['class' => 'form-control select', 'placeholder' => __('Select Vehicle Name')]) }}
                            </div>
                        </div>
                        <div class="col-auto float-end mb-3">
                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                title="{{ __('Apply') }}"
                                onclick="document.getElementById('frm_submit').submit(); return false;">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="{{ route('insurance.index') }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                title="{{ __('Reset') }}">
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
                                    <th>{{ __('Policy Number') }}</th>
                                    <th>{{ __('Insurance Provider Name') }}</th>
                                    <th>{{ __('Vehicle Name') }}</th>
                                    <th>{{ __('Recurring Date') }}</th>
                                    <th>{{ __('Recurring Period') }}</th>
                                    <th>{{ __('Charge Payable') }}</th>
                                    <th width="200px">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($insurances as $insurance)
                                    <tr>
                                        <td>{{ $insurance->policy_number }}</td>
                                        <td>{{ $insurance->insurance_provider }}</td>
                                        <td>
                                            {{ !empty($insurance->VehicleName) ? $insurance->VehicleName->name : '' }}

                                        </td>
                                        <td> {{ $insurance->scheduled_date }}</td>
                                        <td>
                                            {{ !empty($insurance->Recurring) ? $insurance->Recurring->name : '' }}

                                        </td>
                                        <td>{{ $insurance->charge_payable }}</td>
                                        <td class="Action">
                                            <span>
                                                @permission('insurance edit')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a class="mx-3 btn btn-sm  align-items-center"
                                                            data-url="{{ route('insurance.edit', $insurance->id) }}"
                                                            data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Insurance') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endpermission
                                                @permission('insurance delete')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {{ Form::open(['route' => ['insurance.destroy', $insurance->id], 'class' => 'm-0']) }}
                                                        @method('DELETE')
                                                        <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                            data-bs-toggle="tooltip" title=""
                                                            data-bs-original-title="Delete" aria-label="Delete"
                                                            data-confirm="{{ __('Are You Sure?') }}"
                                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="delete-form-{{ $insurance->id }}"><i
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
