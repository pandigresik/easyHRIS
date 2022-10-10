<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/taxGroupHistories.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Old Tax Group Field -->
<div class="form-group row mb-3">
    {!! Form::label('old_tax_group', __('models/taxGroupHistories.fields.old_tax_group').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('old_tax_group', null, ['class' => 'form-control','maxlength' => 3,'maxlength' => 3, 'required' => 'required']) !!}
</div>
</div>

<!-- New Tax Group Field -->
<div class="form-group row mb-3">
    {!! Form::label('new_tax_group', __('models/taxGroupHistories.fields.new_tax_group').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('new_tax_group', null, ['class' => 'form-control','maxlength' => 3,'maxlength' => 3, 'required' => 'required']) !!}
</div>
</div>

<!-- Old Risk Ratio Field -->
<div class="form-group row mb-3">
    {!! Form::label('old_risk_ratio', __('models/taxGroupHistories.fields.old_risk_ratio').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('old_risk_ratio', null, ['class' => 'form-control','maxlength' => 3,'maxlength' => 3, 'required' => 'required']) !!}
</div>
</div>

<!-- New Risk Ratio Field -->
<div class="form-group row mb-3">
    {!! Form::label('new_risk_ratio', __('models/taxGroupHistories.fields.new_risk_ratio').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('new_risk_ratio', null, ['class' => 'form-control','maxlength' => 3,'maxlength' => 3, 'required' => 'required']) !!}
</div>
</div>
