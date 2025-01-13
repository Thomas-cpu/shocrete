@permission('bug show')
    <div class="action-btn bg-warning ms-2">
        <a data-size="lg"
            data-url="{{ route('projects.bug.report.show', [$bug->project_id, $bug->id]) }}"
            data-bs-toggle="tooltip" title="{{ __('View') }}"
            data-ajax-popup="true" data-title="{{ __('View') }}"
            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white ">
            <i class="ti ti-eye"></i>
        </a>
    </div>
@endpermission
@permission('bug edit')
    <div class="action-btn bg-info ms-2">
        <a data-ajax-popup="true" data-size="lg"
            data-url="{{ route('projects.bug.report.edit', [$bug->project_id, $bug->id]) }}"
            class="btn btn-sm d-inline-flex align-items-center text-white "
            data-bs-toggle="tooltip" data-title="{{ __('Task Edit') }}"
            title="{{ __('Edit') }}"><i class="ti ti-pencil"></i></a>

    </div>
@endpermission
@permission('bug delete')
    <div class="action-btn bg-danger ms-2">
        {!! Form::open(['method' => 'DELETE', 'route' => ['projects.bug.report.destroy', $bug->project_id, $bug->id]]) !!}
        <a href="#!"
            class="btn btn-sm   align-items-center text-white show_confirm"
            data-bs-toggle="tooltip" title='Delete'>
            <i class="ti ti-trash"></i>
        </a>
        {!! Form::close() !!}
    </div>
@endpermission
