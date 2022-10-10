<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/settings.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50, 'required' => 'required']) !!}
</div>
</div>

<!-- Type Field -->
<div class="form-group row mb-3">
    {!! Form::label('type', __('models/settings.fields.type').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('type', null, ['class' => 'form-control','maxlength' => 20,'maxlength' => 20, 'required' => 'required']) !!}
</div>
</div>

<!-- Value Field -->
<div class="form-group row mb-3">
    {!! Form::label('value', __('models/settings.fields.value').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('value', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50, 'required' => 'required']) !!}
</div>
</div>
