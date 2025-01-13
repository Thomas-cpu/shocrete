{{ Form::open(array('url' => 'fuel')) }}
<div class="modal-body">
    <div class="row">
        @if(\Auth::user()->type != "driver")
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('driver_name', __('Driver Name'),['class'=>'col-form-label']) }}
                    {{ Form::select('driver_name', $driver, null, array('class' => 'form-control','required'=>'required')) }}
                </div>
            </div>
        @endif
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('vehicle_name', __('Vehicle Name'),['class'=>'col-form-label']) }}
                {{ Form::select('vehicle_name', $vehicle, null, array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('fuel_type', __('Fuel Type'),['class'=>'col-form-label']) }}
                {{ Form::select('fuel_type', $fuelType, null, array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div>
        <div class="form-group col-md-6  mb-1">
            <label for="datetime" class="col-form-label">{{ __('Fueling Date and Time') }}</label>
            <input class="form-control" value="{{ date('Y-m-d h:i') }}" placeholder="{{ __('Select Fueling Date and Time') }}"
                required="required" name="fill_date" type="datetime-local">
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('quantity', __('Gallons/Liters of Fuel'),['class'=>'col-form-label']) }}
                {{ Form::text('quantity', null, array('class' => 'form-control','required'=>'required','placeholder'=>'Enter Gallons/Liters of Fuel')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('cost', __('Cost per Gallon/Liter'),['class'=>'col-form-label']) }}
                {{ Form::number('cost', null, array('class' => 'form-control','required'=>'required','placeholder'=>'Enter Cost per Gallon/Liter')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('total_cost', __('Total Cost'),['class'=>'col-form-label']) }}
                {{ Form::number('total_cost', null, array('class' => 'form-control','required'=>'required','placeholder'=>'Enter Total Cost')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('odometer_reading', __('Odometer Reading'),['class'=>'col-form-label']) }}
                {{ Form::text('odometer_reading', null, array('class' => 'form-control','required'=>'required','placeholder'=>'Enter Odometer Reading')) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('notes', __('Notes'),['class'=>'col-form-label']) }}
                {{ Form::textarea('notes', null, array('class' => 'form-control','required'=>'required','placeholder'=>'Add Notes','rows'=>3)) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary">{{__('Create')}}</button>
</div>

{{ Form::close() }}
