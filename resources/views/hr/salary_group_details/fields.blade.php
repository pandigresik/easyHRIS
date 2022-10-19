<!-- Component Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('component_id', __('models/salaryGroupDetails.fields.component_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('component_id', $componentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Salary Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('salary_group_id', __('models/salaryGroupDetails.fields.salary_group_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('salary_group_id', $salaryGroupItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Component Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('component_value', __('models/salaryGroupDetails.fields.component_value').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('component_value', null, ['class' => 'form-control inputmask', 'required' => 'required', 'data-optionmask' => json_encode(config('local.number.integer'))]) !!}
</div>
</div>
