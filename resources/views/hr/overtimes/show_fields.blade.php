<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/overtimes.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $overtime->employee_id }}</p>
    </div>
</div>

<!-- Shiftment Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_id', __('models/overtimes.fields.shiftment_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $overtime->shiftment_id }}</p>
    </div>
</div>

<!-- Approved By Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('approved_by_id', __('models/overtimes.fields.approved_by_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $overtime->approved_by_id }}</p>
    </div>
</div>

<!-- Overtime Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('overtime_date', __('models/overtimes.fields.overtime_date').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $overtime->overtime_date }}</p>
    </div>
</div>

<!-- Start Hour Field -->
<div class="form-group row mb-3">
    {!! Form::label('start_hour', __('models/overtimes.fields.start_hour').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $overtime->start_hour }}</p>
    </div>
</div>

<!-- End Hour Field -->
<div class="form-group row mb-3">
    {!! Form::label('end_hour', __('models/overtimes.fields.end_hour').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $overtime->end_hour }}</p>
    </div>
</div>

<!-- Raw Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('raw_value', __('models/overtimes.fields.raw_value').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $overtime->raw_value }}</p>
    </div>
</div>

<!-- Calculated Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('calculated_value', __('models/overtimes.fields.calculated_value').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $overtime->calculated_value }}</p>
    </div>
</div>

<!-- Holiday Field -->
<div class="form-group row mb-3">
    {!! Form::label('holiday', __('models/overtimes.fields.holiday').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $overtime->holiday }}</p>
    </div>
</div>

<!-- Overday Field -->
<div class="form-group row mb-3">
    {!! Form::label('overday', __('models/overtimes.fields.overday').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $overtime->overday }}</p>
    </div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/overtimes.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $overtime->description }}</p>
    </div>
</div>

