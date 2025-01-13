@permission('helpdesk ticket show')
    <div class="action-btn bg-info ms-2">
        <a href="{{ route('helpdesk.edit', $ticket->id) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center"
            data-bs-toggle="tooltip" title="{{ __('Edit & Reply') }}"> <span class="text-white"> <i
                    class="ti ti-corner-up-left"></i></span></a>
    </div>

    <div class="action-btn bg-warning ms-2">
        <a href="{{ route('helpdesk.view', [\Illuminate\Support\Facades\Crypt::encrypt($ticket->ticket_id)]) }}"
            class="mx-3 btn btn-sm d-inline-flex align-items-center" data-bs-toggle="tooltip" title="{{ __('Details') }}">
            <span class="text-white"> <i class="ti ti-eye"></i></span></a>
    </div>
@endpermission
@permission('helpdesk ticket delete')
    @if (Auth::user()->id == $ticket->created_by || Auth::user()->type == 'super admin')
        <div class="action-btn bg-danger ms-2">
            <form method="POST" action="{{ route('helpdesk.destroy', $ticket->id) }}" id="user-form-{{ $ticket->id }}">
                @csrf
                @method('DELETE')
                <input name="_method" type="hidden" value="DELETE">
                <button type="button" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm"
                    data-bs-toggle="tooltip" title='{{__('Delete')}}'>
                    <span class="text-white"> <i class="ti ti-trash"></i></span>
                </button>
            </form>
        </div>
    @endif
@endpermission
