
@permission('deal show')
    @if($deal->is_active)
            <div class="action-btn bg-warning ms-2">
            <a href="{{route('deals.show',$deal->id)}}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-toggle="tooltip" data-original-title="{{__('View Deal')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('View Deal')}}"><i class="ti ti-eye text-white"></i></a>
        </div>
    @endif
@endpermission
@permission('deal edit')
    <div class="action-btn bg-info ms-2">
        <a data-size="lg" data-url="{{ URL::to('deals/'.$deal->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Deal')}}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Edit Deal')}}" ><i class="ti ti-pencil text-white"></i></a>
    </div>
@endpermission
@permission('deal delete')
    <div class="action-btn bg-danger ms-2">
        {!! Form::open(['method' => 'DELETE', 'route' => ['deals.destroy', $deal->id]]) !!}
            <a href="#!" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Delete Deal')}}"  data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}">
                <span class="text-white"> <i class="ti ti-trash"></i></span></a>
        {!! Form::close() !!}
    </div>
@endpermission