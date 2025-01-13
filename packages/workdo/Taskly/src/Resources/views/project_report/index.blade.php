@extends('layouts.main')
@section('page-title')
    {{ __('Project Report') }}
@endsection
@section('page-breadcrumb')
    {{ __('Project Report') }}
@endsection
@push('css')
    @include('layouts.includes.datatable-css')
@endpush
@php

    $client_keyword = Auth::user()->hasRole('client') ? 'client.' : '';
@endphp

@section('content')

    {{-- {{ Form::open(['route' => ['project_report.index'], 'method' => 'GET', 'id' => 'product_service']) }} --}}

    {{-- <div class="row pt-4 display-none" id="show_filter">

        @if (Auth::user()->hasRole('company') || Auth::user()->hasRole('client'))
            <div class="col-2">
                <select class="select2 form-select" name="all_users" id="all_users">
                    <option value="" class="px-4">{{ __('All Users') }}</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="col-2">
            <select class="select2 form-select" name="status" id="status">
                <option value="" class="px-4">{{ __('All Status') }}</option>

                <option value="Ongoing">{{ __('Ongoing') }}</option>
                <option value="Finished">{{ __('Finished') }}</option>
                <option value="OnHold">{{ __('OnHold') }}</option>

            </select>
        </div>


        <div class="form-group col-md-3">
            <div class="input-group date ">
                <input class="form-control" type="date" id="start_date" name="start_date" value=""
                    autocomplete="off" placeholder="{{ __('Start Date') }}">
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="input-group date ">
                <input class="form-control" type="date" id="end_date" name="end_date" value=""
                    autocomplete="off" placeholder="{{ __('End Date') }}">
            </div>
        </div>
        <div class="col-2">

            <button type="submit" class="btn btn-primary ">{{ __('Apply') }}</button>
            <a href="{{ route('project_report.index') }}" class="btn  btn-danger" data-bs-toggle="tooltip"
                title="{{ __('Reset') }}">
                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off"></i></span>
            </a>
        </div>
    </div> --}}

    {{-- {{ Form::close() }} --}}

    <div class="row">
        <div id="multiCollapseExample1">
            <div class="card">
                <div class="card-body">
                    {{-- {{ Form::open(['route' => ['projects.list'], 'method' => 'GET', 'id' => 'project_submit']) }} --}}
                    <div class="row d-flex align-items-center justify-content-end">
                        @if (Auth::user()->hasRole('company') || Auth::user()->hasRole('client'))
                            <div class="col-2 form-group">
                                {{ Form::label('user', __('User'), ['class' => 'form-label']) }}
                                {{ Form::select('user', $users, isset($_GET['user']) ? $_GET['user'] : '', ['class' => 'form-control ', 'placeholder' => 'All Users']) }}
                            </div>
                        @endif
                        <div class="col-2 form-group">
                                {{ Form::label('status', __('All Status'), ['class' => 'form-label']) }}
                                <select class="form-control" name="status" id="status">
                                    <option value="" class="px-4">{{ __('All Status') }}</option>
                                    <option value="Ongoing">{{ __('Ongoing') }}</option>
                                    <option value="Finished">{{ __('Finished') }}</option>
                                    <option value="OnHold">{{ __('OnHold') }}</option>
                                </select>
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                            {{ Form::date('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : null, ['class' => 'form-control ','placeholder' => 'Select Date']) }}
                        </div>
                        <div class="form-group col-md-3">
                            {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                            {{ Form::date('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : null, ['class' => 'form-control ','placeholder' => 'Select Date']) }}
                        </div>
                        <div class="col-auto float-end">
                            <a  class="btn btn-sm btn-primary"
                                data-bs-toggle="tooltip" title="{{ __('Apply') }}" id="applyfilter"
                                data-original-title="{{ __('apply') }}">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="#!" class="btn btn-sm btn-danger "
                                data-bs-toggle="tooltip" title="{{ __('Reset') }}" id="clearfilter"
                                data-original-title="{{ __('Reset') }}">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                            </a>
                        </div>
                    </div>
                    {{-- {{ Form::close() }} --}}
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive overflow_hidden">
                        {{ $dataTable->table(['width' => '100%']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>



@endsection
@push('scripts')
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
@endpush
