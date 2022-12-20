<!-- Shiftment Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('shiftment_id', __('models/shiftmentSchedules.fields.shiftment_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('shiftment_id', $shiftmentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Work Day Field -->
<div class="form-group row mb-3">
    {!! Form::label('work_day', __('models/shiftmentSchedules.fields.work_day').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('work_day', $workdayItems, null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Start Hour Field -->
<div class="form-group row mb-3">
    {!! Form::label('start_hour', __('models/shiftmentSchedules.fields.start_hour').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('start_hour', null, ['class' => 'form-control inputmask', 'data-optionmask' =>  json_encode(config('local.textmask.time')) ,'required' => 'required']) !!}
</div>
</div>

<!-- End Hour Field -->
<div class="form-group row mb-3">
    {!! Form::label('end_hour', __('models/shiftmentSchedules.fields.end_hour').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('end_hour', null, ['class' => 'form-control inputmask', 'data-optionmask' =>  json_encode(config('local.textmask.time')) ,'required' => 'required']) !!}
</div>
</div>

<!-- next_day Field -->
<div class="form-group row mb-3">
    {!! Form::label('next_day', __('models/overtimes.fields.next_day').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    <label class="checkbox-inline">
        {!! Form::hidden('next_day', 0) !!}
        {!! Form::checkbox('next_day', '1', null) !!}
    </label>
</div>
</div>