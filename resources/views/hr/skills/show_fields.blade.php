<!-- Skill Group Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('skill_group_id', __('models/skills.fields.skill_group_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $skill->skill_group_id }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/skills.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $skill->name }}</p>
    </div>
</div>

