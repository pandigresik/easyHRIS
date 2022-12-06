<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/salaryComponents.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('code', null, ['class' => 'form-control','maxlength' => 7,'maxlength' => 7, 'required' => 'required']) !!}
</div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/salaryComponents.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- State Field -->
<div class="form-group row mb-3">
    {!! Form::label('state', __('models/salaryComponents.fields.state').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('state', $stateItems, null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>
</div>

<!-- Fixed Field -->
<div class="form-group row mb-3">
    {!! Form::label('fixed', __('models/salaryComponents.fields.fixed').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    <label class="checkbox-inline">
        {!! Form::hidden('fixed', 0) !!}
        {!! Form::checkbox('fixed', '1', null) !!}
    </label>
</div>
</div>

