<!-- Type Field -->
<div class="form-group row mb-3">
    {!! Form::label('type', __('models/absentReasons.fields.type').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('type', null, ['class' => 'form-control','maxlength' => 1,'maxlength' => 1, 'required' => 'required']) !!}
</div>
</div>

<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/absentReasons.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('code', null, ['class' => 'form-control inputmask','data-optionmask' => json_encode(config('local.textmask.upper')),'maxlength' => 7, 'required' => 'required']) !!}
</div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/absentReasons.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>
