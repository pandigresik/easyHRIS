<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/customers.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50, 'required' => 'required']) !!}
</div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/customers.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('description', null, ['class' => 'form-control','maxlength' => 100,'maxlength' => 100, 'required' => 'required']) !!}
</div>
</div>

<!-- Address Field -->
<div class="form-group row mb-3">
    {!! Form::label('address', __('models/customers.fields.address').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('address', null, ['class' => 'form-control','maxlength' => 100,'maxlength' => 100, 'required' => 'required']) !!}
</div>
</div>

<!-- User Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('user_id', __('models/customers.fields.user_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('user_id', $userItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>
