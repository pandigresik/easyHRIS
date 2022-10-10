<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/salaryBenefits.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryBenefit->employee_id }}</p>
    </div>
</div>

<!-- Component Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('component_id', __('models/salaryBenefits.fields.component_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryBenefit->component_id }}</p>
    </div>
</div>

<!-- Benefit Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('benefit_value', __('models/salaryBenefits.fields.benefit_value').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryBenefit->benefit_value }}</p>
    </div>
</div>

<!-- Benefit Key Field -->
<div class="form-group row mb-3">
    {!! Form::label('benefit_key', __('models/salaryBenefits.fields.benefit_key').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryBenefit->benefit_key }}</p>
    </div>
</div>

