<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/attendanceSummaries.fields.employee_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendanceSummary->employee_id }}</p>
    </div>
</div>

<!-- Year Field -->
<div class="form-group row mb-3">
    {!! Form::label('year', __('models/attendanceSummaries.fields.year').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendanceSummary->year }}</p>
    </div>
</div>

<!-- Month Field -->
<div class="form-group row mb-3">
    {!! Form::label('month', __('models/attendanceSummaries.fields.month').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendanceSummary->month }}</p>
    </div>
</div>

<!-- Total Workday Field -->
<div class="form-group row mb-3">
    {!! Form::label('total_workday', __('models/attendanceSummaries.fields.total_workday').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendanceSummary->total_workday }}</p>
    </div>
</div>

<!-- Total In Field -->
<div class="form-group row mb-3">
    {!! Form::label('total_in', __('models/attendanceSummaries.fields.total_in').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendanceSummary->total_in }}</p>
    </div>
</div>

<!-- Total Loyality Field -->
<div class="form-group row mb-3">
    {!! Form::label('total_loyality', __('models/attendanceSummaries.fields.total_loyality').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendanceSummary->total_loyality }}</p>
    </div>
</div>

<!-- Total Absent Field -->
<div class="form-group row mb-3">
    {!! Form::label('total_absent', __('models/attendanceSummaries.fields.total_absent').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendanceSummary->total_absent }}</p>
    </div>
</div>

<!-- Total Overtime Field -->
<div class="form-group row mb-3">
    {!! Form::label('total_overtime', __('models/attendanceSummaries.fields.total_overtime').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $attendanceSummary->total_overtime }}</p>
    </div>
</div>

