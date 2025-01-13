{{Form::model($fuelType,array('route' => array('fuelType.update', $fuelType->id), 'method' => 'PUT')) }}

<div class="modal-body">
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('name', __('Fuel Type Name'),['class'=>'col-form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control','placeholder'=> 'Enter fuelType name' ,'required'=>'required')) }}
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}
