<!-- Queue Field -->
<div class="form-group row mb-3">
    {!! Form::label('queue', __('models/jobs.fields.queue').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $job->queue }}</p>
    </div>
</div>

<!-- Payload Field -->
<div class="form-group row mb-3">
    {!! Form::label('payload', __('models/jobs.fields.payload').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $job->payload }}</p>
    </div>
</div>

<!-- Attempts Field -->
<div class="form-group row mb-3">
    {!! Form::label('attempts', __('models/jobs.fields.attempts').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $job->attempts }}</p>
    </div>
</div>

<!-- Reserved At Field -->
<div class="form-group row mb-3">
    {!! Form::label('reserved_at', __('models/jobs.fields.reserved_at').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $job->reserved_at }}</p>
    </div>
</div>

<!-- Available At Field -->
<div class="form-group row mb-3">
    {!! Form::label('available_at', __('models/jobs.fields.available_at').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $job->available_at }}</p>
    </div>
</div>

