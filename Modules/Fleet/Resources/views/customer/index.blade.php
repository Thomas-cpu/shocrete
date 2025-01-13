@extends('layouts.main')
@section('page-title')
    {{ __('Manage Customer') }}
@endsection
@section('page-breadcrumb')
    {{ __('Customer') }}
@endsection
@section('page-action')
    <div>
        @permission('fleet customer create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="lg" data-title="{{ __('Create New Customer') }}"
                data-url="{{ route('fleet_customer.create') }}" data-bs-toggle="tooltip"
                data-bs-original-title="{{ __('Create') }}">
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
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Mobile Number') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    @if (Laratrust::hasPermission('fleet customer edit') || Laratrust::hasPermission('fleet customer delete'))
                                        <th width="10%"> {{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $index => $customer)
                                    <tr>
                                        <th scope="row">{{++$index}}</th>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>

                                        @if (!empty($customer->phone))
                                            <td>{{ $customer->phone }}</td>
                                        @else
                                            <td>--</td>
                                        @endif
                                        @if (!empty($customer->address))
                                            <td>{{ $customer->address }}</td>
                                        @else
                                            <td>--</td>
                                        @endif

                                        <td class="Action ignore">
                                            <span>
                                                @permission('fleet customer edit')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a class="mx-3 btn btn-sm  align-items-center"
                                                            data-url="{{ route('fleet_customer.edit', $customer->id) }}"
                                                            data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Customer') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endpermission

                                                @php
                                                    $user = \App\Models\User::where('id', $customer->user_id)->first();
                                                @endphp
                                                @if (!empty($user->id))
                                                    @permission('fleet customer delete')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {{ Form::open(['route' => ['fleet_customer.destroy', $customer->id], 'class' => 'm-0']) }}
                                                            @method('DELETE')
                                                            <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-original-title="Delete" aria-label="Delete"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $customer->id }}"><i
                                                                    class="ti ti-trash text-white text-white"></i></a>
                                                            {{ Form::close() }}
                                                        </div>
                                                    @endpermission
                                                @endif
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
