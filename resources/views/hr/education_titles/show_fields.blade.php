<!-- Short Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('short_name', __('models/educationTitles.fields.short_name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $educationTitle->short_name }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/educationTitles.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $educationTitle->name }}</p>
    </div>
</div>

