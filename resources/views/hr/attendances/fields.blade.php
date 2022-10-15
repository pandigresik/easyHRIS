<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/attendances.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Shiftment Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_id', __('models/attendances.fields.shiftment_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('shiftment_id', $shiftmentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Reason Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('reason_id', __('models/attendances.fields.reason_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('reason_id', $absentReasonItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Attendance Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('attendance_date', __('models/attendances.fields.attendance_date').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('attendance_date', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'attendance_date']) !!}
</div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/attendances.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('description', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- Check In Field -->
<div class="form-group row mb-3">
    {!! Form::label('check_in', __('models/attendances.fields.check_in').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('check_in', null, ['class' => 'form-control datetime', 'required' => 'required', 'data-optiondate' => json_encode( ['timePicker' => true, 'locale' => ['format' => config('local.datetime_format_javascript') ]]) ]) !!}
</div>
</div>

<!-- Check Out Field -->
<div class="form-group row mb-3">
    {!! Form::label('check_out', __('models/attendances.fields.check_out').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('check_out', null, ['class' => 'form-control datetime', 'required' => 'required', 'data-optiondate' => json_encode( ['timePicker' => true, 'locale' => ['format' => config('local.datetime_format_javascript') ]]) ]) !!}
</div>
</div>

<!-- Early In Field -->
<div class="form-group row mb-3">
    {!! Form::label('early_in', __('models/attendances.fields.early_in').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('early_in', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Early Out Field -->
<div class="form-group row mb-3">
    {!! Form::label('early_out', __('models/attendances.fields.early_out').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('early_out', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Late In Field -->
<div class="form-group row mb-3">
    {!! Form::label('late_in', __('models/attendances.fields.late_in').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('late_in', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Late Out Field -->
<div class="form-group row mb-3">
    {!! Form::label('late_out', __('models/attendances.fields.late_out').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('late_out', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Absent Field -->
<div class="form-group row mb-3">
    {!! Form::label('absent', __('models/attendances.fields.absent').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    <label class="checkbox-inline">
        {!! Form::hidden('absent', 0) !!}
        {!! Form::checkbox('absent', '1', null) !!}
    </label>
</div>
</div>

