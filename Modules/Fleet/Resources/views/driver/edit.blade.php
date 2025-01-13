@if (!empty($driver))
    {{ Form::model($driver, ['route' => ['driver.update', $driver->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
@else
    {{ Form::open(['route' => ['driver.store'], 'method' => 'post']) }}
@endif
@if (!empty($user->id))
    <input type="hidden" name="user_id" value="{{ $user->id }}">
@endif

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">

                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    <span><i class="ti ti-address-card"></i></span>
                    {{-- {{Form::text('name',!empty($driver)? $driver->name : $user->name,array('class'=>'form-control','required'=>'required'))}} --}}
                    {!! Form::text('name', !empty($user->name) ? $user->name : '', [
                        'class' => 'form-control',
                        'required' => 'required',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('phone', __('Mobile Number'), ['class' => 'form-label']) }}
                {{ Form::text('phone', null, ['class' => 'form-control', 'placeholder' => __('Enter Driver Number'), 'required' => 'required']) }}
                @error('phone')
                    <small class="invalid-phone" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('dob', __('Date of Birth'), ['class' => 'form-label']) !!}
                {{ Form::date('dob', null, ['class' => 'form-control current_date', 'required' => 'required', 'autocomplete' => 'off', 'placeholder' => 'Select Date of Birth']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('join_date', __('Join Date'), ['class' => 'form-label']) !!}
                {{ Form::date('join_date', null, ['class' => 'form-control current_date', 'required' => 'required', 'autocomplete' => 'off', 'placeholder' => 'Select join date']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('lincese_number', __('Licence Number'), ['class' => 'form-label']) }}
                {{ Form::text('lincese_number', null, ['class' => 'form-control', 'placeholder' => __('Enter Licence Number'), 'required' => 'required']) }}
                @error('lincese_number')
                    <small class="invalid-lincese_number" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </small>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('lincese_type', __('Licence Type'), ['class' => 'form-label']) }}
                {{ Form::select('lincese_type', $lincese_type, null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('expiry_date', __('Licence Expire Date'), ['class' => 'form-label']) !!}
                {{ Form::date('expiry_date', null, ['class' => 'form-control current_date', 'required' => 'required', 'autocomplete' => 'off', 'placeholder' => 'Select Issue Date']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('driver_status', __('Driver Status'), ['class' => 'form-label']) }}
                {{ Form::select('driver_status', ['Active' => 'Active', 'Inactive' => 'Inactive'], null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Select Driver Status']) }}

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('Working_time', __('Working Time'), ['class' => 'form-label']) !!}
                {{ Form::text('Working_time', isset($driver->Working_time) ? $driver->Working_time : '', ['class' => 'form-control current_date', 'required' => 'required', 'pattern' => '^(0?[1-9]|1[0-2]):[0-5][0-9](AM|PM)\s-\s(0?[1-9]|1[0-2]):[0-5][0-9](AM|PM)$', 'placeholder' => '10:00AM - 6:00PM']) }}
            </div>
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('address', __('Address'), ['class' => 'form-label']) !!}
            {!! Form::textarea('address', null, [
                'class' => 'form-control',
                'placeholder' => __('Enter Driver Address'),
                'required' => 'required',
                'rows' => 3,
            ]) !!}
        </div>
        @if (!empty($customFields))
            @if (module_is_active('CustomField') && !$customFields->isEmpty())
                <div class="col-md-12">
                    <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                        @include('customfield::formBuilder', ['fildedata' => $driver->customField])
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">
</div>

{{ Form::close() }}

<script>
    $(function() {
        $('input[id="daterange"]').daterangepicker({
            opens: 'left',
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 1,
            timePickerSeconds: true,
            locale: {
                format: 'HH:mm:ss'
            }
        }, function(start, end, label) {
            console.log("A new time selection was made: " + start.format('HH:mm:ss') + ' to ' + end
                .format('HH:mm:ss'));
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        });;
    });
</script>
