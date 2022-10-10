<!-- Short Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('short_name', __('models/educationTitles.fields.short_name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('short_name', null, ['class' => 'form-control','maxlength' => 5,'maxlength' => 5, 'required' => 'required']) !!}
</div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/educationTitles.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>
