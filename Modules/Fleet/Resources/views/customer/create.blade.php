{{ Form::open(['url' => 'fleet_customer','enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('name', __('Customer Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Enter customer name', 'required' => 'required']) }}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('email', __('Email'), ['class' => 'col-form-label']) }}
            {{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Enter Customer Email', 'required' => 'required']) }}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('phone', __('Mobile Number'), ['class' => 'col-form-label']) }}
            {{ Form::text('phone', '', ['class' => 'form-control', 'placeholder' => 'Enter Customer Number', 'required' => 'required']) }}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('address', __('Address'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('address', '', ['class' => 'form-control', 'placeholder' => 'Enter address', 'required' => 'required', 'rows' => 3]) }}
        </div>
    </div>
    <div class="row">
        @if (module_is_active('CustomField') && !$customFields->isEmpty())
            <div class="form-group col-12">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('customfield::formBuilder')
                </div>
            </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <button type="submit" class="btn  btn-primary">{{ __('Create') }}</button>
</div>

{{ Form::close() }}
