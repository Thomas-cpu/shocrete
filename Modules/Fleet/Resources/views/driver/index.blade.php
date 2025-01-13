@extends('layouts.main')
@section('page-title')
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
        <a href="{{ route('driver.grid') }}" class="btn btn-sm btn-primary btn-icon"
            data-bs-toggle="tooltip"title="{{ __('Grid View') }}">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
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
                                    <th>{{ __('Licence Number') }}</th>
                                    <th>{{ __('Licence Type') }}</th>
                                    <th>{{ __('Working Hour') }}</th>
                                    <th>{{ __('Licence Expire Date') }}</th>
                                    <th>{{ __('Join Date') }}</th>
                                    @if (Laratrust::hasPermission('driver edit') || Laratrust::hasPermission('driver delete') || Laratrust::hasPermission('driver show'))
                                        <th width="10%"> {{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drivers as $index => $driver)
                                    <tr>
                                        <th scope="row">{{++$index}}</th>
                                        <td>{{ $driver->name }}</td>
                                        <td>{{ $driver->email }}</td>
                                        @if ($driver->lincese_number)
                                            <td>{{ $driver->lincese_number }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        @if ($driver->lincese_type)
                                            <td>
                                                {{ $driver->licensesname}}
                                            </td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        @if ($driver->Working_time)
                                            <td>{{ $driver->Working_time }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        @if ($driver->expiry_date)
                                            <td>{{ $driver->expiry_date }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        @if ($driver->join_date)
                                            <td>{{ $driver->join_date }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td class="Action ignore">
                                            <span>
                                                @permission('driver edit')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a class="mx-3 btn btn-sm  align-items-center"
                                                            data-url="{{ route('driver.edit', $driver->id) }}"
                                                            data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Driver') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endpermission
                                                @php
                                                    $user = \App\Models\User::where('id', $driver->user_id)->first();
                                                @endphp
                                                @if (!empty($user->id))
                                                    @permission('driver delete')
                                                        <div class="action-btn bg-danger ms-2">
                                                            {{ Form::open(['route' => ['driver.destroy', $driver->id], 'class' => 'm-0']) }}
                                                            @method('DELETE')
                                                            <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-bs-original-title="Delete" aria-label="Delete"
                                                                data-confirm="{{ __('Are You Sure?') }}"
                                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                data-confirm-yes="delete-form-{{ $driver->id }}"><i
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
