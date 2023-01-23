<!-- Connection Field -->
<div class="form-group row mb-3">
    {!! Form::label('connection', __('models/failedJobs.fields.connection').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $failedJob->connection }}</p>
    </div>
</div>

<!-- Queue Field -->
<div class="form-group row mb-3">
    {!! Form::label('queue', __('models/failedJobs.fields.queue').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $failedJob->queue }}</p>
    </div>
</div>

<!-- Payload Field -->
<div class="form-group row mb-3">
    {!! Form::label('payload', __('models/failedJobs.fields.payload').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $failedJob->payload }}</p>
    </div>
</div>

<!-- Exception Field -->
<div class="form-group row mb-3">
    {!! Form::label('exception', __('models/failedJobs.fields.exception').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $failedJob->exception }}</p>
    </div>
</div>

<!-- Failed At Field -->
<div class="form-group row mb-3">
    {!! Form::label('failed_at', __('models/failedJobs.fields.failed_at').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $failedJob->failed_at }}</p>
    </div>
</div>

