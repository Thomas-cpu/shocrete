{{Form::open(array('url'=>'insurance','method'=>'post', 'enctype'=>'multipart/form-data'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('insurance_provider', __('Insurance Provider Name'),['class'=>'col-form-label']) }}
                {{ Form::text('insurance_provider', null, array('class' => 'form-control','required'=>'required','placeholder'=>'Enter Insurance Provider Name')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('vehicle_name', __('Vehicle Name'),['class'=>'col-form-label']) }}
                {{ Form::select('vehicle_name', $vehicle, null, array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'),['class'=>'col-form-label']) }}
                {{ Form::date('start_date', null, array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'),['class'=>'col-form-label']) }}
                {{ Form::date('end_date', null, array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('scheduled_date', __('Recurring Date'),['class'=>'col-form-label']) }}
                {{ Form::date('scheduled_date', null, array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('scheduled_period', __('Recurring Period'),['class'=>'col-form-label']) }}
                {{ Form::select('scheduled_period', $recurring, null, array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('deductible', __('Insurance Deductible'),['class'=>'col-form-label']) }}
                {{ Form::number('deductible', null, array('class' => 'form-control','required'=>'required','placeholder'=>'Enter Insurance Deductible Number')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('charge_payable', __('Charge Payable'),['class'=>'col-form-label']) }}
                {{ Form::number('charge_payable', null, array('class' => 'form-control','required'=>'required','placeholder'=>'Charge Payable')) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('policy_number', __('Policy Number'),['class'=>'col-form-label']) }}
                {{ Form::number('policy_number', null, array('class' => 'form-control','required'=>'required','placeholder'=>'Add Policy Number','minlength'=>"10")) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('policy_document', __('Policy Document'), ['class' => 'col-form-label']) }}
                <div class="choose-file form-group">
                    <label for="file" class="form-label">
                        <input type="file" name="policy_document" id="policy_document" class="form-control" accept="image/*," onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])" required>
                        <img src="" id="blah2" class="mt-2" width="25%"/>
                    </label>
                    {{-- <p class="upload_file"></p> --}}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('notes', __('Note'),['class'=>'col-form-label']) }}
                {{ Form::textarea('notes', null, array('class' => 'form-control','required'=>'required','placeholder'=>'Add Note','rows'=>3)) }}
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
</div>

{{Form::close()}}

