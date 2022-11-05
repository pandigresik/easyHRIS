<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/ritaseDrivers.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $ritaseDriver->employee_id }}</p>
    </div>
</div>

<!-- Work Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('work_date', __('models/ritaseDrivers.fields.work_date').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $ritaseDriver->work_date }}</p>
    </div>
</div>

<!-- Km Field -->
<div class="form-group row mb-3">
    {!! Form::label('km', __('models/ritaseDrivers.fields.km').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $ritaseDriver->km }}</p>
    </div>
</div>

<!-- Double Rit Field -->
<div class="form-group row mb-3">
    {!! Form::label('double_rit', __('models/ritaseDrivers.fields.double_rit').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $ritaseDriver->double_rit }}</p>
    </div>
</div>

