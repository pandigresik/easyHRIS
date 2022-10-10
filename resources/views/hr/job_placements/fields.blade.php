<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/jobPlacements.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/jobPlacements.fields.company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('company_id', $companyItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Department Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('department_id', __('models/jobPlacements.fields.department_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('department_id', $departmentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Joblevel Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('joblevel_id', __('models/jobPlacements.fields.joblevel_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('joblevel_id', $joblevelItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Jobtitle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('jobtitle_id', __('models/jobPlacements.fields.jobtitle_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('jobtitle_id', $jobtitleItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Supervisor Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('supervisor_id', __('models/jobPlacements.fields.supervisor_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('supervisor_id', $supervisorItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Contract Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('contract_id', __('models/jobPlacements.fields.contract_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('contract_id', $contractItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Active Field -->
<div class="form-group row mb-3">
    {!! Form::label('active', __('models/jobPlacements.fields.active').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    <label class="checkbox-inline">
        {!! Form::hidden('active', 0) !!}
        {!! Form::checkbox('active', '1', null) !!}
    </label>
</div>
</div>

