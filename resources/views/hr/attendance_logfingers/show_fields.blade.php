<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/attendanceLogfingers.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendanceLogfinger->employee_id }}</p>
    </div>
</div>

<!-- Type Absen Field -->
<div class="form-group row mb-3">
    {!! Form::label('type_absen', __('models/attendanceLogfingers.fields.type_absen').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendanceLogfinger->type_absen }}</p>
    </div>
</div>

<!-- Fingertime Field -->
<div class="form-group row mb-3">
    {!! Form::label('fingertime', __('models/attendanceLogfingers.fields.fingertime').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendanceLogfinger->fingertime }}</p>
    </div>
</div>

<!-- Fingerprint Device Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('fingerprint_device_id', __('models/attendanceLogfingers.fields.fingerprint_device_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendanceLogfinger->fingerprint_device_id }}</p>
    </div>
</div>

