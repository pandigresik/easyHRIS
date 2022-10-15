<!-- Parent Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('parent_id', __('models/companies.fields.parent_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('parent_id', $parentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Address Field -->
<div class="form-group row mb-3">
    {!! Form::label('address', __('models/companies.fields.address').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::textarea('address', null, ['class' => 'form-control','maxlength' => 255, 'rows' => 4, 'required' => 'required']) !!}
</div>
</div>

<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/companies.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('code', null, ['class' => 'form-control inputmask', 'data-optionmask' => json_encode(config('local.textmask.upper')),'maxlength' => 7, 'required' => 'required']) !!}
</div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/companies.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- Birth Day Field -->
<div class="form-group row mb-3">
    {!! Form::label('birth_day', __('models/companies.fields.birth_day').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('birth_day', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'birth_day']) !!}
</div>
</div>

<!-- Email Field -->
<div class="form-group row mb-3">
    {!! Form::label('email', __('models/companies.fields.email').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::email('email', null, ['class' => 'form-control inputmask', 'data-optionmask' => json_encode(config('local.textmask.email')),'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- Tax Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('tax_number', __('models/companies.fields.tax_number').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('tax_number', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>
