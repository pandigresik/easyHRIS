<!-- Parent Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('parent_id', __('models/departments.fields.parent_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $department->parent_id }}</p>
    </div>
</div>

<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/departments.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $department->code }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/departments.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $department->name }}</p>
    </div>
</div>

