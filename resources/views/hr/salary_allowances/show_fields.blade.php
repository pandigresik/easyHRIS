<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/salaryAllowances.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryAllowance->employee_id }}</p>
    </div>
</div>

<!-- Component Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('component_id', __('models/salaryAllowances.fields.component_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryAllowance->component_id }}</p>
    </div>
</div>

<!-- Year Field -->
<div class="form-group row mb-3">
    {!! Form::label('year', __('models/salaryAllowances.fields.year').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryAllowance->year }}</p>
    </div>
</div>

<!-- Month Field -->
<div class="form-group row mb-3">
    {!! Form::label('month', __('models/salaryAllowances.fields.month').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryAllowance->month }}</p>
    </div>
</div>

<!-- Benefit Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('benefit_value', __('models/salaryAllowances.fields.benefit_value').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryAllowance->benefit_value }}</p>
    </div>
</div>

<!-- Benefit Key Field -->
<div class="form-group row mb-3">
    {!! Form::label('benefit_key', __('models/salaryAllowances.fields.benefit_key').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryAllowance->benefit_key }}</p>
    </div>
</div>

