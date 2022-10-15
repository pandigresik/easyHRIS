<!-- Shiftment Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_id', __('models/shiftmentSchedules.fields.shiftment_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftmentSchedule->shiftment_id }}</p>
    </div>
</div>

<!-- Work Day Field -->
<div class="form-group row mb-3">
    {!! Form::label('work_day', __('models/shiftmentSchedules.fields.work_day').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftmentSchedule->work_day }}</p>
    </div>
</div>

<!-- Start Hour Field -->
<div class="form-group row mb-3">
    {!! Form::label('start_hour', __('models/shiftmentSchedules.fields.start_hour').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftmentSchedule->start_hour }}</p>
    </div>
</div>

<!-- End Hour Field -->
<div class="form-group row mb-3">
    {!! Form::label('end_hour', __('models/shiftmentSchedules.fields.end_hour').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftmentSchedule->end_hour }}</p>
    </div>
</div>

