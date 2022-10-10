<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/careerHistories.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $careerHistory->employee_id }}</p>
    </div>
</div>

<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/careerHistories.fields.company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $careerHistory->company_id }}</p>
    </div>
</div>

<!-- Department Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('department_id', __('models/careerHistories.fields.department_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $careerHistory->department_id }}</p>
    </div>
</div>

<!-- Joblevel Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('joblevel_id', __('models/careerHistories.fields.joblevel_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $careerHistory->joblevel_id }}</p>
    </div>
</div>

<!-- Jobtitle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('jobtitle_id', __('models/careerHistories.fields.jobtitle_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $careerHistory->jobtitle_id }}</p>
    </div>
</div>

<!-- Supervisor Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('supervisor_id', __('models/careerHistories.fields.supervisor_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $careerHistory->supervisor_id }}</p>
    </div>
</div>

<!-- Contract Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('contract_id', __('models/careerHistories.fields.contract_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $careerHistory->contract_id }}</p>
    </div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/careerHistories.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $careerHistory->description }}</p>
    </div>
</div>

