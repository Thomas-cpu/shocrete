@extends('layouts.main')
@section('page-title')
    {{__('Manage Projects')}}
@endsection
@section('page-breadcrumb')
   {{__('Manage Projects')}}
@endsection
@section('page-action')
<div>
    @permission('project import')
        <a href="#"  class="btn btn-sm btn-primary" data-ajax-popup="true" data-title="{{__('Project Import')}}" data-url="{{ route('project.file.import') }}"  data-toggle="tooltip" title="{{ __('Import') }}"><i class="ti ti-file-import"></i> </a>
    @endpermission
    <a href="{{ route('projects.index') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"title="{{ __('Grid View') }}">
        <i class="ti ti-layout-grid text-white"></i>
    </a>

    @permission('project create')
        <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md"
            data-title="{{ __('Create New Project') }}" data-url="{{ route('projects.create') }}" data-toggle="tooltip"
            title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endpermission
</div>
@endsection
@push('css')
    @include('layouts.includes.datatable-css')
@endpush

@section('content')

<div class="row">

    <div id="multiCollapseExample1">
        <div class="card">
            <div class="card-body">
                {{-- {{ Form::open(['route' => ['projects.list'], 'method' => 'GET', 'id' => 'project_submit']) }} --}}
                <div class="row d-flex align-items-center justify-content-end">
                    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                        <div class="btn-box">
                            {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                            {{ Form::date('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : null, ['class' => 'form-control ','placeholder' => 'Select Date']) }}

                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="btn-box">
                            {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                            {{ Form::date('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : null, ['class' => 'form-control ','placeholder' => 'Select Date']) }}

                        </div>
                    </div>
                    <div class="col-auto float-end ms-2 mt-4">

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

@endsection
@push('scripts')
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
@endpush

