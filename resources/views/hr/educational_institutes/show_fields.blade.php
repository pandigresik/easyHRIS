<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/educationalInstitutes.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $educationalInstitute->name }}</p>
    </div>
</div>

