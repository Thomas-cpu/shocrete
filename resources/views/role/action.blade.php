<span>
    @permission('roles edit')
    <div class="action-btn bg-info ms-2">
        <a  data-url="{{ route('roles.edit',$role->id) }}" data-size="xl" data-ajax-popup="true" data-title="{{__('Update permission')}}" class="btn btn-outline btn-xs blue-madison" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
            <i class="ti ti-pencil text-white"></i>
        </a>
    </div>
    @endpermission
    @if (!in_array($role->name,\App\Models\User::$not_edit_role))
        @permission('roles delete')
            <div class="action-btn bg-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-describedby="tooltip434956">
                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id],'id'=>'delete-form-'.$role->id]) !!}

            <a type="submit" class="mx-3 btn btn-sm align-items-center show_confirm" data-toggle="tooltip" title="" data-bs-placement="top" data-original-title="{{__('Delete')}}">
                    <i class="ti ti-trash text-white"></i>
                </a>
                {!! Form::close() !!}
            </div>
        @endpermission
    @endif
</span>
