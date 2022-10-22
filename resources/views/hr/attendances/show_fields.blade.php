<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/attendances.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->employee_id }}</p>
    </div>
</div>

<!-- Shiftment Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_id', __('models/attendances.fields.shiftment_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->shiftment_id }}</p>
    </div>
</div>

<!-- Reason Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('reason_id', __('models/attendances.fields.reason_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->reason_id }}</p>
    </div>
</div>

<!-- Attendance Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('attendance_date', __('models/attendances.fields.attendance_date').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->attendance_date }}</p>
    </div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/attendances.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->description }}</p>
    </div>
</div>

<!-- Check In Schedule Field -->
<div class="form-group row mb-3">
    {!! Form::label('check_in_schedule', __('models/attendances.fields.check_in_schedule').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->check_in_schedule }}</p>
    </div>
</div>

<!-- Check Out Schedule Field -->
<div class="form-group row mb-3">
    {!! Form::label('check_out_schedule', __('models/attendances.fields.check_out_schedule').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->check_out_schedule }}</p>
    </div>
</div>

<!-- Check In Field -->
<div class="form-group row mb-3">
    {!! Form::label('check_in', __('models/attendances.fields.check_in').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->check_in }}</p>
    </div>
</div>

<!-- Check Out Field -->
<div class="form-group row mb-3">
    {!! Form::label('check_out', __('models/attendances.fields.check_out').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->check_out }}</p>
    </div>
</div>

<!-- Early In Field -->
<div class="form-group row mb-3">
    {!! Form::label('early_in', __('models/attendances.fields.early_in').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->early_in }}</p>
    </div>
</div>

<!-- Early Out Field -->
<div class="form-group row mb-3">
    {!! Form::label('early_out', __('models/attendances.fields.early_out').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->early_out }}</p>
    </div>
</div>

<!-- Late In Field -->
<div class="form-group row mb-3">
    {!! Form::label('late_in', __('models/attendances.fields.late_in').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->late_in }}</p>
    </div>
</div>

<!-- Late Out Field -->
<div class="form-group row mb-3">
    {!! Form::label('late_out', __('models/attendances.fields.late_out').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->late_out }}</p>
    </div>
</div>

<!-- Absent Field -->
<div class="form-group row mb-3">
    {!! Form::label('absent', __('models/attendances.fields.absent').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendance->absent }}</p>
    </div>
</div>

