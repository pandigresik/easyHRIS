<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/shiftmentGroups.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftmentGroup->code }}</p>
    </div>
</div>

<!-- Company Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('company_id', __('models/shiftmentGroups.fields.company_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftmentGroup->company_id }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/shiftmentGroups.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $shiftmentGroup->name }}</p>
    </div>
</div>

