{{ Form::model($insurance, ['route' => ['insurance.update', $insurance->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('insurance_provider', __('Insurance Provider Name'), ['class' => 'col-form-label']) }}
                {{ Form::text('insurance_provider', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Insurance Provider Name']) }}   
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('vehicle_name', __('Vehicle Name'), ['class' => 'col-form-label']) }}
                {{ Form::select('vehicle_name', $vehicle, null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'col-form-label']) }}
                {{ Form::date('start_date', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'col-form-label']) }}
                {{ Form::date('end_date', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('scheduled_date', __('Recurring Date'), ['class' => 'col-form-label']) }}
                {{ Form::date('scheduled_date', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('scheduled_period', __('Recurring Period'), ['class' => 'col-form-label']) }}
                {{ Form::select('scheduled_period', $recurring, null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('deductible', __('Insurance Deductible'), ['class' => 'col-form-label']) }}
                {{ Form::number('deductible', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Deductible Number']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('charge_payable', __('Charge Payable'), ['class' => 'col-form-label']) }}
                {{ Form::number('charge_payable', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Charge Payable']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('policy_number', __('Policy Number'), ['class' => 'col-form-label']) }}
                {{ Form::number('policy_number', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Add Policy Number']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('policy_document', __('Policy Document'), ['class' => 'col-form-label']) }}
                <input type="file"name="policy_document" class="form-control mb-2"
                    onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                @php
                    if (check_file($insurance->policy_document) == false) {
                        $path = asset('Modules/Fleet/Resources/assets/image/img01.jpg');
                    } else {
                        $path = get_file($insurance->policy_document);
                    }
                @endphp
                <img id="blah" class="mt-2" width="25%" src="{{ $path }}" alt="your image" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('notes', __('Notes'), ['class' => 'col-form-label']) }}
                {{ Form::textarea('notes', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Add Remark', 'rows' => 3]) }}
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>

{{ Form::close() }}
