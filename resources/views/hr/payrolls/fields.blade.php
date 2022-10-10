<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/payrolls.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Payroll Period Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('payroll_period_id', __('models/payrolls.fields.payroll_period_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('payroll_period_id', $payrollPeriodItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Take Home Pay Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('take_home_pay', __('models/payrolls.fields.take_home_pay').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('take_home_pay', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Take Home Pay Key Field -->
<div class="form-group row mb-3">
    {!! Form::label('take_home_pay_key', __('models/payrolls.fields.take_home_pay_key').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('take_home_pay_key', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>
