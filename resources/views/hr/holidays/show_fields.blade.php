<!-- Holiday Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('holiday_date', __('models/holidays.fields.holiday_date').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $holiday->holiday_date }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/holidays.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $holiday->name }}</p>
    </div>
</div>

