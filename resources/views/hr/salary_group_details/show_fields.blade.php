<!-- Component Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('component_id', __('models/salaryGroupDetails.fields.component_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryGroupDetail->component_id }}</p>
    </div>
</div>

<!-- Salary Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('salary_group_id', __('models/salaryGroupDetails.fields.salary_group_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryGroupDetail->salary_group_id }}</p>
    </div>
</div>

<!-- Component Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('component_value', __('models/salaryGroupDetails.fields.component_value').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryGroupDetail->component_value }}</p>
    </div>
</div>

