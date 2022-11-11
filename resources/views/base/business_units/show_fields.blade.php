<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/businessUnits.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $businessUnit->code }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/businessUnits.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $businessUnit->name }}</p>
    </div>
</div>

