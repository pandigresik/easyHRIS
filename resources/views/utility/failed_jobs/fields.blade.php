<!-- Connection Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('connection', __('models/failedJobs.fields.connection').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('connection', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Queue Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('queue', __('models/failedJobs.fields.queue').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('queue', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Payload Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('payload', __('models/failedJobs.fields.payload').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('payload', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Exception Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('exception', __('models/failedJobs.fields.exception').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('exception', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Failed At Field -->
<div class="form-group row mb-3">
    {!! Form::label('failed_at', __('models/failedJobs.fields.failed_at').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('failed_at', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'failed_at']) !!}
</div>
</div>
