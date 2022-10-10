<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/salaryGroups.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryGroup->code }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/salaryGroups.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $salaryGroup->name }}</p>
    </div>
</div>

