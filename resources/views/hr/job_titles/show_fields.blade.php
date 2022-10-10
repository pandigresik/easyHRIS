<!-- Job Level Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('job_level_id', __('models/jobTitles.fields.job_level_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $jobTitle->job_level_id }}</p>
    </div>
</div>

<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/jobTitles.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $jobTitle->code }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/jobTitles.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $jobTitle->name }}</p>
    </div>
</div>

