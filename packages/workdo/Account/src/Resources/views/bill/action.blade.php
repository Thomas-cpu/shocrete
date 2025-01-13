@if (Laratrust::hasPermission('bill edit') ||
        Laratrust::hasPermission('bill delete') ||
        Laratrust::hasPermission('bill show') ||
        Laratrust::hasPermission('bill duplicate'))

    <span>
        <div class="action-btn bg-primary ms-2">
            <a href="#" class="btn btn-sm  align-items-center cp_link"
                data-link="{{ route('pay.billpay', \Illuminate\Support\Facades\Crypt::encrypt($bill->id)) }}"
                data-bs-toggle="tooltip" title="{{ __('Copy') }}"
                data-original-title="{{ __('Click to copy Bill link') }}">
                <i class="ti ti-file text-white"></i>
            </a>
        </div>
        @permission('bill duplicate')
            <div class="action-btn bg-secondary ms-2">
                {!! Form::open([
                    'method' => 'get',
                    'route' => ['bill.duplicate', $bill->id],
                    'id' => 'duplicate-form-' . $bill->id,
                ]) !!}
                <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip"
                    title="" data-bs-original-title="{{ __('Duplicate') }}" aria-label="Delete"
                    data-text="{{ __('You want to confirm duplicate this invoice. Press Yes to continue or Cancel to go back') }}"
                    data-confirm-yes="duplicate-form-{{ $bill->id }}">
                    <i class="ti ti-copy text-white text-white"></i>
                </a>
                {{ Form::close() }}
            </div>
        @endpermission
        @permission('bill show')
            <div class="action-btn bg-warning ms-2">
                <a href="{{ route('bill.show', \Crypt::encrypt($bill->id)) }}" class="mx-3 btn btn-sm align-items-center"
                    data-bs-toggle="tooltip" title="{{ __('Show') }}" data-original-title="{{ __('Detail') }}">
                    <i class="ti ti-eye text-white"></i>
                </a>
            </div>
        @endpermission
        @if (module_is_active('ProductService') && $bill->bill_module == 'taskly'
                ? module_is_active('Taskly')
                : module_is_active('Account'))
            @permission('bill edit')
                <div class="action-btn bg-info ms-2">
                    <a href="{{ route('bill.edit', \Crypt::encrypt($bill->id)) }}"
                        class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip" title="Edit"
                        data-original-title="{{ __('Edit') }}">
                        <i class="ti ti-pencil text-white"></i>
                    </a>
                </div>
            @endpermission
        @endif
        @permission('bill delete')
            <div class="action-btn bg-danger ms-2">
                {{ Form::open(['route' => ['bill.destroy', $bill->id], 'class' => 'm-0']) }}
                @method('DELETE')
                <a class="mx-3 btn btn-sm  align-items-center bs-pass-para show_confirm" data-bs-toggle="tooltip"
                    title="" data-bs-original-title="Delete" aria-label="Delete"
                    data-confirm="{{ __('Are You Sure?') }}"
                    data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                    data-confirm-yes="delete-form-{{ $bill->id }}"><i
                        class="ti ti-trash text-white text-white"></i></a>
                {{ Form::close() }}
            </div>
        @endpermission
    </span>

@endif



