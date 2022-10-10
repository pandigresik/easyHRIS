<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/jobPlacements.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $jobPlacement->employee_id }}</p>
    </div>
</div>

<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/jobPlacements.fields.company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $jobPlacement->company_id }}</p>
    </div>
</div>

<!-- Department Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('department_id', __('models/jobPlacements.fields.department_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $jobPlacement->department_id }}</p>
    </div>
</div>

<!-- Joblevel Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('joblevel_id', __('models/jobPlacements.fields.joblevel_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $jobPlacement->joblevel_id }}</p>
    </div>
</div>

<!-- Jobtitle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('jobtitle_id', __('models/jobPlacements.fields.jobtitle_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $jobPlacement->jobtitle_id }}</p>
    </div>
</div>

<!-- Supervisor Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('supervisor_id', __('models/jobPlacements.fields.supervisor_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $jobPlacement->supervisor_id }}</p>
    </div>
</div>

<!-- Contract Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('contract_id', __('models/jobPlacements.fields.contract_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $jobPlacement->contract_id }}</p>
    </div>
</div>

<!-- Active Field -->
<div class="form-group row mb-3">
    {!! Form::label('active', __('models/jobPlacements.fields.active').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $jobPlacement->active }}</p>
    </div>
</div>

