<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/jobMutations.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Old Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('old_company_id', __('models/jobMutations.fields.old_company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('old_company_id', $oldCompanyItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Old Department Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('old_department_id', __('models/jobMutations.fields.old_department_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('old_department_id', $oldDepartmentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Old Joblevel Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('old_joblevel_id', __('models/jobMutations.fields.old_joblevel_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('old_joblevel_id', $oldJoblevelItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Old Jobtitle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('old_jobtitle_id', __('models/jobMutations.fields.old_jobtitle_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('old_jobtitle_id', $oldJobtitleItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Old Supervisor Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('old_supervisor_id', __('models/jobMutations.fields.old_supervisor_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('old_supervisor_id', $oldSupervisorItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- New Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('new_company_id', __('models/jobMutations.fields.new_company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('new_company_id', $newCompanyItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- New Department Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('new_department_id', __('models/jobMutations.fields.new_department_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('new_department_id', $newDepartmentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- New Joblevel Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('new_joblevel_id', __('models/jobMutations.fields.new_joblevel_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('new_joblevel_id', $newJoblevelItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- New Jobtitle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('new_jobtitle_id', __('models/jobMutations.fields.new_jobtitle_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('new_jobtitle_id', $newJobtitleItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- New Supervisor Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('new_supervisor_id', __('models/jobMutations.fields.new_supervisor_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('new_supervisor_id', $newSupervisorItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Contract Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('contract_id', __('models/jobMutations.fields.contract_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('contract_id', $contractItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Type Field -->
<div class="form-group row mb-3">
    {!! Form::label('type', __('models/jobMutations.fields.type').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('type', null, ['class' => 'form-control','maxlength' => 1,'maxlength' => 1, 'required' => 'required']) !!}
</div>
</div>
