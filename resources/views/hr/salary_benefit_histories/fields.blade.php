<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/salaryBenefitHistories.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Component Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('component_id', __('models/salaryBenefitHistories.fields.component_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('component_id', $componentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Contract Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('contract_id', __('models/salaryBenefitHistories.fields.contract_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('contract_id', $contractItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- New Benefit Value Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('new_benefit_value', __('models/salaryBenefitHistories.fields.new_benefit_value').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('new_benefit_value', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Old Benefit Value Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('old_benefit_value', __('models/salaryBenefitHistories.fields.old_benefit_value').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('old_benefit_value', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Benefit Key Field -->
<div class="form-group row mb-3">
    {!! Form::label('benefit_key', __('models/salaryBenefitHistories.fields.benefit_key').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('benefit_key', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/salaryBenefitHistories.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('description', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>
