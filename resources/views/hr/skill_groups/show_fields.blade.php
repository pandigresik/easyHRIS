<!-- Parent Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('parent_id', __('models/skillGroups.fields.parent_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $skillGroup->parent_id }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/skillGroups.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $skillGroup->name }}</p>
    </div>
</div>

