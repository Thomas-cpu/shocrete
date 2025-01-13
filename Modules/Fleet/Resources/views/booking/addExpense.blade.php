{{ Form::open(['route' => ['AddExpense.store',$id], 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('amount', __('Total Amount'), ['class' => 'col-form-label']) }}
            {{ Form::number('amount', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Expense Amount']) }}
        </div>
        <div class="form-group col-12">
            {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('description', '', ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Expense Description', 'rows' => 2]) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <button type="submit" class="btn  btn-primary">{{ __('Create') }}</button>
</div>
{{ Form::close() }}
