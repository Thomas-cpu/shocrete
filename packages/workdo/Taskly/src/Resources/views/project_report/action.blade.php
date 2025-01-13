@permission('task manage')
<div class="action-btn bg-warning ms-2">
    <a  class=" btn btn-sm d-inline-flex align-items-center text-white " data-toggle="tooltip"  title="{{__('view')}}" data-size="lg" data-title="{{__('view')}}" href="{{route('project_report.show', [$project->id])}}"><i class="ti ti-eye"></i></a>
</div>
@endpermission
