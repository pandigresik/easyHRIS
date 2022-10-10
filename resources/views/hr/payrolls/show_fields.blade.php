<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/payrolls.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payroll->employee_id }}</p>
    </div>
</div>

<!-- Payroll Period Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('payroll_period_id', __('models/payrolls.fields.payroll_period_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payroll->payroll_period_id }}</p>
    </div>
</div>

<!-- Take Home Pay Field -->
<div class="form-group row mb-3">
    {!! Form::label('take_home_pay', __('models/payrolls.fields.take_home_pay').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payroll->take_home_pay }}</p>
    </div>
</div>

<!-- Take Home Pay Key Field -->
<div class="form-group row mb-3">
    {!! Form::label('take_home_pay_key', __('models/payrolls.fields.take_home_pay_key').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $payroll->take_home_pay_key }}</p>
    </div>
</div>

