@if (!empty($customer))
    {{ Form::model($customer, ['route' => ['fleet_customer.update', $customer->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
@else
    {{ Form::open(['route' => ['fleet_customer.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
@endif
@if (!empty($user->id))
    <input type="hidden" name="user_id" value="{{ $user->id }}">
@endif

<div class="modal-body">
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('name', __('Customer Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', !empty($customer) ? $customer->name : $user->name, ['class' => 'form-control', 'placeholder' => 'Enter Customer Name', 'required' => 'required']) }}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('phone', __('Mobile Number'), ['class' => 'col-form-label']) }}
            {{ Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Enter Customer Number', 'required' => 'required']) }}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('address', __('Address'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('address', null, ['class' => 'form-control', 'placeholder' => 'Enter Customer Address', 'required' => 'required', 'rows' => 3]) }}
        </div>
    </div>
    @if (!empty($customFields))
        @if (module_is_active('CustomField') && !$customFields->isEmpty())
            <div class="col-md-12">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('customfield::formBuilder', ['fildedata' => $customer->customField])
                </div>
            </div>
        @endif
    @endif
</div>

<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">
</div>
