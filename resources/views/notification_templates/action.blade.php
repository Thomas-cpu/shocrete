<div class="action-btn bg-warning ms-2">
    <a href="{{ route('notification-template.show', [$Notification->id, getActiveLanguage()]) }}"
        class="mx-3 btn btn-sm d-inline-flex align-items-center"
        data-bs-toggle="tooltip" data-bs-placement="top"
        title="{{ __('Manage Your ' . $Notification->type  . ' Message') }}">
        <i class="ti ti-eye text-white"></i>
    </a>
</div>
