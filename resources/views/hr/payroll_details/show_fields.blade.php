<!-- Payroll Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('payroll_id', __('models/payrollDetails.fields.payroll_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollDetail->payroll_id }}</p>
    </div>
</div>

<!-- Component Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('component_id', __('models/payrollDetails.fields.component_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollDetail->component_id }}</p>
    </div>
</div>

<!-- Benefit Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('benefit_value', __('models/payrollDetails.fields.benefit_value').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollDetail->benefit_value }}</p>
    </div>
</div>

<!-- Benefit Key Field -->
<div class="form-group row mb-3">
    {!! Form::label('benefit_key', __('models/payrollDetails.fields.benefit_key').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payrollDetail->benefit_key }}</p>
    </div>
</div>

