<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/employeeShiftments.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $employeeShiftment->employee_id }}</p>
    </div>
</div>

<!-- Shiftment Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_group_id', __('models/employeeShiftments.fields.shiftment_group_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $employeeShiftment->shiftment_group_id }}</p>
    </div>
</div>

<!-- Active Field -->
<div class="form-group row mb-3">
    {!! Form::label('active', __('models/employeeShiftments.fields.active').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $employeeShiftment->active }}</p>
    </div>
</div>

