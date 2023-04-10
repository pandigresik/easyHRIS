<!-- Employee Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('employee_id', __('models/overtimes.fields.employee_id').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        @if(empty($employeeItems))
        {!! Form::select('employee_id[]', $employeeItems, null, array_merge(['class' => 'form-control
        select2','data-filter' => json_encode([]), 'data-url' => route('selectAjax'), 'data-repository' =>
        'Hr\\EmployeeShiftmentGroupRepository', 'multiple' => 'multiple'], config('local.select2.ajax')) ) !!}
        @else
        {!! Form::select('employee_id', $employeeItems, null, ['class' => 'form-control select2'] ) !!}
        @endif
    </div>
</div>

<!-- Approved By Id Field
<div class="form-group row mb-3">
    {!! Form::label('approved_by_id', __('models/overtimes.fields.approved_by_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {--!! Form::select('approved_by_id', $approvedByItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!--}
</div>
</div>
-->

<!-- Overtime Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('overtime_date', __('models/overtimes.fields.overtime_date').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::text('overtime_date', null, ['class' => 'form-control datetime', 'required' => 'required'
        , 'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript')
    ], 'minDate' => $minDate ?? 0, 'maxDate' => $maxDate ?? 0]),'id'=>'overtime_date']) !!}
    </div>
</div>

<!-- Start Hour Field -->
<div class="form-group row mb-3">
    {!! Form::label('start_hour', __('models/overtimes.fields.start_hour').':', ['class' => 'col-md-3 col-form-label'])
    !!}
    <div class="col-md-9">
        {!! Form::text('start_hour', null, ['class' => 'form-control inputmask', 'onchange' => 'updateInfoOvertime(this)', 'data-optionmask' =>
        json_encode(config('local.textmask.time-minute')), 'required' => 'required']) !!}
    </div>
</div>

<!-- End Hour Field -->
<div class="form-group row mb-3">
    {!! Form::label('end_hour', __('models/overtimes.fields.end_hour').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::text('end_hour', null, ['class' => 'form-control inputmask', 'onchange' => 'updateInfoOvertime(this)', 'data-optionmask' =>
        json_encode(config('local.textmask.time-minute')), 'required' => 'required']) !!}
    </div>
</div>

<!-- Breaktime Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('breaktime_value', __('models/overtimes.fields.breaktime_value').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        <div class="input-group">
            {!! Form::text('breaktime_value', null, ['class' => 'form-control inputmask', 'onchange' => 'updateInfoOvertime(this)', 'data-optionmask' =>
            json_encode(config('local.number.integer'))]) !!}
            <span class="input-group-text">Minute</span>
        </div>
        <div class="form-text text-danger" id="overtime-info">
            
        </div>
    </div>
</div>

@if (false)
<!-- Start Hour Real Field -->
<div class="form-group row mb-3">
    {!! Form::label('start_hour_real', __('models/overtimes.fields.start_hour_real').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::text('start_hour_real', null, ['class' => 'form-control inputmask', 'data-optionmask' =>
        json_encode(config('local.textmask.time'))]) !!}
    </div>
</div>

<!-- End Hour Real Field -->
<div class="form-group row mb-3">
    {!! Form::label('end_hour_real', __('models/overtimes.fields.end_hour_real').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::text('end_hour_real', null, ['class' => 'form-control inputmask', 'data-optionmask' =>
        json_encode(config('local.textmask.time'))]) !!}
    </div>
</div>

<!-- Raw Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('raw_value', __('models/overtimes.fields.raw_value').':', ['class' => 'col-md-3 col-form-label'])
    !!}
    <div class="col-md-9">
        <div class="input-group">
            {!! Form::text('raw_value', null, ['class' => 'form-control inputmask','data-optionmask' =>
            json_encode(config('local.number.integer'))]) !!}
            <span class="input-group-text">Minute</span>
        </div>
    </div>
</div>

<!-- Calculated Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('calculated_value', __('models/overtimes.fields.calculated_value').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        <div class="input-group">
            {!! Form::text('calculated_value', null, ['class' => 'form-control inputmask','data-optionmask' =>
            json_encode(config('local.number.integer'))]) !!}
            <span class="input-group-text">Minute</span>
        </div>
    </div>
</div>
@endif
<!-- Holiday Field -->
<div class="form-group row mb-3">
    {!! Form::label('holiday', __('models/overtimes.fields.holiday').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <label class="checkbox-inline">
            {!! Form::hidden('holiday', 0) !!}
            {!! Form::checkbox('holiday', '1', null) !!}
        </label>
        <span class="text-danger"> Pilih jika hari libur</span>
    </div>
</div>


<!-- Overday Field -->
<div class="form-group row mb-3" style="display:none">
    {!! Form::label('overday', __('models/overtimes.fields.overday').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <label class="checkbox-inline">
            {!! Form::hidden('overday', 0) !!}
            {!! Form::checkbox('overday', '1', null) !!}
        </label>        
    </div>
</div>


<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/overtimes.fields.description').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3, 'maxlength' => 255,'maxlength'
        => 255, 'required' => 'required']) !!}
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
    $(function(){
        updateInfoOvertime($('#breaktime_value'))
    })
    function updateInfoOvertime(elm){
        let _date = main.getValueDateSQL($('#overtime_date'))
        let _startHour = $('#start_hour').val()
        let _endHour = $('#end_hour').val()
        let _breaktime = $('#breaktime_value').val() || 0
        let _startDate, _endDate, _diffMinutes, _diffHours
        $('#overtime-info').html('Total overtime : -')
        if(!_.isEmpty(_date) && !_.isEmpty(_startHour) && !_.isEmpty(_endHour)){
            _startDate = moment(_date+' '+_startHour)
            _endDate = moment(_date+' '+_endHour)
            if(_startHour > _endHour){
                _endDate.add(1, 'day')
            }
            _endDate.subtract(_breaktime, 'minutes')
            _diffMinutes = _endDate.diff(_startDate, 'minutes')
            _diffHours = _endDate.diff(_startDate, 'hours', true)
            $('#overtime-info').html(`Total overtime : ${_diffHours} jam ( ${_diffMinutes} menit )`)
        }        
    }
    </script>
@endpush
