<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/attendanceLogfingers.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Type Absen Field -->
<div class="form-group row mb-3">
    {!! Form::label('type_absen', __('models/attendanceLogfingers.fields.type_absen').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('type_absen', null, ['class' => 'form-control','maxlength' => 1,'maxlength' => 1, 'required' => 'required']) !!}
</div>
</div>

<!-- Fingertime Field -->
<div class="form-group row mb-3">
    {!! Form::label('fingertime', __('models/attendanceLogfingers.fields.fingertime').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('fingertime', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'fingertime']) !!}
</div>
</div>

<!-- Fingerprint Device Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('fingerprint_device_id', __('models/attendanceLogfingers.fields.fingerprint_device_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('fingerprint_device_id', $fingerprintDeviceItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>
