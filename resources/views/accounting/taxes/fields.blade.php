<!-- Period Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('period_id', __('models/taxes.fields.period_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('period_id', $payrollPeriodItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/taxes.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Tax Group Field -->
<div class="form-group row mb-3">
    {!! Form::label('tax_group', __('models/taxes.fields.tax_group').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('tax_group', null, ['class' => 'form-control','maxlength' => 3,'maxlength' => 3, 'required' => 'required']) !!}
</div>
</div>

<!-- Untaxable Field -->
<div class="form-group row mb-3">
    {!! Form::label('untaxable', __('models/taxes.fields.untaxable').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('untaxable', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Taxable Field -->
<div class="form-group row mb-3">
    {!! Form::label('taxable', __('models/taxes.fields.taxable').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('taxable', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Tax Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('tax_value', __('models/taxes.fields.tax_value').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('tax_value', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Tax Key Field -->
<div class="form-group row mb-3">
    {!! Form::label('tax_key', __('models/taxes.fields.tax_key').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('tax_key', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>
