<!-- Queue Field -->
<div class="form-group row mb-3">
    {!! Form::label('queue', __('models/jobs.fields.queue').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('queue', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- Payload Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('payload', __('models/jobs.fields.payload').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('payload', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Attempts Field -->
<div class="form-group row mb-3">
    {!! Form::label('attempts', __('models/jobs.fields.attempts').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    <label class="checkbox-inline">
        {!! Form::hidden('attempts', 0) !!}
        {!! Form::checkbox('attempts', '1', null) !!}
    </label>
</div>
</div>


<!-- Reserved At Field -->
<div class="form-group row mb-3">
    {!! Form::label('reserved_at', __('models/jobs.fields.reserved_at').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('reserved_at', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Available At Field -->
<div class="form-group row mb-3">
    {!! Form::label('available_at', __('models/jobs.fields.available_at').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::number('available_at', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>
