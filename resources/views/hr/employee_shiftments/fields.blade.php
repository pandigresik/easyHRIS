<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/employeeShiftments.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Shiftment Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_group_id', __('models/employeeShiftments.fields.shiftment_group_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('shiftment_group_id', $shiftmentGroupItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Active Field -->
<div class="form-group row mb-3">
    {!! Form::label('active', __('models/employeeShiftments.fields.active').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('active', null, ['class' => 'form-control','maxlength' => 1,'maxlength' => 1, 'required' => 'required']) !!}
</div>
</div>
