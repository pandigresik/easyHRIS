<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/careerHistories.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/careerHistories.fields.company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('company_id', $companyItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Department Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('department_id', __('models/careerHistories.fields.department_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('department_id', $departmentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Joblevel Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('joblevel_id', __('models/careerHistories.fields.joblevel_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('joblevel_id', $joblevelItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Jobtitle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('jobtitle_id', __('models/careerHistories.fields.jobtitle_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('jobtitle_id', $jobtitleItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Supervisor Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('supervisor_id', __('models/careerHistories.fields.supervisor_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('supervisor_id', $supervisorItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Contract Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('contract_id', __('models/careerHistories.fields.contract_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('contract_id', $contractItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/careerHistories.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('description', null, ['class' => 'form-control','maxlength' => 11,'maxlength' => 11, 'required' => 'required']) !!}
</div>
</div>
