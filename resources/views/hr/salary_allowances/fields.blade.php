<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/salaryAllowances.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Component Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('component_id', __('models/salaryAllowances.fields.component_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('component_id', $componentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Year Field -->
<div class="form-group row mb-3">
    {!! Form::label('year', __('models/salaryAllowances.fields.year').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('year', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Month Field -->
<div class="form-group row mb-3">
    {!! Form::label('month', __('models/salaryAllowances.fields.month').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('month', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Benefit Value Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('benefit_value', __('models/salaryAllowances.fields.benefit_value').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('benefit_value', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Benefit Key Field -->
<div class="form-group row mb-3">
    {!! Form::label('benefit_key', __('models/salaryAllowances.fields.benefit_key').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('benefit_key', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>
