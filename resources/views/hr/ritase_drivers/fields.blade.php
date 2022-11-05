<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/ritaseDrivers.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Work Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('work_date', __('models/ritaseDrivers.fields.work_date').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('work_date', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'work_date']) !!}
</div>
</div>

<!-- Km Field -->
<div class="form-group row mb-3">
    {!! Form::label('km', __('models/ritaseDrivers.fields.km').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('km', null, ['class' => 'form-control inputmask', 'data-unmask' => 1, 'data-optionmask' => json_encode(config('local.number.integer')), 'required' => 'required']) !!}
</div>
</div>

<!-- Double Rit Field -->
<div class="form-group row mb-3">
    {!! Form::label('double_rit', __('models/ritaseDrivers.fields.double_rit').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9">     
    {!! Form::text('double_rit', null, ['class' => 'form-control inputmask', 'data-unmask' => 1, 'data-optionmask' => json_encode(config('local.textmask.ritase')), 'required' => 'required']) !!}    
</div>
</div>

