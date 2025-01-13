{{ Form::open(['url' => 'vehicle', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('name', __('Vehicle Name'), ['class' => 'col-form-label']) }}
                {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Vehicle Name']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('vehicle_type', __('Vehicle Type'), ['class' => 'col-form-label']) }}
                {{ Form::select('vehicle_type', $vehicleTypes, null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('registration_date', __('Registration Date'), ['class' => 'col-form-label']) }}
                {{ Form::date('registration_date', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('register_ex_date', __('Register expiry date (Optional)'), ['class' => 'col-form-label']) }}
                {{ Form::date('register_ex_date', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('fuel_type', __('Fuel Type'), ['class' => 'col-form-label']) }}
                {{ Form::select('fuel_type', $fuelType, null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('driver_name', __('Driver Name'), ['class' => 'col-form-label']) }}
                {{ Form::select('driver_name', $DriverName, null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('lincense_plate', __('License Plate Number'), ['class' => 'col-form-label']) }}
                {{ Form::text('lincense_plate', null, ['class' => 'form-control', 'placeholder' => __('Enter License Plate Number'), 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('vehical_id_num', __('Vehicle Identification Number'), ['class' => 'col-form-label']) }}
                {{ Form::number('vehical_id_num', null, ['class' => 'form-control', 'placeholder' => __('Enter Vehicle Identification Number'), 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('model_year', __('Model Year'), ['class' => 'col-form-label']) }}
                {{ Form::selectYear('model_year', date('Y'), 0, date('Y'), ['class' => 'month-btn form-control month-btn']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('status', __('Status (Optional)'), ['class' => 'col-form-label']) }}
                {{ Form::select('status', ['Active' => 'Active', 'Inactive' => 'Inactive', 'Maintenance' => 'Maintenance'], null, ['class' => 'form-control', 'placeholder' => 'Select Vehicle Status']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('seat_capacity', __('Seat Capacity'), ['class' => 'col-form-label']) }}
                {{ Form::number('seat_capacity', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Seat Capacity ( With Driver )']) }}
            </div>
        </div>
        @if (module_is_active('CustomField') && !$customFields->isEmpty())
            <div class="col-md-6 col-form-label">
                <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                    @include('customfield::formBuilder')
                </div>
            </div>
        @endif
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>

{{ Form::close() }}
