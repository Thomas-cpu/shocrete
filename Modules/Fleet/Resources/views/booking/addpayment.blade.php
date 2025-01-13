{{ Form::open(['route' => ['Addpayment.store',$bookings->id], 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-6">
            {{ Form::label('total_payment', __('Total Payment'),['class'=>'col-form-label']) }}
            {{ Form::number('total_payment', $bookings->total_price, array('class' => 'form-control' ,'required'=>'required','disabled')) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('pending_amount', __('Pending Amount'),['class'=>'col-form-label']) }}
            {{ Form::number('pending_amount', $paid_amount, array('class' => 'form-control' ,'required'=>'required','disabled')) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('pay_amount', __('Pay Amount'),['class'=>'col-form-label']) }}
            {{ Form::number('pay_amount','', array('class' => 'form-control' ,'required'=>'required','placeholder'=>'Enter Pay Amount')) }}
        </div>
        <div class="form-group col-6">
            {{ Form::label('description', __('Description'),['class'=>'col-form-label']) }}
            {{ Form::textarea('description','', array('class' => 'form-control' ,'required'=>'required','placeholder'=>'Enter Payment Description','rows'=>2)) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary">{{__('Create')}}</button>
</div>

{{ Form::close() }}
